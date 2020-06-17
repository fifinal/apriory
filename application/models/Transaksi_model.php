<?php

class Transaksi_model extends CI_model
{
    protected $table = "transaksi";

    public function getTransaksi()
    {
        return $this->db->get($this->table)->result_array();
    }
    public function getCountProduk()
    {
        return $this->db->count_all($this->table);
    }
    public function saveTransaksi($data)
    {
        $this->db->insert($this->table, $data);
    }
    public function saveBatchTransaksi($data)
    {
        $this->db->insert_batch($this->table, $data);
    }
    public function transaksiById($id)
    {
        return $this->db->get_where($this->table, ['kode_transaksi' => $id])->row_array();
    }
}
