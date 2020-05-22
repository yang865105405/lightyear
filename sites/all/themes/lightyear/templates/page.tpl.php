
<?php if($is_index_page) : ?>
	<?php print render($page['content']);?>
<?php else :?>
	<div class="lyear-layout-web">
		<div class="lyear-layout-container">	
			<?php if($is_user_page) : ?>
				<main class="lyear-layout-content">
					<div class="container-fluid">
						<?php print render($page['content']);?>
					</div>
				</main>
			<?php else :?>
				<?php print theme('leftbar', array());?>
				<?php print theme('header', array());?>
				<main class="lyear-layout-content">
					<div class="container-fluid">
						<?php print render($page['content']);?>
					</div>
				</main>
			<?php endif;?>	
		</div>
	</div>
<?php endif;?>			
<script>
jQuery.browser = {};
	(function () {
		jQuery.browser.msie = false;
		jQuery.browser.version = 0;
		if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
			jQuery.browser.msie = true;
			jQuery.browser.version = RegExp.$1;
		}
	})();
</script>