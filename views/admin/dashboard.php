<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/datatables.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/datatables-b4.css') ?>">
</head>
<body>
  <?php include 'include/nav.php'; ?>

  <div class="container-fluid my-4">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header bg-dark text-white text-center">Daftar Stasiun</div>
          <div class="card-body">
            <table class="table table-striped table-bordered datatables">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Stasiun</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php  $no = 1; ?>
                <?php foreach ($stasiun as $st): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $st->nama_stasiun ?></td>
                  <td>
                    <div class='btn-group btn-group-sm'>
                      <a class="btn btn-danger" href="<?= base_url('hapusstasiun/'.$st->id) ?>">Hapus</a>
                      <a class="btn btn-primary" href="<?= base_url('admin/dashboard/edit/'.$st->id) ?>">Edit</a>
                    </div>  
                  </td>
                </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header bg-dark text-center text-white">Form Tambah Stasiun</div>
          <div class="card-body">
            <form action="<?= base_url('tambahstasiun') ?>" method="POST">
              <div class="form-group">
                <label>Nama Stasiun</label>
                <input type="text" class="form-control" name="stasiun" placeholder="Nama Stasiun">
              </div>

              <button class="btn btn-block btn-primary">Tambah Staisun</button>
            </form> 
          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/datatables.js') ?>"></script>
  <script src="<?= base_url('assets/js/datatables-b4.js') ?>"></script>
  <?php include 'include/datatables.php'; ?>
</body>
</html>