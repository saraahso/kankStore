<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('categories_model', 'modelcategories');
        $this->categories = $this->modelcategories->list_categories();

        /* Load :: Common */
        $this->lang->load('admin/category');

        /* Title Page :: Common */
        $this->page_title->push(lang('menu_categories'));
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, lang('menu_categories'), 'admin/category');
    }

	public function index()
	{
        $this->load->library('table');
        $dados['categories']= $this->categories;
        
        /* Title Page */
        $this->page_title->push(lang('menu_dashboard'));
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

         /* Load Template */
        $this->template->admin_render('admin/category/index', $this->data);
        
    }


    public function create()
	{
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_users_create'), 'admin/category/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* Variables */
		$tables = $this->config->item('tables', 'ion_auth');

		/* Validate form input */
		$this->form_validation->set_rules('txt-category', 'Nome da Categoria',
        'required|min_length[3]|is_unique[category.titulo]');

		if ($this->form_validation->run() == TRUE)
		{
			$titulo = strtolower($this->input->post('titulo'));

			$additional_data = array(
				'titulo' => $this->input->post('titulo'),
			);
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
    
    public function delete()
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
            $this->load->view('admin/category/delete');
        }
    }
    

    public function excluir($id){

        if($this->modelcategories->excluir($id)){
            redirect(base_url('admin_kankStore/category'));
        }else{
            echo "Houve um erro no sistema!";
        }
    }

    public function edit($id)
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin() OR ! $id OR empty($id))
		{
			redirect('auth', 'refresh');
		}

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_category_edit'), 'admin/category/edit');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* Variables */
		$category = $this->ion_auth->category($id)->row();

		/* Validate form input */
        $this->form_validation->set_rules('titulo', $this->lang->line('edit_category_validation_titulo_label'), 'required|alpha_dash');

		if (isset($_POST) && ! empty($_POST))
		{
			if ($this->form_validation->run() == TRUE)
			{
				$category_update = $this->ion_auth->update_category($id, $_POST['titulo']);

				if ($category_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_category_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}

				redirect('admin/category', 'refresh');
			}
		}

        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        $this->data['category']   = $category;

		$readonly = $this->config->item('admin_category', 'ion_auth') === $category->titulo ? 'readonly' : '';

		$this->data['titulo'] = array(
			'type'    => 'text',
			'name'    => 'titulo',
			'id'      => 'titulo',
			'value'   => $this->form_validation->set_value('titulo', $category->name),
            'class'   => 'form-control',
			$readonly => $readonly
		);
	

        /* Load Template */
        $this->template->admin_render('admin/category/edit', $this->data);
	}

    public function alterar($id){

        $this->load->library('table');
        $dados['categories']= $this->modelcategories->listar_category($id);
        // Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel Administrativo';
        $dados['subtitulo'] = 'Categoria';

        $this->load->view('backend/template/html-header',$dados);
        $this->load->view('backend/template/template');
        $this->load->view('backend/alterar-category');
        $this->load->view('backend/template/html-footer');

    }
    
    public function salvar_alteracoes(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt-category', 'Nome da Categoria',
            'required|min_length[3]|is_unique[category.titulo]');
        if ($this->form_validation->run() == FALSE){
            $this->index();
        }else{
            $titulo= $this->input->post('txt-category');
            $id=$this->input->post('txt-id');
            if($this->modelcategories->alterar($titulo, $id)){
                redirect(base_url('admin_kankStore/category'));
            }else{
                echo "Houve um erro no sistema!";
            }
        }
    }
    
}