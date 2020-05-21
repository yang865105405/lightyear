    <!--左侧导航-->
    <aside class="lyear-layout-sidebar">
      
      <!-- logo -->
      <div id="logo" class="sidebar-header">
        <a href="#"><img src="<?php print($theme_path) ?>/images/logo-sidebar.png" title="LightYear" alt="LightYear" /></a>
      </div>
      <div class="lyear-layout-sidebar-scroll"> 
        
        <nav class="sidebar-main">
          <ul class="nav nav-drawer">

            <?php foreach($left_menu as $m) : ?>
              <?php if(count($m['below']) == 0) : ?>
                <li class = "nav-item active">
                  <a href="<?php print url($m['link']['link_path']);?>"> <i class="mdi <?php print $m['icon'] ?>"></i> <?php print $m['link']['link_title'];?></a> </a>
                </li>
              <?php endif; ?>
              <?php if(count($m['below']) > 0) : ?>
                <li class = "nav-item nav-item-has-subnav">
                  <a href="javascript:void(0)"> <i class="mdi <?php print $m['icon'] ?>"></i> <?php print $m['link']['link_title'];?></a> </a>
                    <ul class="nav nav-subnav">
                      <?php foreach($m['below'] as $im) : ?>
                        <li>
                          <a href="<?php print url($im['link']['link_path']);?>"><?php print $im['link']['link_title'];?></a>
                        </li>
                      <?php endforeach;?>
                    </ul>
                </li>
              <?php endif; ?>
            <?php endforeach;?>            
          </ul>
        </nav>
        
        <div class="sidebar-footer">
            左侧页脚待添加内容
        </div>
      </div>
      
    </aside>
    <!--End 左侧导航-->