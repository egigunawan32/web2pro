<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <div class="row">
        <div class="col-md-8">
            <br> <br> <br>
        <h1 class="display-4">WELCOME TO E-TICKET</h1>
            <p class="lead">Melayani Pemesanan Tiket Kereta Api Secara Cepat Dan Mudah.</p>
        </div>

    <script src="<?=base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>
        <div class="col-md-4">
            <form action="<?= base_url('tiket') ?>" method="POST">
                <div class="form-group">
                    <label>Stasiun Awal</label>
                    <select name="asal" class="form-control">
                    <?php foreach ($stasiun as $st): ?>
                        <option value="<?= $st->id?>"><?= $st->nama_stasiun ?></option>
                    <?php endforeach ?>
                    </select>
                </div>

        <div class="form-group">
                    <label>Stasiun Tujuan</label>
                    <select name="tujuan" class="form-control">
                    <?php foreach ($stasiun as $st): ?>
                        <option value="<?= $st->id?>"><?= $st->nama_stasiun ?></option>
                    <?php endforeach ?>
                    </select>
                </div>

        <div class="form-group">
                    <label>Tanggal Keberangkatan</label>
                    <input type="date" name="tanggal" class="form-control">
                    
                    </select>
                </div>

        <div class="form-group">
                    <label>Jumlah Penumpang</label>
                    <select name="jumlah" class="form-control">
                        <?php for ($i=1; $i <=6 ; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?> Orang</option>
                        <?php endfor; ?>
                    </select>
                </div>

                <button class="btn btn-dark btn-block"> confirm </button>
            
            </form>
        </div>
    </div>

     </div>
    </div>
    <div class="container">
        <hr>
        <?php if (!isset($tiket)): ?>
            
        <?php else: ?>
            
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="bg-primary text-white text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Kereta</th>
                        <th>kelas</th>
                        <th>Tanggal Berangkat</th>
                        <th>Tanggal Sampai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">

                    <?php $no = 1; ?>
                    <?php foreach ($tiket as $tk): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $tk->nama_kereta ?></td>
                        <td><?= $tk->kelas ?></td>
                        <td><?php $date = date_create($tk->tgl_berangkat); echo date_format($date, "d-m-Y h:i:s");  ?></td>
                        <td><?php $date = date_create($tk->tgl_sampai); echo date_format($date, "d-m-Y h:i:s"); ?></td>
                        <td>
                            <a class="btn btn-primary">Pesan</a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <?php endif; ?>

    </div>