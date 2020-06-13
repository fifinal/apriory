<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_model');
        $this->load->model('DetailTransaksi_model');
        $this->load->library('excel');
        $this->transaksi = [];
    }
    public function index()
    {
        $data["title"] = "Transaksi";
        $data["nav"] = "transaksi";
        $this->load->view('template/header', $data);
        $this->load->view('transaksi/index');
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
            $dataTransaksi = [];

            for ($i = 0; $i < count($sheet); $i++) {
                $kolom1 = explode("-", $sheet[$i][0]);
                $kd_transaksi = trim($kolom1[0]);
                if ($kd_transaksi != null) {
                    if (substr($kd_transaksi, 0, 3) == "PJO") {
                        $idTransksi = $kd_transaksi;
                        $tgl = explode("/", trim($kolom1[1]));

                        $time = strtotime($tgl[1] . "/" . $tgl[0] . "/" . $tgl[2]);
                        $strTanggal = explode(" ", date('l, d m Y', $time));
                        $transaksi = [
                            "kode_transaksi" => $idTransksi,
                            "hari" => rtrim($strTanggal[0], ","),
                            "tanggal" => $strTanggal[1],
                            "bulan" => $strTanggal[2],
                            "tahun" => $strTanggal[3]
                        ];
                        array_push($dataTransaksi, $transaksi);
                        // $this->transaksi[$idTransksi] = [];
                    } else if (
                        $idTransksi != "" &&
                        $sheet[$i][2] != "" &&
                        $sheet[$i][3] != "" &&
                        $sheet[$i][4] != "" &&
                        trim(strtolower($sheet[$i][2])) != "kode" &&
                        is_numeric($sheet[$i][2])
                    ) {

                        array_push(
                            $this->transaksi,
                            [
                                "kode_transaksi" => $idTransksi,
                                "kode_produk" => trim(strtolower($sheet[$i][2]))
                            ]
                        );

                        // $this->Transaksi_model->saveTransaksi($transaksi);
                    }
                }
            }
            $this->Transaksi_model->saveBatchTransaksi($dataTransaksi);
            $this->DetailTransaksi_model->saveBatchTransaksi($this->transaksi);
            echo json_encode([
                "status" => "berhasil",
                "jumlah_transksi" => count($dataTransaksi),
                "jumlah_detail_transaksi" => count($this->transaksi)
            ]);
        }
    }
    public function json()
    {
        $url = base_url() . "transaksi/detail/";
        $this->load->library('datatables');
        $this->datatables->select('kode_transaksi,hari,tanggal,bulan,tahun');
        $this->datatables->add_column('action', '<a class="btn btn-sm btn-danger hapus" href="' . $url . '$1"><i class="fa fa-eye"></i></a>', 'kode_transaksi');
        $this->datatables->from("transaksi");
        echo $this->datatables->generate();
    }
    public function detail($id)
    {
        $data["detail_transaksi"] = $this->DetailTransaksi_model->transaksiById($id);
        $data["transaksi"] = $this->Transaksi_model->transaksiById($id);
        $data["title"] = "Transaksi " . $id;
        $data["nav"] = "transaksi";

        $this->load->view('template/header', $data);
        $this->load->view('transaksi/detail', $data);
        $this->load->view('template/footer');
    }
}
