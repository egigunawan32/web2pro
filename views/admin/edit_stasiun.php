  <!DOCTYPE html>
  <html>
  <head>
      <title>Dashboard admin</title>
      <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.min.css') ?>">
  </head>
  <body>
     <?php include 'include/nav.php'; ?>
<div class="container my-4">
  <div class="row justify-content-center">
        <div class="col-md-5">
          <div class="card">
            <div class="card-header text-center bg-dark text-white">EDIT NAMA STASIUN</div>
            <form action="<?= base_url ('editstasiun') ?>" method="POST">
              <input type="hidden" name="id" value="<?= $data_stasiun->id ?>">
              <div class="form-group">
                <label class="text-center">Nama Stasiun</label>
                <input type="text" class="form-control" name="nama_stasiun" value="<?= $data_stasiun->nama_stasiun?>">
              </div>

              <button class="btn btn-dark btn-block">EDIT STASIUN</button>
            </form>
            <div class="card-body">
        
            </div>
          </div>
      </div>
   </div>
</div>

  <script src="<?=base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>