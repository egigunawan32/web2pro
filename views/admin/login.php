<!DOCTYPE html>
<div class="jumbotron jumbotron-fluid">
	<style>
.jumbotron{
  background:url('<?= base_url("assets/lg.png") ?>')
</style>
<html>
<head>
	<title>login</title>
	<link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-md-3">
				<div class="card my-5">
					<div class="card-header bg-dark text-white text-center">LOGIN</div>
					<div class="card-body">
						
						<form action="<?= base_url('proseslogin') ?>" method="POST">
							
							<div class="form-group text-center">
								<label>USERNAME</label>
								<input type="text" name="username" placeholder="Username" class="form-control">
							</div>

							<div class="form-group text-center">
								<label>PASSWORD</label>
								<input type="password" name="password" placeholder="Password" class="form-control">
							</div>

							<button class="btn btn-success float-right btn-block text-center">Login</button>

						</form>

					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>
