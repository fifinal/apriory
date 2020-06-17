<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rule extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Rule_model');
    }

    public function index()
    {

        $data["rules"] = $this->Rule_model->getDaftarRule();
        $data["title"] = "Rule";
        $data["nav"] = "rule";

        $this->load->view('template/header', $data);
        $this->load->view('rule/index', $data);
        $this->load->view('template/footer');
    }
    public function detail($id)
    {
        $rules = $this->Rule_model->ruleById($id);
        $data["rules"] = $rules;
        $data["ruleNames"] = $this->Rule_model->ruleNameById($rules);
        $data["title"] = "Rule " . $id;
        $data["nav"] = "rule";

        $this->load->view('template/header', $data);
        $this->load->view('rule/detail', $data);
        $this->load->view('template/footer');
    }
}
