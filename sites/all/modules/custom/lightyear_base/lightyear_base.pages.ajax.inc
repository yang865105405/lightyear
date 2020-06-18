<?php
function lightyear_user_log() {
    global $user;
    $response = array(
        'status' => 'success',
        'message' => '登录成功'
    );

    $name = $_REQUEST['username'];
    $pass = $_REQUEST['password'];
    $node_title = db_query('SELECT count(*) FROM {users} WHERE name = :name and pass = :pass', array(':name' => $name,':pass' => $pass))->fetchField();
    if($node_title<1){
        $response = array(
            'status' => 'fail',
            'message' => '登录失败'
        );
    }
    drupal_json_output($response);
    return;
}
function lightyear_upload_photo(){
    header('Access-Control-Max-Age: 3600');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");
    $response = array(
        'status' => 'success',
        'message' => '成功'
    );
    global $user;
    //获取uid的值
    $uid = $user->uid;
    //时间戳
    $timpstamp = time();
    //获取前台传递的值
    $data = $_POST;
    $title = $data['title'];
    $body = $data['body'];
    $node = NULL;
    if((int)$nid <= 0 || empty($node)) {
        $node = new stdClass();
        $node->title = $title;
        $node->type = "node_lightyear_photo";
        node_object_prepare($node);
        $node->language = LANGUAGE_NONE;
        $node->uid = $user->uid;
        $node->status = 1;
        $node->promote = 0;
        $node->comment = 0;
    }
    $node_wrapper = entity_metadata_wrapper('node', $node);
    foreach($data as $field => $d) {
        if($field == 'body') continue;
        if($field == 'title') continue;
        if($domain = strstr($field, 'file')) continue;
        $filed_name = 'field_lightyear_' . $field;
        $node_wrapper->$filed_name->set($d);
    }
   
    $node_wrapper->body->set(array('value' => $body));

    $namearr = $_FILES['myFile']['name'];
    $typearr = $_FILES['myFile']['type'];
    $tmpnamearr = $_FILES['myFile']['tmp_name'];
    $sizearr = $_FILES['myFile']['size'];
    $errorarr = $_FILES['myFile']['error'];
    $files = array();
    foreach ($namearr as $key => $value) {
        if(!empty($namearr)){
            $upload_file = array(
                'name' =>  $value,
                'type' => $typearr[$key],
                'tmp_name' => $tmpnamearr[$key],
                'error' => $errorarr[$key],
                'size' => $sizearr[$key]
              );
            $path_uri = 'private://lightyear/photos';
            $new_file = jiapu_save_upload_file($upload_file, $path_uri);
            $files[] = (array)$new_file;
        }
    }
    $node_wrapper->field_lightyear_photo->set($files);
    $node_wrapper->save();

    echo json_encode($response);
    return;
}

function lightyear_edit_photo($node){
    header('Access-Control-Max-Age: 3600');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");
    $response = array(
        'status' => 'success',
        'message' => '成功'
    );
    global $user;
    //获取uid的值
    $uid = $user->uid;
    //时间戳
    $timpstamp = time();
    //获取前台传递的值
    $data = $_POST;
    $title = $data['title'];
    $body = $data['body'];
    $imgnames = $data['imgnames'];
    $node_wrapper = entity_metadata_wrapper('node', $node);
   
    foreach($data as $field => $d) {
        if($field == 'body' || $field == 'title'|| $field == 'imgnames') continue;
        if($domain = strstr($field, 'file')) continue;
        $filed_name = 'field_lightyear_' . $field;
        $node_wrapper->$filed_name->set($d);
    }
    $node_wrapper->title->set($title);
    $node_wrapper->body->set(array('value' => $body));

    $namearr = $_FILES['myFile']['name'];
    $typearr = $_FILES['myFile']['type'];
    $tmpnamearr = $_FILES['myFile']['tmp_name'];
    $sizearr = $_FILES['myFile']['size'];
    $errorarr = $_FILES['myFile']['error'];
    $files = array();

        //只有旧图
    if(!empty($imgnames)&&empty($namearr)){
        $old_pic = $node_wrapper->field_lightyear_photo->value();
        $arrlength = count( $old_pic);
        $picnames = '';
        for ($i=0; $i < $arrlength; $i++) { 
            $picnames= $old_pic[$i]["filename"];
            if(!strstr($imgnames, $picnames)){
                $old_file = file_load($old_pic[$i]["fid"]);
                if($old_file){
                    // 删除当前节点对文件的引用
                    file_usage_delete($old_file, 'file', 'node', $node->nid);
                    // 尝试删除文件
                    file_delete($old_file);
                }
            }
        }   
    }elseif(!empty($imgnames)&&!empty($namearr)){
        //新旧同时存在
        $old_pic = $node_wrapper->field_lightyear_photo->value();
        $arrlength = count( $old_pic);
        $picnames = '';
        for ($i=0; $i < $arrlength; $i++) { 
            $picnames= $old_pic[$i]["filename"];
                //不符合条件的旧文件删除
            if(!strstr($imgnames, $picnames)){
                $old_file = file_load($old_pic[$i]["fid"]);
                if($old_file){
                    // 删除当前节点对文件的引用
                    file_usage_delete($old_file, 'file', 'node', $node->nid);
                    // 尝试删除文件
                    file_delete($old_file);
                }
            }else{//余下的旧文件,先取到值,再保存到files[],
                $old_imgarr = file_load($old_pic[$i]["fid"]);
                $retain_img = array(
                    'name' =>  $old_imgarr->filename,
                    'type' =>  $old_imgarr->filemime,
                    'tmp_name' => $old_imgarr->uri,
                    'error' => 0,
                    'size' => $old_imgarr->filesize
                );
                $oldimguri = 'oldimg';
                file_usage_delete($old_imgarr, 'file', 'node', $node->nid);
                file_delete($old_imgarr);
                $old_img = jiapu_save_upload_file($retain_img, $oldimguri);
                $files[] = (array)$old_img; 
            }
        }
        foreach ($namearr as $key => $value) {
            $upload_file = array(
                'name' =>  $value,
                'type' => $typearr[$key],
                'tmp_name' => $tmpnamearr[$key],
                'error' => $errorarr[$key],
                'size' => $sizearr[$key]
            );
            $path_uri = 'private://lightyear/photos';
            $new_file = jiapu_save_upload_file($upload_file, $path_uri);
            $files[] = (array)$new_file; 
        }
        $node_wrapper->field_lightyear_photo->set($files);

    }else{
        //只有新图
        if(!empty($namearr)){
            foreach ($namearr as $key => $value) {
                // $old_pic = $node_wrapper->field_lightyear_photo->value();
                // $arrlength = count( $old_pic);
                // $picarr = array();
                // for ($i=0; $i < $arrlength; $i++) { 
                //     array_push($picarr,$old_pic[$i]["fid"]);
                // }
                // if( !$arrlength<=0) {
                //     $old_file = file_load($picarr[$key]);
                //     if($old_file){
                //         // 删除当前节点对文件的引用
                //         file_usage_delete($old_file, 'file', 'node', $node->nid);
                //         // 尝试删除文件
                //         file_delete($old_file);
                //     }
                // }
                $upload_file = array(
                    'name' =>  $value,
                    'type' => $typearr[$key],
                    'tmp_name' => $tmpnamearr[$key],
                    'error' => $errorarr[$key],
                    'size' => $sizearr[$key]
                );
                $path_uri = 'private://lightyear/photos';
                $new_file = jiapu_save_upload_file($upload_file, $path_uri);
                $files[] = (array)$new_file;
            }
        }
        $node_wrapper->field_lightyear_photo->set($files);
    }
    
    $node_wrapper->save();

    echo json_encode($response);
    return;
}


function jiapu_save_upload_file($file_element, $path_uri) {
    global $user;
    // 保存文件
    if($path_uri!='oldimg'){
        file_prepare_directory($path_uri, FILE_CREATE_DIRECTORY | FILE_MODIFY_PERMISSIONS);//如果文件夹不存在则创建
        $path = drupal_realpath($path_uri);
        if (!is_dir($path)) {
          mkdir($path, 0, true);
        }
        $dest_file_name = date('Ymd') .'_'. $file_element['name'];
        move_uploaded_file($file_element['tmp_name'], $path . '/' . $dest_file_name);
    }

  
    $file = new stdClass();
    $file->uid = $user->uid;
    $file->filename = $file_element['name'];
    if($path_uri!='oldimg'){
        $file->uri = $path_uri . '/' . $dest_file_name;
    }else{
        $file->uri = $file_element['tmp_name'];
    }
    $file->filemime = $file_element['type'];
    $file->filesize = $file_element['size'];
    $file->status = 1;
    $file->display = 1;
    file_save($file);
  
    return $file;
  }

  function lightyear_delete_photo() {
    $response = array(
      'status' => 'success',
      'message' => '删除内容成功！'
    );
    if(!isset($_POST['nid'])) {
        $response['status'] = 'error';
        $response['message'] = '参数错误。';
      }
    if($response['status'] == 'success') {
      $nids = $_POST['nid'];
      node_delete($nids);
    }
  
    drupal_json_output($response);
  }