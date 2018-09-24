<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Admin_Controller {

    public function __construct(){
        parent::__construct();
 
         /* Load :: Common */
        $this->lang->load('admin/category');
        $this->load->model('admin/category_model', 'modelcategories');
        $this->categories = $this->modelcategories->list_categories();

        /* Title Page :: Common */
        $this->page_title->push(lang('menu_categories'));
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, lang('menu_categories'), 'admin/category');
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

             /* Get all categories */
            $this->data['categories'] = $this->categories;

            /* Load Template */
            $this->template->admin_render('admin/category/index', $this->data);

        }
    }


    public function create()
	{
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_categories_create'), 'admin/category/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

		/* Validate form input */
        $this->form_validation->set_rules('titulo', 'lang:category_titulo', 'required|is_unique[categoria.cat_titulo]');

		if ($this->form_validation->run() == TRUE)
		{
            $titulo = strtolower($this->input->post('titulo'));
            if($this->modelcategories->save($titulo)){
                redirect('admin/category/index', 'refresh');
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
            $this->template->admin_render('admin/category/create', $this->data);
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
            $this->modelcategories->delete($id);
            redirect('admin/category/index', 'refresh');
        }
    }
    
    public function edit($id)
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin() OR ! $id OR empty($id))
		{
			redirect('auth', 'refresh');
		}

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_categories_edit'), 'admin/category/edit');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        $this->data['categories'] = $this->modelcategories->list_category($id);
            
        
        /* Load Template */
        $this->template->admin_render('admin/category/edit', $this->data);
	}

    public function save_changes(){

        /* Validate form input */
        $this->form_validation->set_rules('titulo', 'lang:category_titulo', 'required|is_unique[categoria.cat_titulo]');

        if ($this->form_validation->run() == TRUE)
		{
            $titulo = strtolower($this->input->post('titulo'));
            $id     = $this->input->post("id");
            
            if($this->modelcategories->edit($titulo, $id)){
                redirect('admin/category/index', 'refresh');
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