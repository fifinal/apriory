<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function index()
	{
		$this->load->view('template/headerLogin');
		$this->load->view('register');
		$this->load->view('template/footerLogin');
	}
	public function coba()
	{
		echo "oke";
	}
}
