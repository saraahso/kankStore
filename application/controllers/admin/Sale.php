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
              'codigo'      =>$row->prod_codigo,
              'id'          =>$row->prod_id,
              'tamanho'     =>$row->prod_tamanho,
              'cor'         =>$row->prod_cor,
              'estoque'     =>$row->prod_estoque,
              'preco'       =>$row->prod_valor_de_venda,
            );

            //validação estoque
            if($row->prod_estoque >= 1){
                echo json_encode($result_array);
            }else{
                echo 'Não há Produto';
            }
        }
      }
    }

    public function create(){
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_sales_create'), 'admin/sale/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        
        $this->form_validation->set_rules('total', 'lang:sale_total', 'required');
        $this->form_validation->set_rules('date', 'lang:ven_date', 'required');
        
       
        if ($this->form_validation->run() == TRUE)
		{
            
            $date   = $this->input->post('date');
            $total  = $this->input->post('total');
            $tipoPagamento = $this->input->post('tipoPagamento');
            for( $i=0; $i<count($_POST['idproduct']); $i++ )
            {
                $idproduct  = $_POST['idproduct'][$i];
                $quantity   = $_POST['quantity'][$i];
                $totalprice = $_POST['totalprice'][$i];
                $stock = $_POST['stock'][$i];
            }
            

            
            if($this->modelsales->save($date, $total, $tipoPagamento)){
                $idvenda = $this->modelsales->lastID();    
                $this->modelsales->saveItem($idproduct, $idvenda, $quantity, $totalprice);
                $this->modelsales->updateProduct($idproduct, $quantity, $stock);
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
             $this->data['tipoPagamento'] = array(
                'dinheiro'  => 'Dinheiro',
                'debito'    => 'Cartão de Débito',
                'credito'   => 'Cartão de Crédito',
				
            );           
            $this->data['total'] = array(
				'name'          => 'total',
				'id'            => 'total',
                'type'          => 'text',
                'placeholder'   => '0.00',
                'readonly'      =>'true',
                'class'         => 'form-control',
				'value'         => $this->form_validation->set_value('total'),
            );
         
            
            /* Load Template */
		    $this->template->admin_render('admin/sale/create', $this->data);
        }
     
    }


    public function see($id)
	{
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_sale_see'), 'admin/sale/see');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        $this->data['products'] = $this->products;
        $this->data['sales'] = $this->modelsales->list_sale($id);
        foreach ($this->data['sales'] as $k => $info)
        {
            $this->data['sales'][$k]->products = $this->modelsales->list_products_sale($id);
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
            $this->modelsales->deleteItem($id);
            $this->modelsales->delete($id);
            redirect('admin/sale/index', 'refresh');
        }
    }
    
   
}