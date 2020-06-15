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

function lightyear_edit_photo(){
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


function jiapu_save_upload_file($file_element, $path_uri) {
    global $user;
    // 保存文件
    file_prepare_directory($path_uri, FILE_CREATE_DIRECTORY | FILE_MODIFY_PERMISSIONS);//如果文件夹不存在则创建
    $path = drupal_realpath($path_uri);
    if (!is_dir($path)) {
      mkdir($path, 0, true);
    }
    $dest_file_name = date('Ymd') .'_'. $file_element['name'];
    // move_uploaded_file($file_element['tmp_name'], $path . '/' . $dest_file_name);
  
    $file = new stdClass();
    $file->uid = $user->uid;
    $file->filename = $file_element['name'];
    $file->uri = $path_uri . '/' . $dest_file_name;
    $file->filemime = $file_element['type'];
    $file->filesize = $file_element['size'];
    $file->status = 1;
    $file->display = 1;
    file_save($file);
  
    return $file;
  }