<?php
ob_start();
session_start();
include("./classes/caller.php");
$appcall = new Caller($config);
$logout = array(
    'class' => 'authentication',
    'action' =>'logout',
    'username' => $_SESSION['appman'],
    'token' => $_SESSION['token'],
    'app_id' => $config['app_id'],
    'timestamp'=>get_timestamp()
    );
$logoutres = $appcall->apiCall($logout);
session_destroy();
while(ob_get_status()){
      ob_end_clean();
}
header('location:login.php');
?>