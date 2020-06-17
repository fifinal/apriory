<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Apriori extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Rule_model');
        $this->load->model('Transaksi_model');
        $this->load->model('Produk_model');
        $this->load->library('excel');
        $this->transaksi = [];
        $this->minFrekuensi = 5;
        $this->itemSet = [];
    }
    public function index()
    {
        $data["title"] = "Apriori";
        $data["nav"] = "apriori";
        $this->load->view('template/header', $data);
        $this->load->view('apriori/index');
        $this->load->view('template/footer');
    }

    public function import()
    {
        $this->transaksi = [];

        $nameFile = $_FILES["file"]["name"];

        if ($nameFile) {

            $idTransksi = "";

            $object = new PHPExcel_Reader_CSV();
            $load = $object->load($_FILES["file"]["tmp_name"]);
            $sheet = $load->getActiveSheet()->toArray(null, true, true);

            $idTransksi = "";

            for ($i = 0; $i < count($sheet); $i++) {
                $kolom1 = explode("-", $sheet[$i][0]);
                $kd_transaksi = trim($kolom1[0]);
                if ($kd_transaksi != null) {
                    if (substr($kd_transaksi, 0, 3) == "PJO") {
                        $idTransksi = $kd_transaksi;
                        $tgl = trim($kolom1[1]);
                        $this->transaksi[$idTransksi] = [];
                    } else if (
                        $idTransksi != "" &&
                        $sheet[$i][2] != "" &&
                        $sheet[$i][3] != "" &&
                        $sheet[$i][4] != "" &&
                        trim(strtolower($sheet[$i][2])) != "kode" &&
                        substr($sheet[$i][2], 0, 3) != "100" &&
                        $sheet[$i][2] != "9999991" &&
                        is_numeric($sheet[$i][2])
                    ) {
                        // array_push($transaksi[$idTransksi], $sheet[$i][0] . "," . $sheet[$i][2] . "," . $sheet[$i][3]);
                        array_push($this->transaksi[$idTransksi], trim(strtolower($sheet[$i][2])));
                    }
                }
            }
            echo json_encode($this->transaksi);
        }
    }

    public function simpanRule()
    {
        $data = json_decode(trim(file_get_contents('php://input')), true);
        $this->Rule_model->simpanRule($data);
    }
}
