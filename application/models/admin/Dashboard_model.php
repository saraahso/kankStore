<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }


    public function get_count_record($table)
    {
        $query = $this->db->count_all($table);

        return $query;
    }


    public function get_sale_day($table)
    {
         $this->db->where('ven_total')->get('venda');
        return $this->db->count_all_results();

        return $query;
    }

     public function years(){
		$this->db->select("YEAR(ven_data) as year");
		$this->db->from("venda");
		$this->db->group_by("year");
		$this->db->order_by("year","desc");
		$resultados = $this->db->get();
		return $resultados->result();
	}
	public function amount($year){
		$this->db->select("MONTH(ven_data) as month, SUM(ven_total) as total");
        $this->db->from("venda");
        $this->db->where("ven_data >=", $year. "-01-01");
        $this->db->where("ven_data <=", $year. "-12-31");
		$this->db->group_by("month");
		$this->db->order_by("month");
		$resultados = $this->db->get();
		return $resultados->result();
    }
    
    public function months(){
		$this->db->select("MONTH(ven_data) as month");
		$this->db->from("venda");
		$this->db->group_by("month");
		$this->db->order_by("month","desc");
		$resultados = $this->db->get();
		return $resultados->result();
	}
    public function amount_day($year, $month){
		$this->db->select("DAY(ven_data) as day, SUM(ven_total) as total");
        $this->db->from("venda");
        $this->db->where("ven_data >=", $year, $month. "-01");
        $this->db->where("ven_data <=", $year, $month. "-31");
		$this->db->group_by("day");
		$this->db->order_by("day");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function custo_venda(){
		$this->db->select('ven_id, ven_tipo_pagamento, MONTH(ven_data) as month, SUM(ven_total) as total, SUM(ven_total_custo) as totalcusto');
		$this->db->from('venda');;
        $this->db->group_by("month");
		$this->db->order_by("month");
        $resultados = $this->db->get();
		return $resultados->result();
	}
    
}
