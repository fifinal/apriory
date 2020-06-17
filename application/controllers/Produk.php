<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Produk_model');
        $this->load->library('excel');
        $this->transaksi = [];
    }

    public function index()
    {
        $data["title"] = "Produk";
        $data["nav"] = "produk";

        $this->load->view('template/header', $data);
        $this->load->view('produk/index');
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
                        is_numeric($sheet[$i][2])
                    ) {
                        $harga = explode(".", $sheet[$i][4]);
                        $harga = str_replace(",", ".", $harga[0]);
                        $produk = [
                            "kode_produk" => $sheet[$i][2],
                            "nama_produk" => $sheet[$i][3],
                            "harga" => (int) $harga * 1000,
                            "stok" => 10
                        ];
                        $exist = $this->Produk_model->produkById(trim($sheet[$i][2]));
                        if ($exist == null) {
                            $this->Produk_model->saveProduk($produk);
                        }
                    }
                }
            }
            // echo json_encode($this->transaksi);
        }
    }

    public function json()
    {
        $this->load->library('datatables');
        $this->datatables->select('kode_produk,nama_produk,harga,stok');
        $this->datatables->add_column('action', '<button class="btn btn-sm btn-warning edit" data-id="$1"><i class="fa fa-edit edit" data-id="$1"></i></button><button class="btn btn-sm btn-danger hapus" data-id="$1"><i data-id="$1" class="fa fa-trash hapus"></i></button>', 'kode_produk');
        $this->datatables->from('produk');
        echo $this->datatables->generate();
    }

    public function update()
    {
        $data = json_decode(trim(file_get_contents('php://input')), true);
        $this->Produk_model->update($data);
        echo json_encode($data);
    }

    public function edit($id)
    {
        $data = $this->Produk_model->produkById($id);
        echo json_encode($data);
    }

    public function hapus($id)
    {
        $this->Produk_model->hapus($id);
    }

    public function simpan()
    {
        $data = json_decode(trim(file_get_contents('php://input')), true);
        // echo json_encode($_POST);
        $this->Produk_model->saveProduk($data);
        echo json_encode($data);
    }

    public function ajax()
    {
        echo json_encode($this->Produk_model->getProduk());
    }
}
