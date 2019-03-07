<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guru extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('guru/v_list_guru');
	}

}

/* End of file Guru.php */
/* Location: ./application/controllers/Guru.php */