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

    public function list_sale($id){
        $this->db->select('v.ven_id, v.ven_data, i.itv_id, i.itv_cod_venda, i.itv_cod_prod, i.itv_qtd, i.itv_valor, p.prod_id, 
        p.prod_nome, p.prod_tamanho, p.prod_cor, p.prod_estoque, p.prod_valor_de_custo, v.ven_total, p.prod_marca,p. prod_categoria, 
        c.cat_titulo, m.mar_titulo');
        $this->db->from('item_venda i');
        $this->db->join('venda v', 'i.itv_cod_venda = v.ven_id');
        $this->db->join('produto p', 'i.itv_cod_prod = p.prod_id');
        $this->db->join('categoria c', 'p.prod_categoria = c.cat_id');
        $this->db->join('marca m', 'p.prod_marca = m.mar_id'); 
        $this->db->where('i.itv_cod_venda =', $id);
        return $this->db->get()->result();
    }

    public function list_products_sale($id){
        $query = $this->db->query('SELECT ven_id, ven_data, ven_total, itv_id, itv_cod_venda, 
        itv_cod_prod, itv_qtd, itv_valor, prod_id, prod_nome, prod_tamanho, prod_cor, 
        prod_estoque, prod_valor_de_custo, prod_valor_de_venda, prod_marca, 
        prod_categoria, cat_titulo, mar_titulo 
        FROM item_venda 
        INNER JOIN venda 
        ON item_venda.itv_cod_venda = venda.ven_id 
        INNER JOIN produto ON item_venda.itv_cod_prod = produto.prod_id 
        INNER JOIN categoria ON produto.prod_categoria = categoria.cat_id 
        INNER JOIN marca ON produto.prod_marca = marca.mar_id;');
        return $query;
    }

    function getproducts($valor){
        $this->db->select('prod_nome, prod_codigo, prod_id, prod_categoria,prod_tamanho, prod_cor, prod_estoque, prod_valor_de_venda, cat_titulo, mar_titulo');
        $this->db->from('produto');
        $this->db->join('categoria', 'produto.prod_categoria = categoria.cat_id');
        $this->db->join('marca', 'produto.prod_marca = marca.mar_id');
        $this->db->like('prod_nome',$valor);
        $query  =   $this->db->get();
        return $query->result();
    }
    
    public function delete($id){
        $this->db->where('ven_id', $id);
        return $this->db->delete('venda');
    }

    public function save($date, $total){
        $dados['ven_data']    = $date;
        $dados['ven_total']   = $total;
        return $this->db->insert('venda', $dados);
    }

    public function lastID(){
		return $this->db->insert_id();
	}

    public function saveItem($idproduct, $idvenda, $quantity, $totalprice){
        $dados['itv_cod_prod']    = $idproduct;
        $dados['itv_cod_venda']   = $idvenda;
        $dados['itv_qtd']         = $quantity;
        $dados['itv_valor']       = $totalprice;
        return $this->db->insert('item_venda', $dados);
    }

    public function updateProduct($idproduct, $quantity, $stock){
        $this->db->set('prod_estoque', $stock. '-' .$quantity , FALSE);
        $this->db->where('prod_id', $idproduct);
        return $this->db->update('produto');
    }
}