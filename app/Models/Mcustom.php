<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;

/**
 * Description of Custommodel
 *
 * @author RAMPA
 */
class Mcustom {
    
    protected  $db;
    
    public function __construct() {
        $this->db = db_connect();
    }
    
    public function getAllQ($q) {
        $query = $this->db->query($q);
        return $query;
    }
    
    public function getAllQR($q) {
        $query = $this->db->query($q);
        return $query->getRowObject();
    }
    
    public function getAll($tb_name) {
        $builder = $this->db->table($tb_name);
        $query = $builder->get();
        return $query;
    }
    
    public function getAllW($tb_name, $kondisi) {
        $builder = $this->db->table($tb_name);
        $builder->where($kondisi);
        $query = $builder->get();
        return $query;
    }
    
    public function add($table, $data){
        $builder = $this->db->table($table);
        return $builder->insert($data);
    }
    
    public function delete($table,$kondisi){
        $builder = $this->db->table($table);
        $builder->where($kondisi);
        return $builder->delete();
    }
    
    public function update($table, $data, $condition){
        $builder = $this->db->table($table);
        $builder->where($condition);
        return $builder->update($data);
    }
    
    public function updateNK($table, $data){
        $builder = $this->db->table($table);
        return $builder->update($data);
    }
    
    public function select_max($tb_name, $kolom) {
        $builder = $this->db->table($tb_name);
        $builder->selectMax($kolom);
        $query = $builder->get();
        return $query;
    }
    
    public function select_min($tb_name, $kolom) {
        $builder = $this->db->table($tb_name);
        $builder->selectMin($kolom);
        $query = $builder->get();
        return $query;
    }
    
    public function select_avg($tb_name, $kolom) {
        $builder = $this->db->table($tb_name);
        $builder->selectAvg($kolom);
        $query = $builder->get();
        return $query;
    }
    
    public function select_sum($tb_name, $kolom) {
        $builder = $this->db->table($tb_name);
        $builder->selectSum($kolom);
        $query = $builder->get();
        return $query;
    }
    
    public function select_count($tb_name, $kolom) {
        $builder = $this->db->table($tb_name);
        $builder->selectCount($kolom);
        $query = $builder->countAllResults();
        return $query;
    }
    
    public function autokode($depan, $kolom, $table, $awal, $akhir) {
        $hasil = "";
        $data = $this->getAllQR("select ifnull(MAX(substr(".$kolom.",".$awal.",".$akhir.")),0) + 1 as jml from ".$table.";");
        $panjang = strlen($data->jml);
        $pnjng_nol = ($akhir-$panjang) - $awal;
        $nol = "";
        for($i=1; $i<=$pnjng_nol; $i++){
            $nol .= "0";
        }
        $hasil = $depan.$nol.$data->jml;
        return $hasil;
    }
    
    public function get_by_id($table, $kondisi){
        $builder = $this->db->table($table);
        $builder->where($kondisi);
        $query = $builder->get();
        return $query->getRowObject();
    }
}
