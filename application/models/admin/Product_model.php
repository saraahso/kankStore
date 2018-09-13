<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    public $id;
    public $name;           
    public $size; 
    public $color;
    public $stock;
    public $category;
    public $brand;
    public $cost_value;
    public $sell_value;

    public function __construct()
    {
        parent::__construct();
    }

    public function list_products(){
        $this->db->select('prod_id, prod_nome, prod_tamanho, prod_cor, prod_estoque, prod_valor_de_custo, prod_valor_de_venda, prod_marca, prod_categoria, cat_titulo, mar_titulo');
        $this->db->from('produto');
        $this->db->join('categoria', 'produto.prod_categoria = categoria.cat_id');
        $this->db->join('marca', 'produto.prod_marca = marca.mar_id');
        $this->db->order_by("prod_nome", "ASC");
        return $this->db->get()->result();
    }

    public function save($name,$size,$color,$stock,$category,$brand,$cost_value,$sell_value){
        $dados['prod_nome']             = $name;
        $dados['prod_tamanho']          = $size;
        $dados['prod_cor']              = $color;
        $dados['prod_estoque']          = $stock;
        $dados['prod_categoria']        = $category;
        $dados['prod_marca']            = $brand;
        $dados['prod_valor_de_custo']   = $cost_value;
        $dados['prod_valor_de_venda']   = $sell_value;
        return $this->db->insert('produto', $dados);
    }

    
    public function delete($id){
        $this->db->where('prod_id', $id);
        return $this->db->delete('produto');
    }

    public function list_product($id){
        $this->db->from('produto');
        $this->db->where('prod_id =', $id);
        return $this->db->get()->result();
    }

    public function edit($name,$size,$color,$stock,$category,$brand,$cost_value,$sell_value, $id){
        $dados['prod_nome'] = $titulo;
        $this->db->where('prod_id', $id);
        return $this->db->update('produto', $dados);
    }
}
