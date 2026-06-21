<div class="content-wrapper">
	<section class="content-header">
		<h1>Pengaturan Tipe Area</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid')?>"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?= site_url('polygon')?>"><i class="fa fa-dashboard"></i> Daftar Tipe Area</a></li>
			<li class="active">Pengaturan Tipe Area</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
	<form id="validasi" action="<?= $form_action?>" method="POST" enctype="multipart/form-data" class="">
			<div class="row">
				<div class="col-md-3">
          <?php $this->load->view('plan/nav.php')?>
				</div>
				<div class="col-md-9">
					<div class="card card-info">
            <div class="card-header with-border">
							<a href="<?= site_url("polygon")?>" class="btn btn-social btn-flat btn-info btn-sm btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block">
								<i class="fa fa-arrow-circle-left "></i>Kembali ke Daftar Tipe Area
            	</a>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label class="col-form-label col-sm-3">Nama Jenis Area</label>
								<div class="col-sm-7">
									<input name="nama" class="form-control input-sm required" type="text" value="<?=$polygon['nama']?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-form-label col-sm-3">Warna</label>
								<div class="col-sm-4">
									<div class="input-group my-colorpicker2">
										<input type="text" id="color" name="color" class="form-control input-sm required" placeholder="#FFFFFF" value="<?= $polygon['color']?>">
										<div class="input-group-text input-sm">
											<i></i>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class='card-footer'>
							<div class='col-12'>
								<button type='reset' class='btn btn-social btn-flat btn-danger btn-sm'><i class='fa fa-times'></i> Batal</button>
								<button type='submit' class='btn btn-social btn-flat btn-info btn-sm float-right confirm'><i class='fa fa-check'></i> Simpan</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>
