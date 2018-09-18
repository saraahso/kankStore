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
        $this->db->select('prod_nome, prod_codigo, prod_id, prod_categoria,prod_tamanho, prod_cor, prod_estoque, prod_valor_de_venda, cat_titulo, mar_titulo');
        $this->db->from('venda');
        $this->db->like('venda',$id);
        return $this->db->get()->result();
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

    public function saveItem($idproduct, $quantity, $totalprice){
        $dados['itv_cod_prod']    = $idproduct;
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