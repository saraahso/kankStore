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
    
    public function getProductName(){
        $keyword=$this->input->post('keyword');
        $data=$this->product->autocomplete_product($keyword);        
        echo json_encode($data);
    }

    public function create()
	{
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_sales_create'), 'admin/sale/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();


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
            $category       = $this->input->post('category');
            $brand          = $this->input->post('brand');
            $cost_value     = $this->input->post('cost_value');
            $sell_value     = $this->input->post('sell_value');

            if($this->modelsales->save($name,$size,$color,$stock,$category,$brand,$cost_value,$sell_value)){
                redirect('admin/sale/index', 'refresh');
            }else{
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            }
		}
		else
		{
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            
            $this->data['name'] = array(
				'name'  => 'name',
				'id'    => 'name',
				'type'  => 'text',
                'class' => 'form-control',
				'value' => $this->form_validation->set_value('name'),
            );
            $this->data['size'] = array(
				'name'  => 'size',
				'id'    => 'size',
				'type'  => 'text',
                'class' => 'form-control',
				'value' => $this->form_validation->set_value('size'),
            );
            $this->data['color'] = array(
				'name'  => 'color',
				'id'    => 'color',
				'type'  => 'text',
                'class' => 'form-control',
				'value' => $this->form_validation->set_value('color'),
            );
            $this->data['stock'] = array(
				'name'  => 'stock',
				'id'    => 'stock',
				'type'  => 'text',
                'class' => 'form-control',
				'value' => $this->form_validation->set_value('stock'),
            );
            $this->data['categories'] = $this->categories;
            $this->data['brands'] = $this->brands;
            
            $this->data['cost_value'] = array(
				'name'  => 'cost_value',
				'id'    => 'cost_value',
				'type'  => 'text',
                'class' => 'form-control',
				'value' => $this->form_validation->set_value('cost_value'),
            );
            $this->data['sell_value'] = array(
				'name'  => 'sell_value',
				'id'    => 'sell_value',
				'type'  => 'text',
                'class' => 'form-control',
				'value' => $this->form_validation->set_value('sell_value'),
            );
            
            
            /* Load Template */
            $this->template->admin_render('admin/sale/create', $this->data);
        }
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