<?php

class Produk_model extends CI_model
{
    protected $table = "produk";

    public function getProduk()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function getCountProduk()
    {
        return $this->db->count_all($this->table);
    }

    public function saveProduk($data)
    {
        $this->db->insert($this->table, $data);
    }
    public function saveBatchProduk($data)
    {
        $this->db->insert_batch($this->table, $data);
    }
    public function produkById($id)
    {
        return $this->db->get_where($this->table, ['kode_produk' => $id])->row_array();
    }
    public function hapus($id)
    {
        $this->db->delete($this->table, ["kode_produk" => $id]);
    }
    public function update($data)
    {
        $this->db->where('kode_produk', $data["kode_produk"]);
        $this->db->update($this->table, $data);
    }
}
