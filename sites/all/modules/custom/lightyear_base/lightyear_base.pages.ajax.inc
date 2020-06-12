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
    $valuenid = $node_wrapper->save();

    $namearr = $_FILES['myFile']['name'];
    $typearr = $_FILES['myFile']['type'];
    $tmpnamearr = $_FILES['myFile']['tmp_name'];
    $sizearr = $_FILES['myFile']['size'];
    $errorarr = $_FILES['myFile']['error'];
    
    foreach ($namearr as $key => $value) {
        $filename = $value;
        $type = $_FILES['myFile']['type'];
        $tmpname = $tmpnamearr[$key];
        $error = $errorarr[$key];
        $upFile = $_FILES['myFile'];

        date_default_timezone_set('prc');
        $date=date('yymd',time());
        if($error==0 && !empty($upFile)) {
            $dirpath = 'upload';
            $newfilename =$date .'_'.$filename;
    
            $theme_path = drupal_get_path('theme', 'lightyear');
    
            $queryPath = $theme_path.'/'.$dirpath.'/'.$newfilename;
            $xinxix = db_insert("file_managed")->fields(array('uid' => $uid,'filename' => $newfilename, 'uri' =>'http://192.168.0.213/upload/'. $newfilename,
            'filemime' =>  $type[$key], 'filesize' => 0, 'status' => 1, 'timestamp' => $timpstamp))->execute();
            // if(move_uploaded_file($tmpname,$queryPath)){
            //     $response = array(
            //         'status' => 'success',
            //         'message' => '上传成功'
            //     );
            // }
        }
    }
    // function creaDir($dirPath){
    //  $curPath = dirname(__FILE__);
    //  $path = $curPath.'\\'.$dirPath;
    //  if (is_dir($path) || mkdir($path,0777,true)) {
    //   return $dirPath;
    //  }
    // }

    echo json_encode($response);
    return;
}