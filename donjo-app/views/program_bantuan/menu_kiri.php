<div id="penduduk" class="card card-info">
	<div class="card-header with-border">
		<h3 class="card-title">Program Bantuan</h3>
		<div class="card-tools">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>
	<div class="card-body no-padding">
		<ul class="nav nav-pills nav-stacked">
			<li <?php if ($lap=='1'): ?>class="active"<?php endif; ?>><a href="<?=site_url('program_bantuan/create')?>"><i class="fa fa-pencil"></i> Tambah Program Bantuan</a></li>
      <li <?php if ($lap=='0'): ?>class="active"<?php endif; ?>><a href="<?=site_url('program_bantuan')?>"><i class="fa fa-list"></i> Daftar Program Bantuan</a></li>
			<li <?php if ($lap=='2'): ?>class="active"<?php endif; ?>><a href="<?=site_url('program_bantuan/panduan')?>"><i class="fa fa-question-circle"></i> Panduan</a></li>
		</ul>
	</div>
</div>
