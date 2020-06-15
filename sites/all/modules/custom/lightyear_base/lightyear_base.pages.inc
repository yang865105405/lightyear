<?php


/**
 * 首页内容
 */
function lightyear_base_front_page() {
  if(!user_is_logged_in()) {
    drupal_goto('index');
    return;
  }
  return theme('front', array());
}
/**
 * 首页内容
 */
function lightyear_base_aa_page() {
  if(!user_is_logged_in()) {
    drupal_goto('index');
    return;
  }
  return theme('aa', array());
}

/**
 * 首页内容
 */
function lightyear_base_index_page() {

  return theme('index', array());
}
/**
 * 编辑页面
 */
function lightyear_base_editpt_page($node) {

  $node_wrapper = entity_metadata_wrapper('node', $node);
  return theme('editpt', array('node_wrapper' => $node_wrapper));
}
/**
 * 管理页面
 */
function lightyear_base_ptmanage_page() {
  
  return theme('ptmanage', array());
}
