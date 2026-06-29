<!DOCTYPE html>
<html lang="id">
	<head>
		<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>
			<?=$this->setting->admin_title
				. ' ' . ucwords($this->setting->sebutan_desa)
				. (($desa['nama_desa']) ? ' ' . $desa['nama_desa']:  '')
				. get_dynamic_title_page_from_path();
			?>
		</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<?php if (is_file(LOKASI_LOGO_DESA . "favicon.ico")): ?>
			<link rel="shortcut icon" href="<?= base_url()?><?= LOKASI_LOGO_DESA?>favicon.ico" />
		<?php else: ?>
			<link rel="shortcut icon" href="<?= base_url()?>favicon.ico" />
		<?php endif; ?>
		<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?= base_url()?>rss.xml" />

		<!-- Phase 4: AdminLTE 3 + Bootstrap 4 Bundle (via Vite) -->
		<?php
			$dist_css = glob(FCPATH . 'assets/dist/css/admin-*.css');
			if (!empty($dist_css)):
				$filename = basename($dist_css[0]);
		?>
		<link rel="stylesheet" href="<?= base_url()?>assets/dist/css/<?= $filename ?>">
		<?php else: ?>
		<!-- Fallback: Load vendor CSS directly -->
		<link rel="stylesheet" href="<?= base_url()?>assets/dist/vendor/css/adminlte.min.css">
		<link rel="stylesheet" href="<?= base_url()?>assets/dist/vendor/css/fontawesome.min.css">
		<?php endif; ?>

		<!-- jQuery (must be loaded before other plugins) -->
		<script src="<?= base_url()?>assets/js/jquery.min.js"></script>

		<!-- jQuery UI -->
		<link rel="stylesheet" href="<?= base_url()?>assets/bootstrap/css/jquery-ui.min.css">

		<!-- bootstrap wysihtml5 - text editor -->
		<link rel="stylesheet" href="<?= base_url()?>assets/bootstrap/css/bootstrap3-wysihtml5.min.css">

		<!-- Style Admin Modification Css -->
		<link rel="stylesheet" href="<?= base_url()?>assets/css/admin-style.css">

		<!-- OpenStreetMap Css -->
		<link rel="stylesheet" href="<?= base_url()?>assets/css/leaflet.css" />
		<link rel="stylesheet" href="<?= base_url()?>assets/css/leaflet-geoman.css" />
		<link rel="stylesheet" href="<?= base_url()?>assets/css/L.Control.Locate.min.css" />
		<link rel="stylesheet" href="<?= base_url()?>assets/css/MarkerCluster.css" />
		<link rel="stylesheet" href="<?= base_url()?>assets/css/MarkerCluster.Default.css" />

		<!-- Untuk ubahan style desa -->
		<?php if (is_file("desa/css/siteman.css")): ?>
			<link type='text/css' href="<?= base_url()?>desa/css/siteman.css" rel='Stylesheet' />
		<?php endif; ?>

		<!-- OpenStreetMap Js-->
		<script src="<?= base_url()?>assets/js/leaflet.js"></script>
		<script src="<?= base_url()?>assets/js/turf.min.js"></script>
		<script src="<?= base_url()?>assets/js/leaflet-geoman.min.js"></script>
		<script src="<?= base_url()?>assets/js/leaflet.filelayer.js"></script>
		<script src="<?= base_url()?>assets/js/togeojson.js"></script>
		<script src="<?= base_url()?>assets/js/togpx.js"></script>
		<script src="<?= base_url()?>assets/js/leaflet-providers.js"></script>
		<script src="<?= base_url()?>assets/js/L.Control.Locate.min.js"></script>
		<script src="<?= base_url()?>assets/js/leaflet.markercluster.js"></script>
		<script src="<?= base_url()?>assets/js/peta.js"></script>

		<!-- Diperlukan untuk global automatic base_url oleh external js file -->
		<script type="text/javascript">
			var BASE_URL = "<?= base_url(); ?>";
		</script>

		<!-- Highcharts JS -->
		<script src="<?= base_url()?>assets/js/highcharts/highcharts.js"></script>
		<script src="<?= base_url()?>assets/js/highcharts/exporting.js"></script>
		<script src="<?= base_url()?>assets/js/highcharts/highcharts-more.js"></script>
	</head>
	<body class="sidebar-mini layout-fixed <?php if ($minsidebar==1): ?>sidebar-collapse<?php endif ?>">
		<div class="wrapper">
			<!-- AdminLTE 3 Navbar -->
			<nav class="main-header navbar navbar-expand navbar-white navbar-light">
				<!-- Left navbar links -->
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
					</li>
					<li class="nav-item d-none d-sm-inline-block">
						<a href="<?=site_url()?>first" target="_blank" class="nav-link"><strong>OpenSID</strong></a>
					</li>
				</ul>

				<!-- Right navbar links -->
				<ul class="navbar-nav ml-auto">
					<?php if ($this->CI->cek_hak_akses('b', 'komentar')): ?>
						<li class="nav-item">
							<a href="<?=site_url()?>komentar" class="nav-link">
								<i class="fas fa-comment" title="Komentar baru"></i>
								<span class="badge badge-warning navbar-badge" id="b_komentar"></span>
							</a>
						</li>
					<?php endif; ?>
					<?php if ($this->CI->cek_hak_akses('b', 'lapor')): ?>
						<li class="nav-item">
							<a href="<?=site_url()?>lapor" class="nav-link">
								<i class="fas fa-envelope" title="Laporan mandiri baru"></i>
								<span class="badge badge-info navbar-badge" id="b_lapor"></span>
							</a>
						</li>
					<?php endif; ?>
					<!-- User Dropdown Menu -->
					<li class="nav-item dropdown">
						<a class="nav-link" data-toggle="dropdown" href="#">
							<?php if ($foto): ?>
								<img src="<?= AmbilFoto($foto)?>" class="img-circle" alt="User Image" style="width: 25px; height: 25px;">
							<?php else :?>
								<img src="<?= base_url()?>assets/files/user_pict/kuser.png" class="img-circle" alt="User Image" style="width: 25px; height: 25px;">
							<?php endif; ?>
							<span class="d-none d-md-inline ml-2"><?=$nama?></span>
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
							<div class="dropdown-item dropdown-header">
								<?php if ($foto): ?>
									<img src="<?=AmbilFoto($foto)?>" class="img-circle" alt="User Image" style="width: 60px; height: 60px;">
								<?php else :?>
									<img src="<?= base_url()?>assets/files/user_pict/kuser.png" class="img-circle" alt="User Image" style="width: 60px; height: 60px;">
								<?php endif; ?>
								<p class="mt-2 mb-0">Anda Login Sebagai</p>
								<p class="font-weight-bold"><?=$nama?></p>
							</div>
							<div class="dropdown-divider"></div>
							<a href="<?=site_url()?>user_setting/" data-remote="false" data-toggle="modal" data-tittle="Pengaturan Pengguna" data-target="#modalBox" class="dropdown-item">
								<i class="fas fa-user mr-2"></i> Profil
							</a>
							<div class="dropdown-divider"></div>
							<a href="<?=site_url()?>siteman" class="dropdown-item dropdown-footer">
								<i class="fas fa-sign-out-alt mr-2"></i> Keluar
							</a>
						</div>
					</li>
				</ul>
			</nav>

			<input id="success-code" type="hidden" value="<?= $_SESSION['success']?>">

			<!-- Untuk menampilkan modal bootstrap umum -->
			<div class="modal fade" id="modalBox" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class='modal-dialog'>
					<div class='modal-content'>
						<div class='modal-header'>
							<h4 class='modal-title' id='myModalLabel'>Pengaturan Pengguna</h4>
							<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
								<span aria-hidden='true'>&times;</span>
							</button>
						</div>
						<div class="fetched-data"></div>
					</div>
				</div>
			</div>

			<!-- Untuk menampilkan modal / pemberitahuan perubahan password default -->
			<div class="modal fade" id="massageBox" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class='modal-dialog'>
					<div class='modal-content'>
						<div class='modal-header bg-info'>
							<h4 class='modal-title' id='myModalLabel'><i class='fas fa-exclamation-triangle text-warning'></i> &nbsp;<?= $_SESSION['admin_warning'][0]; ?></h4>
							<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
								<span aria-hidden='true'>&times;</span>
							</button>
						</div>
						<div class='modal-body'>
							<?= $_SESSION['admin_warning'][1]; ?>
						</div>
						<div class='modal-footer'>
							<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal"><i class='fas fa-arrow-circle-left'></i> Lain Kali</button>
							<a href="<?= site_url()?>user_setting/" data-remote="false" data-tittle="Pengaturan Pengguna" data-toggle="modal" data-target="#modalBox" id="ok">
								<button type="button" class="btn btn-success btn-sm"><i class='fas fa-edit'></i> Ubah</button>
							</a>
						</div>
					</div>
				</div>
			</div>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
