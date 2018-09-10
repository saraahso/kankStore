<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    public $id;
    public $titulo;

    public function __construct()
    {
        parent::__construct();
    }

    public function list_categories(){
        $this->db->order_by("cat_titulo", "ASC");
        return $this->db->get('categoria')->result();
    }

    public function save($titulo){
        $dados['cat_titulo'] = $titulo;
        return $this->db->insert('categoria', $dados);
    }

    public function delete($id){
        $this->db->where('cat_id', $id);
        return $this->db->delete('categoria');
    }

    public function list_category($id){
        $this->db->from('categoria');
        $this->db->where('cat_id =', $id);
        return $this->db->get()->result();
    }

    public function edit($titulo, $id){
        $dados['cat_titulo'] = $titulo;
        $this->db->where('cat_id', $id);
        return $this->db->update('categoria', $dados);
    }
}
