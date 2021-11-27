<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class guest extends CI_Controller {

    public function keHalamanDepan(){
        $data['judul'] = 'HOME';
        $data['stasiun'] = $this->m_guest->getDataStasiun()->result();
        $this->load->view('guest/template/header', $data);
        $this->load->view('guest/halaman_depan');
        $this->load->view('guest/template/footer');
    }

    public function keHalamanMenu(){
        $data['judul'] = 'LAYANAN';
        $data['stasiun'] = $this->m_guest->getDataStasiun()->result();
        $this->load->view('guest/template/header', $data);
        $this->load->view('guest/halaman_menu');
        $this->load->view('guest/template/footer');
    }

     public function kehalamankonfirmasi(){
        $data['judul'] = 'PEMBAYARAN';

        if(isset($_GET['kode'])):
            $kode = $_GET['kode'];
            $data ['no_tiket'] = $this->m_guest->getpembayaranwhere($kode)->row();
            $data['detail'] = $this->m_guest->cekkonfirmasi($data['no_tiket']->no_tiket)->result();
        endif;
        $this->load->view('guest/template/header', $data);
        $this->load->view('guest/halaman_konfirmasi', $data);
        $this->load->view('guest/template/footer');
    }

    public function cari_tiket(){
        $data = array(
            'asal' => $this->input->post('asal'), 
            'tujuan' => $this->input->post('tujuan'),
            'status' => 0,
        );

        $data['tiket']  = $this->m_guest->cari_tiket($data)->result();
        $data['penumpang'] = $this->input->post('jumlah');


        $data['judul'] = 'LAYANAN';
        $data['stasiun'] = $this->m_guest->getDataStasiun()->result();

        $this->load->view('guest/template/header', $data);
        $this->load->view('guest/halaman_menu');
        $this->load->view('guest/template/footer');
    }

    public function pesan($id){
        $data['judul'] = 'Formulir Data Diri';

        $data['info'] = $this->m_guest->getDataInfoPesan($id)->row();
        $data['id_jadwal'] = $id;

        $this->load->view('guest/template/header', $data);
        $this->load->view('guest/data_diri');
        $this->load->view('guest/template/footer');
    }

    public function pesantiket(){
        $penumpang = $this->input->post('penumpang');

        // Generate No Pembayaran
        $cek = $this->m_guest->getpembayaran()->num_rows()+1;

        $no_pembayaran = 'AC246'.$cek;
        
        $harga = $this->input->post('harga');

        $total_pembayaran = $penumpang*$harga;

        // input pembayaran

         $no_tiket = 'TOO'.$cek;

        $data = array(
            'no_pembayaran' => $no_pembayaran,
            'no_tiket'      => $no_tiket,
            'total_pembayaran' => $total_pembayaran,
            'status' => 0
        );

        $this->m_guest->insertpembayaran($data);

        // Generate nomor tiket
        $cek = $this->m_guest->gettiket()->num_rows()+1;

        // input data penumpang
        for ($i=1;$i<=$penumpang;$i++) { 
            $data = array(
                'nomor_tiket' => $no_tiket,
                'nama' => $this->input->post('nama'.$i),
                'no_identitas' => $this->input->post('identitas'.$i)
            );

            $this->m_guest->insertpenumpang($data);
        }

        // input data pemesan
        $data = array(
            'nomor_tiket' => $no_tiket,
            'id_jadwal' => $this->input->post('id_jadwal'),
            'nama_pemesan' => $this->input->post('nama_pemesan'), 
            'email' => $this->input->post('email'), 
            'no_telepon' => $this->input->post('no_telp'), 
            'alamat' => $this->input->post('alamat'),
            'tanggal' => date('Y-m-d '),

        );

        $this->m_guest->insertpemesan($data);

        $this->session->set_flashdata('nomor', $no_pembayaran);
        $this->session->set_flashdata('total', $total_pembayaran);
        redirect('pembayaran', $total_pembayaran);

    }

    public function kehalamanPembayaran(){
        $data['judul'] = 'PEMBAYARAN';

        $this->load->view('guest/template/header', $data);
        $this->load->view('guest/pembayaran');
        $this->load->view('guest/template/footer');
    }

    public function cekkonfirmasi(){
        $kode = $this->input->post('kode');
        redirect("konfirmasi?kode=".$kode, $no_tiket);
    }

    public function PilihGerbong(){
        $kodenya = $this->input->post('kode');
        $nama = $this->input->post('nama');

        $kode = $this->m_guest->getPembayaranWhere($kodenya)->row();

        // Deklarasi
        $gerbong = $this->input->post('gerbong');
        $bagian = $this->input->post('bagian');
        $kursi = $this->input->post('kursi');

        $data = array(
            'gerbong'   => $gerbong,
            'bagian'    => $bagian,
            'kursi'     => $kursi
        );

        // Validasi Kursi
        $tiket = $this->m_guest->getTiketWhere($kode->no_tiket)->row();
        $cek = $this->m_guest->validasiGerbong($gerbong,$bagian,$kursi,$tiket->id_jadwal)->num_rows();

        if($cek > 0){ // Jika ada
            $this->session->set_flashdata('alert','Maaf Gerbong, Bagian, dan Kursi Sudah Ter ISI ');
            redirect('konfirmasi?kode='.$kodenya);
        }else{ // Jika tidak ada
            $update = $this->m_guest->PilihGerbong($data, $kode->no_tiket, $nama );
        }

        if($update){
            redirect('konfirmasi?kode='.$kodenya);
        }else{
            echo "Gagal";
        }
    }

    public function kirimkonfirmasi(){
        // Uploading Gambar
        $config['upload_path']          = './assets/bukti/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 2048; // 2MB

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile')){
            $error = array('error' => $this->upload->display_errors());
            print_r($error);
        }else{
            $data = $this->upload->data();
            $fileName = $data['file_name'];
            
            $no = $this->input->post('no_pembayaran');
            $this->m_guest->insertbukti($fileName, $no );

            $this->session->set_flashdata("pesan","Berhasil Mengirim Bukti! Silahkan Cek Kembali 12 Jam Kemudian. Untuk Mengecek Pembayaran Anda");
            redirect("konfirmasi");
        }
    }

    public function print(){
        $data['judul'] = 'Print';

        $no_tiket = $this->input->post('no_tiket');

        $data['detail'] = $this->m_guest->getPrint($no_tiket)->row();
        $data['jml_penumpang'] = $this->m_guest->cekKonfirmasi($no_tiket)->num_rows();

        $this->load->view('guest/template/header', $data);
        $this->load->view('print',$data);
        $this->load->view('guest/template/footer', $data);
    }
}