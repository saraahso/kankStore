<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Admin_Controller {

    public function __construct(){
        parent::__construct();
 
         /* Load :: Common */
        $this->lang->load('admin/product');
        
        $this->load->model('admin/product_model', 'modelproducts');
        $this->products = $this->modelproducts->list_products();

        $this->load->model('admin/category_model', 'modelcategories');
        $this->categories = $this->modelcategories->list_categories();

        $this->load->model('admin/brand_model', 'modelbrands');
        $this->brands = $this->modelbrands->list_brands();

        /* Title Page :: Common */
        $this->page_title->push(lang('menu_products'));
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, lang('menu_products'), 'admin/product');
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

             /* Get all products */
            $this->data['products'] = $this->products;
            $this->data['brands'] = $this->brands;
            $this->data['categories'] = $this->categories;

            /* Load Template */
            $this->template->admin_render('admin/product/index', $this->data);

        }
    }


    public function create()
	{
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_products_create'), 'admin/product/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();


		/* Validate form input */
        $this->form_validation->set_rules('name', 'lang:product_name', 'required');
        $this->form_validation->set_rules('size', 'lang:product_size');
        $this->form_validation->set_rules('color', 'lang:product_color');
        $this->form_validation->set_rules('stock', 'lang:product_stock', 'required');
        //$this->form_validation->set_rules('categoria', 'lang:product_category', 'required');
        //$this->form_validation->set_rules('marca', 'lang:product_brand');
        $this->form_validation->set_rules('cost_value', 'lang:product_cost_value', 'required');
        $this->form_validation->set_rules('sell_value', 'lang:product_sell_value', 'required');

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

            if($this->modelproducts->save($name,$size,$color,$stock,$category,$brand,$cost_value,$sell_value)){
                redirect('admin/product/index', 'refresh');
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
            $this->template->admin_render('admin/product/create', $this->data);
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
            $this->modelproducts->delete($id);
            redirect('admin/product/index', 'refresh');
        }
    }
    
    public function edit($id)
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin() OR ! $id OR empty($id))
		{
			redirect('auth', 'refresh');
		}

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_products_edit'), 'admin/product/edit');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        $this->data['products'] = $this->modelproducts->list_product($id);
            
        
        /* Load Template */
        $this->template->admin_render('admin/product/edit', $this->data);
	}

    public function save_changes(){

       /* Validate form input */
        $this->form_validation->set_rules('name', 'lang:product_name', 'required');
        $this->form_validation->set_rules('size', 'lang:product_size');
        $this->form_validation->set_rules('color', 'lang:product_color');
        $this->form_validation->set_rules('stock', 'lang:product_stock', 'required');
        //$this->form_validation->set_rules('categoria', 'lang:product_category', 'required');
        //$this->form_validation->set_rules('marca', 'lang:product_brand');
        $this->form_validation->set_rules('cost_value', 'lang:product_cost_value', 'required');
        $this->form_validation->set_rules('sell_value', 'lang:product_sell_value', 'required');

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
            $id             = $this->input->post("id");
            
            if($this->modelproducts->edit($name,$size,$color,$stock,$category,$brand,$cost_value,$sell_value)){
                redirect('admin/product/index', 'refresh');
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