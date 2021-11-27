<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_admin extends CI_Model {

	public function ceklogin($data){
		return $this->db->get_where('admin', $data)->num_rows();
	}

	public function getDataStasiun(){
		return $this->db->get('stasiun');
	}

	public function tambah_stasiun($nama){
		$data = array(
			'nama_stasiun' => $nama, 
		);
		return $this->db->insert('stasiun', $data);
	}

	public function delete_stasiun($id){
		$this->db->where('id', $id);
		return $this->db->delete('stasiun');
	}

	public function getDataEditStasiun($id){
		$data = array(
			'id' => $id, 
		);
		return $this->db->get_where('stasiun', $data);
	}

	public function edit_stasiun($nama){
		$data = array(
			'nama_stasiun' => $nama, 
		);

		$this->db->where('id', $this->input->post('id'));
		return $this->db->update('stasiun', $data);
	}

	public function tambah_jadwal($data){
		return $this->db->insert('jadwal', $data);

	}

	public function getjadwal(){
		$this->db->select('jadwal.*, asal.nama_stasiun AS asal, tujuan.nama_stasiun As tujuan');
		$this->db->from('jadwal');
		$this->db->join('stasiun as Asal','jadwal.asal = asal.id', 'left');
		$this->db->join('stasiun as Tujuan','jadwal.tujuan = Tujuan.id', 'left');
		return $this->db->get();
	}
	public function hapusJadwal($id){
		$this->db->where('id', $id);
		return $this->db->delete('jadwal');
	}
	public function getDataEditJadwal($id){
		$data = array(
			'jadwal.id' => $id,
		);
		$this->db->select('jadwal.*, asal.nama_stasiun AS asal, tujuan.nama_stasiun As tujuan');
		$this->db->from('jadwal');
		$this->db->where($data);
		$this->db->join('stasiun as Asal','jadwal.asal = asal.id', 'left');
		$this->db->join('stasiun as Tujuan','jadwal.tujuan = Tujuan.id', 'left');
		return $this->db->get();
	}

	public function edit_jadwal($data){
		$this->db->where('id', $this->input->post('id'));
		return $this->db->update('jadwal', $data);
	}

	public function getKonfirmasiPembayaran(){
		$where = array(
			'status'	=> 1
		);
		return $this->db->get_where('pembayaran', $where);
	}

	public function updatePembayaran($id){
		$data = array(
			'status'	=> 2
		);
		$this->db->where('id', $id);
		return $this->db->update('pembayaran', $data);
	}
	public function prosesBerangkat($id){
		$data = array(
			'status'	=> 1
		);
		$this->db->where('id', $id);
		return $this->db->update('jadwal', $data);
	}
	public function getKursi(){
		$this->db->join('jadwal','jadwal.id=kursi.id_jadwal');
		return $this->db->get('kursi');
	}

}