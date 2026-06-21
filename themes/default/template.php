<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view($folder_themes.'/layouts/header.php');?>
			<!-- Phase 5: Modern Grid Layout -->
			<div class="site-container">
				<div class="site-main">
					<div class="content-area">
						<?php $this->load->view($folder_themes.'/partials/content.php');?>
					</div>

					<div class="sidebar-area">
						<?php $this->load->view(Web_Controller::fallback_default($this->theme, '/partials/side.right.php'));?>
					</div>
				</div>

				<footer class="site-footer">
					<?php if (!is_null($transparansi)) $this->load->view($folder_themes. '/partials/apbdesa-tema.php', $transparansi);?>
					<?php $this->load->view($folder_themes.'/partials/copywright.tpl.php');?>
				</footer>
			</div>
		</div>
	</body>
</html>
