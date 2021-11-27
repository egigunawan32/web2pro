<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_guest extends CI_Model {

	public function getDataStasiun(){
		return $this->db->get('stasiun');
	}

	public function cari_tiket($data){
		$this->db->select('jadwal.*, asal.nama_stasiun AS asal, tujuan.nama_stasiun As tujuan');
		$this->db->where($data);
		$this->db->like('tgl_berangkat', $this->input->post('tanggal'));
		$this->db->from('jadwal');
		$this->db->join('stasiun as asal','jadwal.asal = Asal.id', 'left');
		$this->db->join('stasiun as tujuan','jadwal.tujuan = tujuan.id', 'left');
		return $this->db->get();
	}


	public function getDataInfoPesan($id){
		$this->db->select('jadwal.*, asal.nama_stasiun AS asal, tujuan.nama_stasiun As tujuan');
		$this->db->where('jadwal.id', $id);
		$this->db->join('stasiun as asal','jadwal.asal = asal.id', 'left');
		$this->db->join('stasiun as tujuan','jadwal.tujuan = tujuan.id', 'left');
		return $this->db->get('jadwal');
	}

	public function gettiket(){
		return $this->db->get('tiket');
	}

	public function insertpenumpang($data){
		return $this->db->insert('penumpang', $data);
	}

	public function insertpemesan($data){
		return $this->db->insert('tiket', $data);
	}

	public function getpembayaran(){
		return $this->db->get('pembayaran');
	}

	public function getpembayaranwhere($kode){
		$this->db->where('no_pembayaran', $kode);
		return $this->db->get("pembayaran");
	}

	public function insertpembayaran($data){
		return $this->db->insert('pembayaran', $data);
	}

	public function cekkonfirmasi($nomor){
		$this->db->where('nomor_tiket', $nomor);
		return $this->db->get('penumpang');
	}

	public function insertbukti($nama, $no){
		$data = array(
			'bukti'	=> $nama,
			'status' => 1
		);
		$this->db->where('no_pembayaran', $no);
		return $this->db->update("pembayaran", $data);
	}
	public function PilihGerbong($data, $no, $nama){
		$this->db->where('nomor_tiket', $no);
		$this->db->where('nama', $nama);
		return $this->db->update("penumpang", $data);}
	public function getTiketWhere($tiket){
		return $this->db->get_where('tiket', array('nomor_tiket' => $tiket));
	}
	public function validasiGerbong($gerbong,$bagian,$kursi,$id_jadwal){
		$this->db->where('gerbong', $gerbong);
		$this->db->where('bagian', $bagian);
		$this->db->where('kursi', $kursi);
		$this->db->where('tiket.id_jadwal', $id_jadwal);
		$this->db->join('tiket','tiket.nomor_tiket=penumpang.nomor_tiket');
		return $this->db->get('penumpang');
	}

	public function getPrint($no_tiket){
		$this->db->select('*, Asal.nama_stasiun AS ASAL, Tujuan.nama_stasiun As TUJUAN');
		$this->db->join('jadwal','jadwal.id=tiket.id_jadwal');
		$this->db->join('stasiun as Asal','jadwal.asal = Asal.id', 'left');
		$this->db->join('stasiun as Tujuan','jadwal.tujuan = Tujuan.id', 'left');
		$this->db->where('nomor_tiket', $no_tiket);
		return $this->db->get('tiket');
	}

}