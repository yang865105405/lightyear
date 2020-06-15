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
function template_preprocess_editpt(&$vars) {
   // $nodenid = $vars['node_wrapper'] ;
   //获取nid
   $data =  $_GET;
   $nidstr = $data['q'];
   $nid =drupal_substr($nidstr,7, $length = NULL);
   $select = db_select('file_managed', 'file');
   $select->addField('file', 'uri', 'uri');

   $select->leftJoin('field_data_field_lightyear_photo', 'photo', 'file.fid = photo.field_lightyear_photo_fid');
   $select->leftJoin('node', 'n', 'n.nid = photo.entity_id');
   $select->condition('n.nid',  $nid);
   $bb=$select->__toString();
   $result = $select->execute()->fetchAll();
   //获取body的值
   $select = db_select('field_data_body', 'body');
   $select->addField('body', 'body_value', 'value');
   $select->condition('body.entity_id',  $nid);
   $bb=$select->__toString();
   $resultbody = $select->execute()->fetchAll();
   $body = $resultbody[0]->value;
   $resultarr = array();
   foreach ($result as $k => $v) {
      $nidval=$v->uri;
      $nidval = substr($nidval,strpos($nidval, 'photo'));
      $new_str = "http://192.168.0.213/" . $nidval;
      array_push($resultarr,$new_str);
   }
   $vars['resultarr']= $resultarr;
   $theme_path = drupal_get_path('theme', 'lightyear');
   $vars['theme_path'] =$theme_path;
   $vars['body'] =$body;
   
}

function template_preprocess_ptmanage(&$vars) {
   $theme_path = drupal_get_path('theme', 'lightyear');
   $vars['theme_path'] =$theme_path;
   $select = db_select('node', 'n');
   $select->condition('n.type', 'node_lightyear_photo');
   $select->addField('n', 'nid', 'nid');
   $bb=$select->__toString();
   $result = $select->execute()->fetchAll();
   $resultarr = array();
   foreach ($result as $k => $v) {
      $nidval=$v->nid;
      array_push($resultarr,$nidval);
   }
   $vars['resultarr']= $resultarr;
}