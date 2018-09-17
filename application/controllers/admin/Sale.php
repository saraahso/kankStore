<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends Admin_Controller {

    public function __construct(){
        parent::__construct();
 
         /* Load :: Common */
        $this->lang->load('admin/sale');
        
        $this->load->model('admin/sale_model', 'modelsales');
        $this->sales = $this->modelsales->list_sales();

        $this->load->model('admin/product_model', 'modelproducts');
        $this->products = $this->modelproducts->list_products();

        /* Title Page :: Common */
        $this->page_title->push(lang('menu_sales'));
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, lang('menu_sales'), 'admin/sale');
    }

	public function index()
	{
               
        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

             /* Get all sales */
            $this->data['products'] = $this->products;
            $this->data['sales'] = $this->sales;

            /* Load Template */
            $this->template->admin_render('admin/sale/index', $this->data);

        }
    }


    public function getproducts(){
		//$valor = $this->input->post("valor");
		//$products = $this->modelsales->getproducts($valor);
       //echo json_encode($products);

       if (isset($_GET['term'])) {
        $result = $this->modelsales->getproducts($_GET['term']);
        if (count($result) > 0) {
          foreach ($result as $row)
          $result_array[] = array(
              'label'       =>$row->prod_nome,
              'codigo'         =>$row->prod_codigo,
              'tamanho'         =>$row->prod_tamanho,
              'cor'         =>$row->prod_cor,
              'estoque'     =>$row->prod_estoque,
              'preco'     =>$row->prod_valor_de_venda,
            );
          echo json_encode($result_array);
        }
      }
    }

    public function create(){
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_sales_create'), 'admin/sale/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        
        $this->form_validation->set_rules('date', 'lang:ven_date', 'required|date_valid');
        $this->form_validation->set_rules('date', 'lang:ven_date', 'required|date_valid');
        
       
        if ($this->form_validation->run() == TRUE)
		{
            $date = date("Y-m-d");
            $idproduct      = $this->input->post('idproduct');
            $total          = $this->input->post('total');
            $quantity       = $this->input->post('quantity');
            $totalprice     = $this->input->post('totalprice');

            if($this->modelsales->save($date, $total) && $this->modelsales->saveItem($idproduct,$quantity,$totalprice) ){
                $this->modelsales->updateProduct($idproduct, $quantity);
                redirect('admin/sale/index', 'refresh');
            }else{
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            }
		}
		else
		{
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            
            $date = date("Y-m-d");
            $this->data['quantity'] = array(
				'name'  => 'quantity',
				'id'    => 'quantity',
				'type'  => 'text',
                'class' => 'form-control',
				'value' => $this->form_validation->set_value('quantity'),
            );
            $this->data['titleP'] = array(
				'name'  => 'titleP',
				'id'    => 'titleP',
				'type'  => 'text',
                'class' => 'form-control',
				'value' => $this->form_validation->set_value('titleP'),
            );
            $this->data['idproduct'] = array(
				'name'  => 'idproduct',
				'id'    => 'idproduct',
				'type'  => 'text',
                'class' => 'form-control',
				'value' => $this->form_validation->set_value('idproduct'),
            );
            $this->data['total'] = array(
				'name'  => 'total',
				'id'    => 'total',
                'type'  => 'text',
                'placeholder' => '0.00',
                'readonly'=>'true',
                'class' => 'form-control',
				'value' => $this->form_validation->set_value('total'),
            );
         
            
            /* Load Template */
		    $this->template->admin_render('admin/sale/create', $this->data);
        }

        
       
    }

    public function add_product(){

            $this->data['products'] = $this->products;
        
            $itv_valor     = $this->input->post('itv_valor');
            $itv_qtd        = $this->input->post('itv_qtd');
            $itv_cod_prod             = $this->input->post("itv_cod_prod");
            
            if($this->modelsales->add_sale($itv_valor,$itv_qtd,$itv_cod_prod)){
                redirect('admin/sale/create', 'refresh');
            }else{
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            }
		
    }

    public function see($id)
	{
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_sale_see'), 'admin/sale/see');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* Data */
        $id = (int) $id;

        $this->data['sale_info'] = $this->modelsales->list_sale($id);
        foreach ($this->data['sale_info'] as $k => $info)
        {
            $this->data['sale_info'][$k]->products = $this->modelsales->list_products_sale($info->ven_id)->result();
        }

        /* Load Template */
		$this->template->admin_render('admin/sale/see', $this->data);
    }
    
    
    public function delete($id)
	{
        if ( ! $this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif ( ! $this->ion_auth->is_admin())
		{
            return show_error('You must be an administrator to view this page.');
        }
        else
        {
            $this->modelsales->delete($id);
            redirect('admin/sale/index', 'refresh');
        }
    }
    
    public function edit($id)
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin() OR ! $id OR empty($id))
		{
			redirect('auth', 'refresh');
        }
        

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_sales_edit'), 'admin/sale/edit');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        $this->data['sales'] = $this->modelsales->list_sale($id);
        $this->data['brands'] = $this->brands;
        $this->data['categories'] = $this->categories;
            
        
        /* Load Template */
        $this->template->admin_render('admin/sale/edit', $this->data);
	}

    public function save_changes(){


       /* Validate form input */
        $this->form_validation->set_rules('name', 'lang:sale_name', 'required');
        $this->form_validation->set_rules('size', 'lang:sale_size');
        $this->form_validation->set_rules('color', 'lang:sale_color');
        $this->form_validation->set_rules('stock', 'lang:sale_stock', 'required');
        //$this->form_validation->set_rules('categoria', 'lang:sale_category', 'required');
        //$this->form_validation->set_rules('marca', 'lang:sale_brand');
        $this->form_validation->set_rules('cost_value', 'lang:sale_cost_value', 'required');
        $this->form_validation->set_rules('sell_value', 'lang:sale_sell_value', 'required');

        if ($this->form_validation->run() == TRUE)
		{
            $name           = $this->input->post('name');
            $size           = $this->input->post('size');
            $color          = $this->input->post('color');
            $stock          = $this->input->post('stock');
            $category       = $this->input->post('categories');
            $brand          = $this->input->post('brands');
            $cost_value     = $this->input->post('cost_value');
            $sell_value     = $this->input->post('sell_value');
            $id             = $this->input->post("id");
            
            if($this->modelsales->edit($name,$size,$color,$stock,$category,$brand,$cost_value,$sell_value)){
                redirect('admin/sale/index', 'refresh');
            }else{
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            }
		}
		else
		{
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        }

    }
    
}