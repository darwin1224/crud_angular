<?php

class Siswa extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(['M_siswa']);
	}
	public function index()
	{
		$data['title'] = 'Siswa';
		$this->template->load('template','siswa/v_list_siswa', $data);
	}
	public function data_siswa()
	{	
		$data = $this->M_siswa->get_all_siswa();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	public function get_siswa($id)
	{
		$data = $this->M_siswa->get_siswa_by_id($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	public function tambah()
	{
		$postdata = json_decode(file_get_contents('php://input'), true);

		$data = $this->M_siswa->tambah_siswa($postdata);

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	public function ubah($id)
	{
		$postdata = json_decode(file_get_contents('php://input'), true);
		
		$data = $this->M_siswa->ubah_siswa($postdata, $id);

		if($data){
			$this->output->set_content_type('application/json')->set_output(json_encode(['success' => true]));
		} else {
			$this->output->set_content_type('application/json')->set_output(json_encode(['success' => false]));
		}
	}
	public function hapus($id)
	{
		$data = $this->M_siswa->hapus_siswa($id);
		$this->output->set_content_type('application/json')->set_output(json_encode(['success' => true]));
	}
}