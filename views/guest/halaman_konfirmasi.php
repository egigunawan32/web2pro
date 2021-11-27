<div class="jumbotron jumbotron-fluid">
	<div class="row justify-content-center my-5">
		<div class="col-md-6">
			<?php if($this->session->flashdata('pesan') !== NULL): ?>
			<div class="alert alert-success">
				<?= $this->session->flashdata('pesan') ?>
			</div>
			<?php endif; ?>
			<div class="card">
				<div class="card-header bg-dark text-center text-white">
					KONFIRMASI PEMBAYARAN
				</div>
				<div class="card-body">
					<form action="<?= base_url('cekkonfirmasi') ?>" method="POST">

						<div class="form-group">
							<label>KODE PEMBAYARAN</label>
							<input name ='kode' type="text" class="form-control text-center" placeholder="masukan kode">
						</div>
						<div></div>
							<button class="btn btn-dark">KONFIRMASI</button>

					</form>
				</div>
			</div>
			<hr>
			<?php if(isset($_GET['kode'])): ?>
				<h5 class="text-white">Kode Booking : <?= $_GET['kode'] ?></h5>
			<div class="card">
				<div class="card-header bg-dark text-center text-white">
					Detail Pembayaran
				</div>
				<div class="card-body">
					<h3 class="text-center">
						<?php if($no_tiket->status === '0' || $no_tiket->status === '1'): ?>
							<i class="fa fa-times text-danger"></i> Belum Di Bayar
						<?php elseif($no_tiket->status === '2'): ?>
							<i class="fa fa-check text-success"></i> Sudah Di Bayar
						<?php endif; ?>
					</h3>
					<?php  if($this->session->flashdata('alert') !== null): ?>
						<div class="alert alert-danger">
							<?= $this->session->flashdata('alert') ?>
						</div>
					<?php endif; ?>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr class="text-center">
									<th>Nama</th>
									<th>Identitas</th>
									<th>Gerbong</th>
									<th>Bagian</th>
									<th>Kursi</th>
									<?php if($no_tiket->status !== '2'): ?>
									<th>Aksi</th>
									<?php else: endif; ?>
								</tr>
							</thead>
							<tbody>

							<?php foreach($detail as $dt): ?>
								<tr class="text-center">
									<td><?= $dt->nama ?></td>
									<td><?= $dt->no_identitas ?></td>
									<td><?= $dt->gerbong ?> </td>
									<td><?= $dt->bagian ?></td>
									<td><?= $dt->kursi ?></td>
									<?php if($no_tiket->status !== '2'): ?>
									<td>
										<?php if($dt->gerbong === NULL || $dt->bagian === NULL || $dt->kursi === NULL): ?>
											<a data-toggle="modal" data-target="#pilihGerbong<?= $dt->id?>" class="btn btn-warning" href="">pilih</a>
										<?php else: ?>
											<a data-toggle="modal" data-target="#gantiGerbong<?= $dt->id?>" class="btn btn-sm btn-success" href="">ganti</a>
										<?php endif; ?>
									</td>
									<?php else: endif; ?>
								</tr>

								<?php if($dt->gerbong !== NULL && $dt->kursi !== NULL && $dt->bagian !== NULL): ?>
								
								<!-- Modal Ganti -->
								<div class="modal fade" id="gantiGerbong<?= $dt->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Ganti Gerbong</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<form action="<?= base_url('PilihGerbong') ?>" method="post">
										<input type="hidden" name="kode" value="<?= $_GET['kode'] ?>">
										<input type="hidden" name="nama" value="<?= $dt->nama ?>">

										<div class="modal-body">

											<img class="img-fluid img_gerbong">
											
											<select class="form-control select_gerbong"  name="gerbong" required>
												<option value="0">=== PILIH GERBONG ===</option>
												<?php for ($i=1; $i <= 3 ; $i++): ?>

													<?php 

													if($dt->gerbong == $i): 
														$select = 'selected';
													else: 
														$select = '';
													endif;
													?>

													<option <?= $select ?> value="<?= $i ?>">Gerbong <?= $i ?></option>

												<?php endfor; ?>
											</select><br>

											<select class="form-control bagian" name="bagian" required onchange="cekBagian()">
												<option value="0">--- PILIH BAGIAN ---</option>

												<?php for ($i='a'; $i <='b' ; $i++): ?>

												<?php 

												if($dt->bagian === $i): 
													$select = 'selected';
												else: 
													$select = '';
												endif;
												?>

												<option <?= $select ?> value="<?= $i ?>"><?= $i ?></option>

												<?php endfor; ?>


											</select><br>

											<select class="form-control bagian_a" name="kursi" required>
												<?php for ($i=1; $i <=29 ; $i++): ?>


												<?php 

												if($dt->kursi == $i): 
													$select = 'selected';
												else: 
													$select = '';
												endif;
												?>

												<option <?= $select ?> value="<?= $i ?>"><?= $i ?></option>
												<?php endfor; ?>
											</select>

											<select class="form-control bagian_b" name="kursi" required>
												<?php for ($i=1; $i <=20 ; $i++): ?>

												<?php 

												if($dt->kursi == $i): 
													$select = 'selected';
												else: 
													$select = '';
												endif;
												?>

												<option <?= $select ?> value="<?= $i ?>"><?= $i ?></option>
												<?php endfor; ?>
											</select>

										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-warning">Ganti Gerbong</button>
										</div>
										</form>
										</div>
									</div>
								</div>
								<?php else: ?>
								

								<!-- Modal Pilih -->
								<div class="modal fade" id="pilihGerbong<?= $dt->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Pilih Gerbong</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
											</div>

											<form action="<?= base_url('PilihGerbong') ?>" method="post">
												<input type="hidden" name="kode" value="<?= $_GET['kode'] ?>">
												<input type="hidden" name="nama" value="<?= $dt->nama ?>">
												<div class="modal-body">

													<img class="img-fluid img_gerbong" src="" alt="">

													<select class="form-control select_gerbong" name="gerbong" required>
														<option value="0" selected>--- PILIH GERBONG ---</option>
														<option value="1">Gerbong 1</option>
														<option value="2">Gerbong 2</option>
														<option value="3">Gerbong 3</option>
													</select><br>

													<select class="form-control bagian" name="bagian" required onchange="cekBagian()">
								s						<option value="0" selected>--- PILIH SISI ---</option>
														<option value="a">A</option>
														<option value="b">B</option>
													</select>
													
													<br>
													<select class="form-control bagian_a" name="kursi" required>
														<?php for ($i=1; $i <=29 ; $i++): ?>
														<option value="<?= $i ?>"><?= $i ?></option>
														<?php endfor; ?>
													</select>

													<select class="form-control bagian_b" name="kursi" required>
														<?php for ($i=1; $i <=20 ; $i++): ?>
														<option value="<?= $i ?>"><?= $i ?></option>
														<?php endfor; ?>
													</select>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
													<button type="submit" class="btn btn-success">Pilih Gerbong</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							<?php endif; ?>

							<?php endforeach; ?>
							
							</tbody>
						</table>
						<p><b>Total Pembayaran Anda : </b> Rp. <?= $no_tiket->total_pembayaran ?></p>
						<?php if($no_tiket->status === '2'): ?>
							<form action="<?= base_url('print') ?>" method="post">
								<input type="hidden" name="no_tiket" value="<?= $no_tiket->no_tiket ?>" >
								<button type="submit" class="btn btn-danger btn-block">Print</button>
							</form>
						<?php endif; ?>
						<?php if($no_tiket->status == '0'): ?>
						<p class="text-danger">Silahkan Kirim Bukti Pembayaran Anda.</p>
						<?= form_open_multipart('kirimkonfirmasi'); ?>
						<input type="hidden" name='no_pembayaran' value='<?= $no_tiket->no_pembayaran ?>'>
						<p>Foto Bukti Pembayaran</p>
						<input type="file" name='userfile' class='form-control'>
						<p class="d-none" id="pesan"></p>
						<button id="btn_konfirmasi" type="submit" class="btn btn-block btn-dark">Kirim Bukti</button>
						<?= form_close(); ?>
						<?php else: ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>