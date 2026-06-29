<div class="content-wrapper">
	<section class="content-header">
		<h1>Pengaturan SMS</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid')?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Pengaturan SMS</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form id="validasi" action="<?=$form_action?>" method="POST" enctype="multipart/form-data" class="">
			<div class="row">
				<div class="col-md-3">
					<div class="card card-info">
						<div class="card-header with-border">
							<h3 class="card-title">SMS</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="card-body no-padding">
							<ul class="nav nav-pills nav-stacked">
								<li class="active"><a href="<?= site_url('sms/setting')?>"><i class="fa fa-inbox"></i> Pengaturan Balas Otomatis</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="card card-info">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
								  <div class="form-group">
									<label class="col-sm-3 col-form-label" for="pesan">Isi Pesan Autoreply</label>
									<div class="col-sm-8">
									  <textarea id="autoreply_text" name="autoreply_text" class="form-control input-sm required" placeholder="Isi Pesan Autoreply"><?php if ($main): ?><?=$main['autoreply_text'];?><?php endif ?></textarea>
									</div>
								  </div>
								</div>
							</div>
						</div>
						<div class='card-footer'>
							<div class='col-12'>
								<button type='reset' class='btn btn-social btn-flat btn-danger btn-sm' ><i class='fa fa-times'></i> Batal</button>
								<button type='submit' class='btn btn-social btn-flat btn-info btn-sm float-right confirm'><i class='fa fa-check'></i> Simpan</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>

