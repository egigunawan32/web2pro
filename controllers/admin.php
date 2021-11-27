<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin extends CI_Controller {

	public function kehalamanlogin(){
		$this->load->view('admin/login');
	}

	public function login(){
		$data = array(
			'username' => $this->input->post('username'), 
			'password' => sha1($this->input->post('password'))
		);


		$cek = $this->m_admin->ceklogin($data);

		if ($cek > 0) { // jika $cek > 0
			$sess = array(
				'status' => TRUE,
				'level' => 'admin'
			);

			// SET USERDATA / SESSION
			$this->session->set_userdata($sess);

			redirect(base_url('admin/dashboard'));

		}else{

			redirect(base_url('login'));

		}
	}

	public function logout(){
		session_destroy();
		redirect(base_url());
	}

	public function keHalamanDashboard(){
		if ($this->session->status === TRUE) {

			$data['stasiun'] = $this->m_admin->getDataStasiun()->result();

			$this->load->view('admin/dashboard', $data);

		}else{
			redirect(base_url('login'));
		}
	}

	public function tambah_stasiun(){

		$nama = $this->input->post('stasiun');

		$input = $this->m_admin->tambah_stasiun($nama);

		redirect(base_url('admin/dashboard'));
	}

	public function hapus_stasiun($id){
		$delete = $this->m_admin->delete_stasiun($id);

		redirect(base_url('admin/dashboard'));
	}

	public function kehalamaneditstasiun($id){
		$data['data_stasiun'] = $this->m_admin->getdataeditstasiun($id)->row();

		$this->load->view('admin/edit_stasiun', $data);
	}

	public function edit_stasiun(){
		$nama = $this->input->post('nama_stasiun');

		$edit = $this->m_admin->edit_stasiun($nama);

		redirect(base_url('admin/dashboard'));
	}

	public function keHalamankelolajadwal(){
		$data['stasiun'] = $this->m_admin->getDataStasiun()->result();

		$data['jadwal'] = $this->m_admin->getjadwal()->result();
		$this->load->view('admin/kelola-jadwal', $data);
	}

	public function tambah_jadwal(){
		$data = array(
			'nama_kereta' => $this->input->post('nama_kereta'),
			'asal' => $this->input->post('asal'),
			'tujuan' => $this->input->post('tujuan'),
			'tgl_berangkat' => $this->input->post('tgl_berangkat'),
			'tgl_sampai' => $this->input->post('tgl_sampai'),
			'kelas' => $this->input->post('kelas'),
			'harga' => $this->input->post('harga')
	);

		$this->m_admin->tambah_jadwal($data);

		redirect(base_url('admin/dashboard/kelola-jadwal'));
	}

	public function hapusJadwal($id){
		$this->m_admin->hapusJadwal($id);
		redirect(base_url('admin/dashboard/kelola-jadwal'));
	}

	public function kehalamaneditjadwal($id){
		$data['data_edit'] = $this->m_admin->getDataEditJadwal($id)->row();
		$data['stasiun'] = $this->m_admin->getDataStasiun()->result();

		$this->load->view('admin/edit_jadwal', $data);
	}

	public function edit_jadwal(){
		$data = array(
			'nama_kereta' => $this->input->post('nama_kereta'), 
			'asal' => $this->input->post('asal'), 
			'tujuan' => $this->input->post('tujuan'), 
			'tgl_berangkat' => $this->input->post('tgl_berangkat'), 
			'tgl_sampai' => $this->input->post('tgl_sampai'), 
			'kelas' => $this->input->post('kelas'),
			'harga' => $this->input->post('harga'),
		);

		$this->m_admin->edit_jadwal($data);

		redirect(base_url('admin/dashboard/kelola-jadwal'));
	}

	public function keHalamanKonfirPem(){
		$data['list']	= $this->m_admin->getKonfirmasiPembayaran()->result();

		$this->load->view('admin/konfirmasi_pembayaran', $data);
	}
	public function verifikasiPembayaran($id){
		$update = $this->m_admin->updatePembayaran($id);

		if($update){
			$this->session->set_flashdata('pesan','Berhasil Melakukan Verifikasi!');
			redirect('admin/konfirmasi-pembayaran');
		}else{
			echo "gagal";
		}
	}
	
	public function keHalamanKelolaGerbong(){
		$data['kursi'] = $this->m_admin->getKursi()->result();
		$data['jadwal'] = $this->m_admin->getJadwal()->result();

		$this->load->view('admin/kelola_gerbong', $data);
	}
	public function prosesBerangkat($id){
		$update = $this->m_admin->prosesBerangkat($id);

		if($update){
			$this->session->set_flashdata('pesan','Berhasil Mengubah Status Jadwal');
			redirect('admin/dashboard/kelola-jadwal');
		}else{
			echo "Gagal";
		}
	}
	
}


