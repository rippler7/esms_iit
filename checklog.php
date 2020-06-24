<?php
ob_start();
session_start();
include("./classes/caller.php");
$debug = 0;
$appcall = new Caller($config);
$result = 0;
$curl_result = '';
if($debug){
    $checklog = array(
        'class'=>'webesms',
        'action'=>'checkLog',
        'token'=>'3c3c52d76a462520268e3cb5cae85d1a',
        'timestamp'=>get_timestamp(),
        'api_appcode'=>'webesms',
        'user'=>'jeremy.ancog'            
    );

    $isLogged = $appcall->apiCall($checklog);
    #var_dump($isLogged);
    $isLogged = $appcall->apiCall($checklog);
    $isLogged = @json_decode($isLogged);

} else {
    if(isset($_POST['checklog'])){
        $checklog = array(
            'class'=>'webesms',
            'action'=>'checkLog',
            'timestamp'=>get_timestamp(),
            'token'=>$_SESSION['token'],
            'api_appcode'=>'webesms',
            'user'=>'jeremy.ancog'
        );
        $isLogged = $appcall->apiCall($checklog);
        $isLogged = @json_decode($isLogged);
        $result = $isLogged->data->logged;
    }
}
echo '{"logged":"'.$result.'"}';
?>