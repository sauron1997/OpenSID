			</div>
			<!-- /.content-wrapper -->

			<footer class="main-footer">
				<div class="float-right d-none d-sm-block">
					<b>Versi</b> <?= AmbilVersi()?>
				</div>
				<strong>Aplikasi <a href="https://github.com/OpenSID/OpenSID" target="_blank"> OpenSID</a>, dikembangkan oleh <a href="https://www.facebook.com/groups/OpenSID/" target="_blank">Komunitas OpenSID</a>.</strong>
			</footer>
		</div>

		<!-- jQuery UI -->
		<script src="<?= base_url()?>assets/bootstrap/js/jquery-ui.min.js"></script>
		<script src="<?= base_url()?>assets/bootstrap/js/jquery.ui.autocomplete.scroll.min.js"></script>

		<!-- Moment.js -->
		<script src="<?= base_url()?>assets/dist/vendor/js/moment.min.js"></script>
		<script src="<?= base_url()?>assets/dist/vendor/js/moment-id.js"></script>

		<!-- Bootstrap 4 JS (included in AdminLTE 3) - loaded via vendor -->
		<script src="<?= base_url()?>assets/dist/vendor/js/select2.min.js"></script>
		<script src="<?= base_url()?>assets/dist/vendor/js/select2-id.js"></script>

		<!-- DataTables BS4 -->
		<script src="<?= base_url()?>assets/dist/vendor/js/dataTables.bootstrap4.min.js"></script>

		<!-- SweetAlert2 -->
		<script src="<?= base_url()?>assets/dist/vendor/js/sweetalert2.all.min.js"></script>

		<!-- Bootstrap Colorpicker -->
		<script src="<?= base_url()?>assets/dist/vendor/js/bootstrap-colorpicker.min.js"></script>

		<!-- Bootstrap Daterangepicker -->
		<script src="<?= base_url()?>assets/dist/vendor/js/daterangepicker.js"></script>

		<!-- jQuery Validation -->
		<script src="<?= base_url()?>assets/dist/vendor/js/jquery.validate.min.js"></script>
		<script src="<?= base_url()?>assets/dist/vendor/js/additional-methods.min.js"></script>

		<!-- Bootstrap WYSIHTML5 -->
		<script src="<?= base_url()?>assets/bootstrap/js/bootstrap3-wysihtml5.all.min.js"></script>

		<!-- Slimscroll -->
		<script src="<?= base_url()?>assets/bootstrap/js/jquery.slimscroll.min.js"></script>

		<!-- AdminLTE 3 JS (includes Bootstrap 4 JS) -->
		<script src="<?= base_url()?>assets/dist/vendor/js/adminlte.min.js"></script>

		<!-- Validasi & Numeral -->
		<script src="<?= base_url()?>assets/js/validasi.js"></script>
		<script src="<?= base_url()?>assets/js/numeral.min.js"></script>

		<!-- OpenSID Admin Bundle (Vite - Phase 3/4) -->
		<?php
			// Gunakan Vite bundle jika sudah di-build, fallback ke script.js
			$dist_js = glob(FCPATH . 'assets/dist/js/admin-*.js');
			if (!empty($dist_js)):
				$filename = basename($dist_js[0]);
		?>
		<script src="<?= base_url()?>assets/dist/js/<?= $filename ?>"></script>
		<?php else: ?>
		<script src="<?= base_url()?>assets/js/script.js"></script>
		<?php endif; ?>

		<!-- NOTIFICATION-->
		<script type="text/javascript">

			$('document').ready(function()
			{

				setTimeout(function()
				{
					if ( $("#b_komentar").length )
					{
						$("#b_komentar").load("<?= site_url()?>notif/komentar");
						var refreshKomentar = setInterval(function()
						{
							$("#b_komentar").load("<?= site_url()?>notif/komentar");
						}, 3000);
					}
					if ( $("#b_lapor").length )
					{
						$("#b_lapor").load("<?= site_url()?>notif/lapor");
						var refreshLapor = setInterval(function()
						{
							$("#b_lapor").load("<?= site_url()?>notif/lapor");
						}, 3000);
					}
				}, 500);
				if ($('#success-code').val() == 1)
				{
					notify = 'success';
					notify_msg = 'Data berhasil disimpan';
				}
				else if ($('#success-code').val() == -1)
				{
					notify = 'error';
					notify_msg = 'Data gagal disimpan <?= $_SESSION["error_msg"]?>';
				}
				else if ($('#success-code').val() == -2)
				{
					notify = 'error';
					notify_msg = 'Data gagal diimpan, nama id sudah ada!';
				}
				else if ($('#success-code').val() == -3)
				{
					notify = 'error';
					notify_msg = 'Data gagal diimpan, nama id sudah ada!';
				}
				else if ($('#success-code').val() == 4)
				{
					notify = 'success';
					notify_msg = 'Data berhasil dihapus';
				}
				else if ($('#success-code').val() == -4)
				{
					notify = 'error';
					notify_msg = 'Data gagal dihapus';
				}
				else
				{
					notify = '';
					notify_msg = '';
				}
				notification(notify, notify_msg);
				$('#success-code').val('');
			});
		</script>
		<?php $_SESSION['success']=0; ?>

		<!-- Notifikasi Ganti Password Login -->
		<?php if ($this->session->admin_warning && !config_item('demo')): ?>
			<script type="text/javascript">
				<?php if (isset($_SESSION['dari_login'])): ?>
					$(window).on('load', function()
					{
						$('#massageBox').modal('show');
						$('#ok').click(function() {$('#massageBox').modal('hide');});
					});
					<?php unset($_SESSION['dari_login']) ?>
				<?php endif; ?>
			</script>
		<?php endif ?>

		<!-- Notifikasi PIN Warga -->
		<script type="text/javascript">
			<?php if ($_SESSION['pin']): ?>
				$(window).on('load', function()
				{
					$('#pinBox').modal('show');
				});
				<?php unset($_SESSION['pin']) ?>
			<?php endif ?>
		</script>
	</body>
</html>
