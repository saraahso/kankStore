<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand_model extends CI_Model {

    public $id;
    public $titulo;

    public function __construct()
    {
        parent::__construct();
    }

    public function list_brands(){
        $this->db->order_by("mar_titulo", "ASC");
        return $this->db->get('marca')->result();
    }

    public function save($titulo){
        $dados['mar_titulo'] = $titulo;
        return $this->db->insert('marca', $dados);
    }

    public function delete($id){
        $this->db->where('mar_id', $id);
        return $this->db->delete('marca');
    }

    public function list_brand($id){
        $this->db->from('marca');
        $this->db->where('mar_id =', $id);
        return $this->db->get()->result();
    }

    public function edit($titulo, $id){
        $dados['mar_titulo'] = $titulo;
        $this->db->where('mar_id', $id);
        return $this->db->update('marca', $dados);
    }
}
