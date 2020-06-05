<?php

function template_preprocess_front(&$vars) {
   $theme_path = drupal_get_path('theme', 'lightyear');
   $vars['theme_path'] =$theme_path;
}
function template_preprocess_aa(&$vars) {
   $theme_path = drupal_get_path('theme', 'lightyear');
   $vars['theme_path'] =$theme_path;

}

function template_preprocess_index(&$vars) {
   $theme_path = drupal_get_path('theme', 'lightyear');
   $vars['theme_path'] =$theme_path;
}