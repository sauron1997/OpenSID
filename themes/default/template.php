<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view($folder_themes.'/layouts/header.php');?>
			<!-- Phase 5: Modern Grid Layout + Phase 6: ARIA Landmarks -->
			<div class="site-container">
				<main id="main-content" class="site-main" role="main">
					<div class="content-area">
						<?php $this->load->view($folder_themes.'/partials/content.php');?>
					</div>

					<aside class="sidebar-area" role="complementary" aria-label="Sidebar">
						<?php $this->load->view(Web_Controller::fallback_default($this->theme, '/partials/side.right.php'));?>
					</aside>
				</main>

				<footer class="site-footer" role="contentinfo">
					<?php if (!is_null($transparansi)) $this->load->view($folder_themes. '/partials/apbdesa-tema.php', $transparansi);?>
					<?php $this->load->view($folder_themes.'/partials/copywright.tpl.php');?>
				</footer>
			</div>
		</div>
	</body>
</html>
