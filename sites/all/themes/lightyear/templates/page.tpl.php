
<div class="lyear-layout-web">
  <div class="lyear-layout-container">
	     <?php print theme('leftbar', array());?>
	     <?php print theme('header', array());?>
        <!--页面主要内容-->
	    <main class="lyear-layout-content">
	      <div class="container-fluid">
	         <?php print render($page['content']);?>
	      </div>
	    </main>
    <!--End 页面主要内容-->
        
  </div>
</div>
