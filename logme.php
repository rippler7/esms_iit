<?php
ob_start();
session_start();
include("./classes/caller.php");
$appcall = new Caller($config);
$debug = 0;
$pos = "";
if($debug){
    $_POST['sbmtlogin'] = 'sbmtlogin';
    $_POST['username'] = 'jeremy.ancog';
    $_POST['password'] = 'waterspout1';
} 
if(isset($_POST['sbmtlogin'])){
    $result = 0;
    $mcode = 0;
    $info = array(
        'class'=>'authentication',
        'action'=>'login',
        'username'=>$_POST['username'],
        'password'=>$_POST['password'],
        'timestamp'=>get_timestamp()
    );
    $logres = $appcall->apiCall($info);
    $logres = @json_decode($logres);
    if($debug){var_dump($logres->data);}
    $registered = 0;
    if(isset($logres->data->token)){
        $token = $logres->data->token;
        if(isset($_POST['username'])){
            $appman = $_POST['username'];
        } else {
            $appman = '';
        }
        if(isset($logres->data->access[0]->emp_id)){
            $empid = $logres->data->access[0]->emp_id;
        } else {
            $empid = '';
        }        
        $_SESSION['token'] = $token;
        $_SESSION['appman'] = $appman;
        $_SESSION['empid'] = $empid;
        $mcode = 2;
        //$token = $logres->data->access[0]->userid;
        //print_r("<br />".$token."<br />");
        foreach ($logres->data->access as $key => $value) {
            $word = strtolower(trim($value->module_id));
            if(($word == 'esms-admin') || ($word == 'esms-controller')){
                $registered++;
            }   
            $pos = $word; 
            $_SESSION['pos'] = $pos;
        }
        if($registered > 0){
            $result = 1;
            $mcode = 1;
        }
    }
echo '{"logged":"'.$result.'","appman":"'.$appman.'","empid":"'.$empid.'","esms-count":"'.$registered.'","mcode":"'.$mcode.'","pos":"'.$pos.'"}';
    /*
            $logres = @json_decode($logres);
            if($debug){var_dump($logres);}
            if(isset($logres->data->token)){
                $apptoken = $logres->data->token;
                $appman = $_POST['username'];
                $empid = $logres->data->access[0]->emp_id;
                $_SESSION['token'] = $apptoken;
                $_SESSION['appman'] = $appman;
                $_SESSION['empid'] = $empid;
                while(ob_get_status()){
                    ob_end_clean();
                }
                $getuaccess = array(
                    'class'=>'applications',
                    'appid'=>3, //THIS IS THE APP ID FOR THE WEB-ESMS
                    'empid'=>$empid,
                    'uid'=>$appman,
                    'action'=>'get_useraccess',
                    'timestamp'=>get_timestamp(),
                    'token'=>$apptoken
                );
                $ua = $appcall->apiCall($getuaccess);
                $ua1 = @json_decode($ua);
                $apps = $ua->data;
                if($debug){print("<br />uaccess: ".$apps);}
                $count_esms = 0;
                $mcode = 2;
                foreach($apps as $k => $v){
                    if(((str_replace(' ','',$v->module_id)) == 'esms-admin') ||((str_replace(' ','',$v->module_id)) == 'esms-controller')){
                        $count_esms++;
                    }
                }
                if($count_esms > 0){
                    while(ob_get_status()){
                        ob_end_clean();
                    }
                    $result = 1;
                    $mcode = 1;
                } 
            } else {
                $result = 0;
            }
    echo '{"logged":"'.$result.'","appman":"'.$appman.'","empid":"'.$empid.'","esms-count":"'.$count_esms.'","mcode":"'.$mcode.'"}';
    */
}
?>