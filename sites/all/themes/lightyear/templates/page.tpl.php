

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