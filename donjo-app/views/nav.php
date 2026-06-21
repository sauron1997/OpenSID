<!-- AdminLTE 3 Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?= site_url()?>" class="brand-link">
		<img src="<?= LogoDesa($desa['logo']);?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">
			<?=ucwords($this->setting->sebutan_desa." ".$desa['nama_desa']);?>
		</span>
	</a>
	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="float-left image mr-2">
				<img src="<?= LogoDesa($desa['logo']);?>" class="img-circle elevation-2" alt="Desa">
			</div>
			<div class="float-left info">
				<small>
					<?php
						$nam_kec = strlen($desa['nama_kecamatan']);
						$nam_kab = strlen($desa['nama_kabupaten']);
					?>
					<?php	if ($nam_kec<=12 AND $nam_kab<=12): ?>
						<?=ucwords($this->setting->sebutan_kecamatan." ".$desa['nama_kecamatan']);?>
						<br>
						<?=ucwords($this->setting->sebutan_kabupaten." ".$desa['nama_kabupaten']);?>
					<?php	else: ?>
						<?=ucwords(substr($this->setting->sebutan_kecamatan,0,3).". ".$desa['nama_kecamatan']);?>
						<br>
						<?=ucwords(substr($this->setting->sebutan_kabupaten,0,3).". ".$desa['nama_kabupaten']);?>
					<?php	endif; ?>
				</small>
			</div>
		</div>
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-header">MENU UTAMA</li>
				<?php foreach ($modul AS $mod): ?>
					<?php if (count($mod['submodul'])==0): ?>
						<li class="nav-item <?php ($this->modul_ini==$mod['id']) and print('')?>">
							<a href="<?= site_url()?><?=$mod['url']?>" class="nav-link <?php ($this->modul_ini==$mod['id']) and print('active')?>">
								<i class="nav-icon fas <?= $mod['ikon']?>"></i>
								<p><?=$mod['modul']?></p>
							</a>
						</li>
					<?php else : ?>
						<li class="nav-item has-treeview <?php ($this->modul_ini==$mod['id']) and print('menu-open active')?>">
							<a href="#" class="nav-link <?php ($this->modul_ini==$mod['id']) and print('active')?>">
								<i class="nav-icon fas <?= $mod['ikon']?>"></i>
								<p>
									<?=$mod['modul']?>
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview <?php ($this->modul_ini==$mod['id']) and print('')?>">
								<?php foreach ($mod['submodul'] as $submod): ?>
									<li class="nav-item">
										<a href="<?= site_url()?><?=$submod['url']?>" class="nav-link <?php ($act_sub==$submod['id']) and print('active')?>">
											<i class="far <?= ($submod['ikon'] != NULL) ? 'fas '.$submod['ikon'] : 'fa-circle'?> nav-icon"></i>
											<p><?=$submod['modul']?></p>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
