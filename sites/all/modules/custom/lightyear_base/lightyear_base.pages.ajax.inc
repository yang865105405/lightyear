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

    global $user;



    $response = array(
        'status' => 'fail',
        'message' => '失败'
    );


    foreach ($_FILES as $key => $value) {
        if($key=='file'){
            continue;
        }

        $upFile = $_FILES[$key];
        date_default_timezone_set('prc');
        $data=date('yymdhis',time());
        if($upFile['error']==0 && !empty($upFile)) {
            // $dirpath = creaDir('upload');
            //自定义的upload要创建好
            $dirpath = 'upload';
            $filename =$data .'_'.$_FILES[$key]['name'];
    
            $theme_path = drupal_get_path('theme', 'lightyear');
    
            $queryPath = $theme_path.'/'.$dirpath.'/'.$filename;
    
            if(move_uploaded_file($_FILES[$key]['tmp_name'],$queryPath)){
                $response = array(
                    'status' => 'success',
                    'message' => '上传成功'
                );
            }
        }
    }
    // function creaDir($dirPath){
    //  $curPath = dirname(__FILE__);
    //  $path = $curPath.'\\'.$dirPath;
    //  if (is_dir($path) || mkdir($path,0777,true)) {
    //   return $dirPath;
    //  }
    // }

    drupal_json_output($response);
    return;
}