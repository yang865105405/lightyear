<?php
/**
 * Implements hook_theme
 */
function lightyear_theme($existing, $type, $theme, $path) {
  $path = drupal_get_path('theme', 'lightyear');

  $themes = array(
    'header' => [
      'variabels' => ['theme_path' => $path],
      'template' => 'templates/header'
    ],
    'leftbar' => [
      'variables' => ['theme_path' => $path],
      'template' => 'templates/leftbar'
    ],
  );

  return $themes;
}

/**
 * 左边栏配置
 */
function lightyear_preprocess_leftbar(&$vars){
  global $theme_path;
  global $user;
  //加载自定义菜单
  $menu = menu_tree_all_data('menu-menu-lightyear-main-menu');
  $i = 0;
  $icon = '';
  $cp = current_path();
  foreach ($menu as $k => $m) {
    $menu[$k]['is_active'] = FALSE;
    if (count($m['below']) > 0) {
      foreach($m['below'] as $l) {
        if($l['link']['link_path'] == $cp) {
          $menu[$k]['is_active'] = TRUE;
          break;
        }
      }
    }
    switch ($i) {
      case 0 :
        $icon = 'mdi-home';
        break;
      case 1 :
        $icon = 'mdi-palette';
        break;
      case 2 :
        $icon = 'mdi-format-align-justify';
        break;
      case 3 :
        $icon = 'mdi-file-outline';
        break;
      case 4 :
        $icon = 'mdi-language-javascript';
        break;
      case 5 :
        $icon = 'mdi-menu';
        break;
    }
    $i++;
    $menu[$k]['icon'] = $icon;
  }
  $vars['left_menu'] = $menu;
}
      
  

      
  
function lightyear_preprocess_page(&$vars) {
  global $user;
  $path = drupal_get_path('theme', 'lightyear');
  $pa = explode('/', current_path());

  $vars['is_lightyear_page'] = current(explode('/', current_path())) == 'lightyear';

  $vars['theme_path'] = $path;

 
}



