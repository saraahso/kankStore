<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }

	public function index()
	{
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin_kankStore/login'));
        }

        $this->load->library('table');
        $this->load->model('usuarios_model', "modelusuarios");
        $dados['usuarios']=$this->modelusuarios->listar_autores();
        // Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel Administrativo';
        $dados['subtitulo'] = 'Usuarios';

        $this->load->view('backend/template/html-header',$dados);
        $this->load->view('backend/template/template');
        $this->load->view('backend/usuarios');
        $this->load->view('backend/template/html-footer');
        
    }

    public function pag_login(){

        // Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel Administrativo';
        $dados['subtitulo'] = 'Entrar no sistema';

        $this->load->view('backend/template/html-header',$dados);
        $this->load->view('backend/login');
        $this->load->view('backend/template/html-footer');
    }

    public function login(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt-user', 'Usuário', 'required|min_length[3]');
        $this->form_validation->set_rules('txt-senha', 'Senha', 'required|min_length[3]');
        if ($this->form_validation->run() == FALSE){
            $this->pag_login();
        }else{
           $usuario=$this->input->post('txt-user');
           $senha=$this->input->post('txt-senha');
           $this->db->where('user', $usuario);
           $this->db->where('senha', md5($senha));
           $userlogado = $this->db->get('usuario')->result();
           if(count($userlogado)==1){
               $dadosSessao['userlogado'] = $userlogado[0];
               $dadosSessao['logado']=TRUE;
               $this->session->set_userdata($dadosSessao);
               redirect(base_url('admin_kankStore'));
           }else{
            $dadosSessao['userlogado'] = NULL;
            $dadosSessao['logado']=FALSE;
            $this->session->set_userdata($dadosSessao);
            redirect(base_url('admin_kankStore/login'));
           }
        }
    }
    
    public function logout(){
        $dadosSessao['userlogado'] = NULL;
        $dadosSessao['logado']=FALSE;
        $this->session->set_userdata($dadosSessao);
        redirect(base_url('admin_kankStore/login'));
    }

    public function inserir(){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin_kankStore/login'));
        }
        $this->load->model('usuarios_model', "modelusuarios");
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt-nome', 'Nome do Usuário',
            'required|min_length[3]');
        $this->form_validation->set_rules('txt-email', 'Email',
            'required|valid_email');
        $this->form_validation->set_rules('txt-user', 'Login do Usuário',
            'required|min_length[3]|is_unique[usuario.user]');
        $this->form_validation->set_rules('txt-senha', 'Senha do Usuário',
            'required|min_length[3]');
        $this->form_validation->set_rules('txt-confir-senha', 'Confirmar Senha',
            'required|matches[txt-senha]');
        if ($this->form_validation->run() == FALSE){
            $this->index();
        }else{
            $nome= $this->input->post('txt-nome');
            $email= $this->input->post('txt-email');
            $user= $this->input->post('txt-user');
            $senha= $this->input->post('txt-senha');
            if($this->modelusuarios->adicionar($nome, $email, $user, $senha)){
                redirect(base_url('admin_kankStore/usuarios'));
            }else{
                echo "Houve um erro no sistema!";
            }
        }
    }

    public function excluir($id){
        $this->load->model('usuarios_model', "modelusuarios");

        if($this->modelusuarios->excluir($id)){
            redirect(base_url('admin_kankStore/usuarios'));
        }else{
            echo "Houve um erro no sistema!";
        }
    }

    public function alterar($id){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin_kankStore/login'));
        }
        $this->load->model('usuarios_model', "modelusuarios");

        $dados['usuarios']= $this->modelusuarios->listar_usuario($id);
        // Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel Administrativo';
        $dados['subtitulo'] = 'Usuário';

        $this->load->view('backend/template/html-header',$dados);
        $this->load->view('backend/template/template');
        $this->load->view('backend/alterar-usuario');
        $this->load->view('backend/template/html-footer');

    }
    
    public function salvar_alteracoes(){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin_kankStore/login'));
        }
        $this->load->library('form_validation');
        $this->load->model('usuarios_model', "modelusuarios");
        $this->form_validation->set_rules('txt-nome', 'Nome do Usuário',
            'required|min_length[3]');
        $this->form_validation->set_rules('txt-email', 'Email',
            'required|valid_email');
        $this->form_validation->set_rules('txt-user', 'Login do Usuário',
            'required|min_length[3]|is_unique[usuario.user]');
        $this->form_validation->set_rules('txt-senha', 'Senha do Usuário',
            'required|min_length[3]');
        $this->form_validation->set_rules('txt-confir-senha', 'Confirmar Senha',
            'required|matches[txt-senha]');
        if ($this->form_validation->run() == FALSE){
            $this->index();
        }else{
            $nome= $this->input->post('txt-nome');
            $email= $this->input->post('txt-email');
            $user= $this->input->post('txt-user');
            $senha= $this->input->post('txt-senha');
            $id=$this->input->post('txt-id');
            if($this->modelusuarios->alterar($nome, $email, $user, $senha, $id)){
                redirect(base_url('admin_kankStore/usuarios'));
            }else{
                echo "Houve um erro no sistema!";
            }
        }
    }

    //upload imagem pela library CodeIgniter   
    public function nova_foto(){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin_kankStore/login'));
        }
        $this->load->model('usuarios_model', "modelusuarios");

        $id= $this->input->post('id');
        $config['upload_path']      = './assets/frontend/img/usuarios';
        $config['file_name']        = $id.".png";
        $config['allowed_types']    = 'gif|jpg|png';
        $config['max_size']         = 100;
        $config['overwrite']        = TRUE;
        $this->load->library('upload', $config);

        if(!$this->upload->do_upload()){
            echo $this->upload->display_errors();
        }else{
            $config2['source_image']    = './assets/frontend/img/usuarios/'.$id.'.png';
            $config2['create_thumb']    = FALSE;
            $config2['width']           = 200;
            $config2['height']          = 200;     
            $this->load->library('image_lib');
            $this->image_lib->initialize($config);
            if($this->image_lib->resize()){
                if($this->modelusuarios->alterar_img($id)){
                    redirect(base_url('admin_kankStore/usuarios/alterar/'.$id));
                    $this->image_lib->clear();
                }else{
                    echo "Houve um erro no sistema!";
                }
                
            }else{
                echo $this->image_lib->display_errors();
                $this->image_lib->clear();
            }   
        }
    }
    
}
