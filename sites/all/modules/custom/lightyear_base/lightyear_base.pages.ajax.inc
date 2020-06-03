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
