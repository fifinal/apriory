<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Rule_model');
        $this->load->model('Produk_model');
        $this->load->model('Transaksi_model');
    }

    public function index()
    {
        $data["title"] = "Dashboard";
        $data["nav"] = "dashboard";
        $data["produk"] = $this->Produk_model->getCountProduk();
        $data["rule"] = $this->Rule_model->getCountProduk();
        $data["transaksi"] = $this->Transaksi_model->getCountProduk();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('template/footer');
    }
}
