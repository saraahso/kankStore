<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_model extends CI_Model {

    public $sale_id;
    public $sale;           
    public $date; 
    public $total;

    public function __construct()
    {
        parent::__construct();
    }

    public function list_sales(){
        $this->db->select('ven_id, ven_data, ven_total');
        $this->db->from('venda');
        $this->db->order_by("ven_data", "ASC");
        return $this->db->get()->result();
    }

    function search($keyword)
    {
        $this->db->like('prod_nome',$keyword);
        $query  =   $this->db->get('produto');
        return $query->result();
    }

    public function getOneProduct($id)
    {
        $this->db->where('produto.prod_id', $id);
        $this->db->select('ven_id, ven_data, itv_id, itv_cod_venda, itv_cod_prod, itv_qtd, itv_valor, prod_id, prod_nome, prod_tamanho, prod_cor, prod_estoque, prod_valor_de_custo, SUM(prod_valor_de_venda) ven_total, prod_marca, prod_categoria, cat_titulo, mar_titulo');
        $this->db->join('venda', 'item_venda.itv_cod_venda = venda.ven_id');
        $this->db->join('produto', 'item_venda.itv_cod_prod = produto.prod_id');
        $this->db->join('categoria', 'produto.prod_categoria = categoria.cat_id');
        $this->db->join('marca', 'produto.prod_marca = marca.mar_id');
        $query = $this->db->get('produto');
        return $query->row_array();
    }
    
    public function delete($id){
        $this->db->where('ven_id', $id);
        return $this->db->delete('venda');
    }

    public function list_products_sale($id){
        $query = $this->db->query('SELECT ven_id, ven_data, ven_total, itv_id, itv_cod_venda, itv_cod_prod, itv_qtd, itv_valor, prod_id, prod_nome, prod_tamanho, prod_cor, prod_estoque, prod_valor_de_custo, prod_valor_de_venda, prod_marca, prod_categoria, cat_titulo, mar_titulo FROM item_venda INNER JOIN venda ON item_venda.itv_cod_venda = venda.ven_id INNER JOIN produto ON item_venda.itv_cod_prod = produto.prod_id INNER JOIN categoria ON produto.prod_categoria = categoria.cat_id INNER JOIN marca ON produto.prod_marca = marca.mar_id;');
        return $query;
    }

    public function list_sale($id){
        $this->db->select('ven_id, ven_data, itv_id, itv_cod_venda, itv_cod_prod, itv_qtd, itv_valor, prod_id, prod_nome, prod_tamanho, prod_cor, prod_estoque, prod_valor_de_custo, SUM(prod_valor_de_venda) ven_total, prod_marca, prod_categoria, cat_titulo, mar_titulo');
        $this->db->from('item_venda');
        $this->db->join('venda', 'item_venda.itv_cod_venda = venda.ven_id');
        $this->db->join('produto', 'item_venda.itv_cod_prod = produto.prod_id');
        $this->db->join('categoria', 'produto.prod_categoria = categoria.cat_id');
        $this->db->join('marca', 'produto.prod_marca = marca.mar_id');
        $this->db->order_by("ven_data", "ASC");
        $this->db->where('ven_id =', $id);
        return $this->db->get()->result();
    }

    public function add_sale($name,$size,$color,$stock,$category,$brand,$cost_value,$sell_value, $id){
        $dados['prod_nome']             = $name;
        $dados['prod_tamanho']          = $size;
        $dados['prod_cor']              = $color;
        $dados['prod_estoque']          = $stock;
        $dados['prod_categoria']        = $category;
        $dados['prod_marca']            = $brand;
        $dados['prod_valor_de_custo']   = $cost_value;
        $dados['prod_valor_de_venda']   = $sell_value;
        $this->db->where('prod_id', $id);
        return $this->db->update('produto', $dados);
    }
}
