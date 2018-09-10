<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends Admin_Controller {

    public function __construct(){
        parent::__construct();
 
         /* Load :: Common */
        $this->lang->load('admin/brand');
        $this->load->model('admin/brand_model', 'modelbrands');
        $this->brands = $this->modelbrands->list_brands();

        /* Title Page :: Common */
        $this->page_title->push(lang('menu_brands'));
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, lang('menu_brands'), 'admin/brand');
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

             /* Get all brands */
            $this->data['brands'] = $this->brands;

            /* Load Template */
            $this->template->admin_render('admin/brand/index', $this->data);

        }
    }


    public function create()
	{
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_brands_create'), 'admin/brand/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

		/* Validate form input */
        $this->form_validation->set_rules('titulo', 'lang:brand_titulo', 'required|is_unique[marca.mar_titulo]');

		if ($this->form_validation->run() == TRUE)
		{
            $titulo = strtolower($this->input->post('titulo'));
            if($this->modelbrands->save($titulo)){
                redirect('admin/brand/index', 'refresh');
            }else{
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            }
		}
		else
		{
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['titulo'] = array(
				'name'  => 'titulo',
				'id'    => 'titulo',
				'type'  => 'text',
                'class' => 'form-control',
				'value' => $this->form_validation->set_value('titulo'),
			);
			
            /* Load Template */
            $this->template->admin_render('admin/brand/create', $this->data);
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
            $this->modelbrands->delete($id);
            redirect('admin/brand/index', 'refresh');
        }
    }
    
    public function edit($id)
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin() OR ! $id OR empty($id))
		{
			redirect('auth', 'refresh');
		}

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_brands_edit'), 'admin/brand/edit');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        $this->data['brands'] = $this->modelbrands->list_brand($id);
            
        
        /* Load Template */
        $this->template->admin_render('admin/brand/edit', $this->data);
	}

    public function save_changes(){

        /* Validate form input */
        $this->form_validation->set_rules('titulo', 'lang:brand_titulo', 'required|is_unique[marca.mar_titulo]');

        if ($this->form_validation->run() == TRUE)
		{
            $titulo = strtolower($this->input->post('titulo'));
            $id     = $this->input->post("id");
            
            if($this->modelbrands->edit($titulo, $id)){
                redirect('admin/brand/index', 'refresh');
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