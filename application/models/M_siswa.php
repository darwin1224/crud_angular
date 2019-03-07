<?php

class M_siswa extends CI_Model
{
	private $table;

	private $primary_key;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'tbl_siswa';
		$this->primary_key = 'id_siswa';
	}
	public function get_all_siswa()
	{
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	public function get_siswa_by_id($id)
	{
		$query = $this->db->get_where($this->table, [$this->primary_key => $id]);
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	public function tambah_siswa($request)
	{
		$query = $this->db->insert($this->table, [
			'id_siswa' 		=> $request['id_siswa'],
			'nama_siswa' 	=> $request['nama_siswa'], 
			'alamat_siswa' 	=> $request['alamat_siswa']
		]);
		return $query;
	}
	public function ubah_siswa($request, $id)
	{
		$query = $this->db->update($this->table, $request, [$this->primary_key => $id]);
		return $this->db->affected_rows();
	}
	public function hapus_siswa($id)
	{
		$this->db->where([$this->primary_key => $id]);
		$query = $this->db->delete($this->table);
		if (!$query) {
			return false;
		} else {
			return true;
		}
	}
}