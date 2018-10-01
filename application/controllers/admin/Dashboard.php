<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/dashboard_model');
    }


	public function index()
	{
        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            /* Title Page */
            $this->page_title->push(lang('menu_dashboard'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['count_users']      = $this->dashboard_model->get_count_record('users');
            $this->data['count_sale']       = $this->dashboard_model->get_count_record('venda');
            $this->data['count_products']   = $this->dashboard_model->get_count_record('produto');
            $this->data['count_sale_day']   = $this->dashboard_model->get_sale_day('venda');
            $this->data['years']            = $this->dashboard_model->years();
            $this->data['months']           = $this->dashboard_model->months();
            $this->data['sales']            = $this->dashboard_model->custo_venda();
            

            /* Load Template */
            $this->template->admin_render('admin/dashboard/index', $this->data);
        }
    }

    public function getData(){
        $year           = $this->input->post("year");
		$resultados     = $this->dashboard_model->amount($year);
		echo json_encode($resultados);
    }
    
}
