<?php if($this->session->flashdata('nomor') === null): ?>

<div class='container-fluid'>
    <div class='row justify-content-center my-3'>
        <div class='col-md-5 '>
        <div class='alert alert-danger'>
            <h4>Anda Telah Merefresh Halaman !!</h4>
            <p>Silahkan Lakukan Pemesanan Kembali Jika Belum mendapat Kode Pembayaran</p>
        </div>
    </div>
</div>

<?php else: ?>

<div class="container-fluid">
    <div class='row justify-content-center my-3'>
        <div class='col-md-5'>
        <div class='alert alert-danger'>
            <h5>PERINGATAN !! <br> JANGAN REFRESH HALAMAN</h5>
            <p>Untuk Menghindari Kegagalan.</p>
        </div>
            <div class="card">
                <div class="card-body">
                    <h1 class='text-success'>Selamat</h1>
                    <h6>Anda Berhasil Melakukan Pemesanan Tiket!</h6>
                    <hr>
                    <h5 class='text-danger text-center'>Silahkan Lakukan Pembayaran Sesuai Berikut</h5>
                    <br>
                    <h4 class="text-center">A0234567897658</h4>
                    <p class='text-center font-weight-bold mb-0'>a/n PT. E-TICKET Indonesia</p>
                    <p class="text-center">BCA (Bank Central Ashiap) Kode Bank : 001</p>

                    <hr>

                    <h6 class="text-center">Total Yang Harus Dibayar</h6>
                    <h2 class='text-center'><?= $this->session->flashdata('total') ?></h2>
                    <hr>
                    <h6 class="text-center">Kode Pembayaran Anda</h6>
                    <h2 class='text-center'><?= $this->session->flashdata('nomor') ?></h2>
                    <br><br>
                    <p class='text-danger'>*Jika Sudah Transfer Lakukan Konfirmasi Pembayarn pada link 
                        <a target="blank" href="<?= base_url('konfirmasi') ?>">Konfirmasi Pembayaran </a> 
                    </p>
                    <h4 class='text-center'>TERIMA KASIH</h4>
                </div>
            </div>
	   </div>
    </div>
</div>

<?php endif; ?>
