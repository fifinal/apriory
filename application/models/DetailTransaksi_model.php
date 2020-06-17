<?php

class DetailTransaksi_model extends CI_model
{
    protected $table = "detail_transaksi";

    public function getTransaksi()
    {
        return $this->db->get($this->table)->result_array();
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
        $query = "SELECT produk.kode_produk,nama_produk,harga,stok FROM detail_transaksi JOIN produk ON produk.kode_produk=detail_transaksi.kode_produk WHERE detail_transaksi.kode_transaksi='$id'";
        return $this->db->query($query)->result_array();
    }
}
