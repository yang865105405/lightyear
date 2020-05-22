<?php
function lightyear_user_log() {
    global $user;
    $response = array(
        'status' => 'success',
        'message' => '登录成功'
    );

    $name = $_REQUEST['username'];
    $pass = $_REQUEST['password'];
    $result = db_query("SELECT * FROM users WHERE name = $name and pass=$pass")->fetchField();
    // $select = db_select('users', 'user');
    // if(isset($_REQUEST['username'])&&$_REQUEST['password']!="") {
    //     $select->condition('user.name', "{$_REQUEST['username']}");
    //     $select->condition('user.pass', "{$_REQUEST['password']}");
    //   }
    // $rowCount = $select->execute()->rowCount();  

    drupal_json_output($response);
    return;
}
