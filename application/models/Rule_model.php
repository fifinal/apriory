<?php

class Rule_model extends CI_model
{
    protected $table = "daftar_rule";
    public function getRule()
    {
    }
    public function getDaftarRule()
    {
        return $this->db->get($this->table)->result_array();
    }
    public function getCountProduk()
    {
        return $this->db->count_all($this->table);
    }
    public function simpanRule($data)
    {
        $this->db->insert('daftar_rule', $data["daftarRule"]);
        $insert_id = $this->db->insert_id();
        for ($i = 0; $i < count($data["rule"]); $i++) {
            $data["rule"][$i]["id_daftar_rule"] = $insert_id;
        }
        $this->db->insert_batch('rule', $data["rule"]);
    }
    public function ruleById($id)
    {
        return $this->db->get_where("rule", ['id_daftar_rule' => $id])->result_array();
    }
    public function ruleNameById($rules)
    {
        $ruleName = [];
        foreach ($rules as $rule) {
            $jika = [];
            foreach (explode(",", $rule["if"]) as $if) {
                $this->db->select("nama_produk");
                $produk = $this->db->get_where("produk", ['kode_produk' => $if])->row_array();
                array_push($jika, $produk["nama_produk"]);
            }
            $this->db->select("nama_produk");
            $maka = $this->db->get_where("produk", ['kode_produk' => $rule["then"]])->row_array();
            array_push($ruleName, ["jika" => $jika, "maka" => $maka["nama_produk"]]);
        }
        return $ruleName;
    }


    // function simpanDaftarRule($daftarRule)
    // {
    //     $this->db->insert('daftar_rule', $daftarRule);
    //     $insert_id = $this->db->insert_id();
    //     return  $insert_id;
    // }
}
