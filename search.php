<?php
session_start();
include("./classes/caller.php");
$appcall = new Caller($config);
$debug = 0;
if($debug){
    $_POST['action'] = 'studesearch';
    $_POST['stude'] = '2014-0000';
}
switch($_POST['action']){
    case "studesearch":
        //echo $_POST['stude'];
        //$search = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['stude']);
        //$search_string = mysql_real_escape_string($search);
        $stude = array(
            'class'=>'webesms',
            'action'=>'find_student',
            'token'=>$_SESSION['token'],
            'timestamp'=>get_timestamp(),
            'user'=>$_SESSION['appman'],
            'stude'=>$_POST['stude'],
            'limit'=>$_POST['limit']
        );
        $studes = $appcall->apiCall($stude);
        echo $studes;
        if($debug){var_dump($studes);}
        break;
    case "getSem":
        $sem = array(
            'class'=>'webesms',
            'action'=>'get_sem',
            'token'=>$_SESSION['token'],
            'timestamp'=>get_timestamp(),
            'user'=>$_SESSION['appman'],
            );
        $sem1 = $appcall->apiCall($sem);
        //$sem1 = 1;
        echo $sem1;
        break;
    case "get_studentinfo":
        $req2 = array(
            'class'=>'webesms',
            'action'=>'get_semstudentinfo',
            'token'=>$_SESSION['token'],
            'timestamp'=>get_timestamp(),
            'sy'=>$_POST['sy'],
            'sem'=>$_POST['sem'],
            'studid'=>$_POST['studid'],
            'user'=>$_SESSION['appman']
        );
        $stud_info = $appcall->apiCall($req2);
        echo $stud_info;
        break;
    case "get_studentoinfo":
        $req3 = array(
            'class'=>'webesms',
            'action'=>'get_semstudent_otherinfo',
            'token'=>$_SESSION['token'],
            'timestamp'=>get_timestamp(),
            'studid'=>$_POST['studid'],
            'user'=>$_SESSION['appman']
        );
        $stud_otherinfo = $appcall->apiCall($req3);
        echo $stud_otherinfo;
        break;
    case "get_rel":
        $relcat = array(
            'class'=>'webesms',
            'action'=>'get_relcat',
            'token'=>$_SESSION['token'],
            'timestamp'=>get_timestamp(),
            'user'=>$_SESSION['appman']
        );
        $rel = $appcall->apiCall($relcat);
        echo $rel;
        break;
    case "get_denom":
        $denom = array(
            'class'=>'webesms',
            'action'=>'get_denom',
            'token'=>$_SESSION['token'],
            'timestamp'=>get_timestamp(),
            'user'=>$_SESSION['appman'],
            'relcat'=>$_POST['relcat']
        );
        $den = $appcall->apiCall($denom);
        echo $den;
        break;
    case "get_prov":
        $prov = array(
            'class'=>'webesms',
            'action'=>'get_provinces',
            'token'=>$_SESSION['token'],
            'timestamp'=>get_timestamp(),
            'user'=>$_SESSION['appman']
        );
        $pr = $appcall->apiCall($prov);
        echo $pr;
        break;
    case "get_towncity":
        $tc = array(
            'class'=>'webesms',
            'action'=>'get_towncity',
            'token'=>$_SESSION['token'],
            'timestamp'=>get_timestamp(),
            'user'=>$_SESSION['appman'],
            'province'=>$_POST['province']
        );
        $toci = $appcall->apiCall($tc);
        echo $toci;
        break;
    case "get_studsubjects":
        $req1 = array(
            'class'=>'webesms',
            'action'=>'get_semstudent_subjects',
            'token'=>$_SESSION['token'],
            'timestamp'=>get_timestamp(),
            'sy'=>$_POST['sy'],
            'sem'=>$_POST['sem'],
            'studid'=>$_POST['studid'],
            'user'=>$_SESSION['appman']
        );
        $get_studsubj = $appcall->apiCall($req1);
        echo $get_studsubj;
        break;
    case "get_maj":
        $maj = array(
            'class'=>'webesms',
            'action'=>'get_offeredprograms',
            'token'=>$_SESSION['token'],
            'timestamp'=>get_timestamp(),
            'user'=>$_SESSION['appman'],
            'progcode'=>$_POST['program']
        );
        $get_progoff = $appcall->apiCall($maj);
        echo $get_progoff;
        break;
    case "get_subjects":
        $subj = array(
            'class' => 'webesms',
            'action' => 'get_semsubject_offerings',
            'token' => $_SESSION['token'],
            'timestamp' => get_timestamp(),
            'api_appcode' => 'webesms',
            'user' => $_SESSION['appman'],
            'sy' => $_POST['sy'], 
            'sem' => $_POST['sem'],
            'subjcode' => $_POST['subj']
        );
        $get_subjoff = $appcall->apiCall($subj);
        echo $get_subjoff;
        break;
    case "add_subj":
        $add = array(
            'class' => 'webesms',
            'action' => 'add_semstudent_subject',
            'token' => $_SESSION['token'],
            'timestamp' => get_timestamp(),
            'api_appcode' => 'webesms',
            'user' => $_SESSION['appman'],
            'sy' => $_POST['sy'],
            'sem' => $_POST['sem'],
            'subjcode' => $_POST['subjcode'],
            'section' => $_POST['section'],
            'studid' => $_POST['studid']
        );
        $conf = $appcall->apiCall($add);
        echo $conf;
        break;
    case "remove_subj":
        $remove = array(
            'class' => 'webesms',
            'action' => 'remove_semstudent_subject',
            'token' => $_SESSION['token'],
            'timestamp' => get_timestamp(),
            'api_appcode' => 'webesms',
            'user' => $_SESSION['appman'],
            'sy' => $_POST['sy'],
            'sem' => $_POST['sem'],
            'subjcode' => $_POST['subjcode'],
            'section' => $_POST['section'],
            'studid' => $_POST['studid']
        );
        $confirm = $appcall->apiCall($remove);
        echo $confirm;
        break;
    case "save_studinfo":
        if(isset($_POST['street'])){
            $street = $_POST['street'];
        } else {
            $street = '';
        }
        if(isset($_POST['brgy'])){
            $brgy = $_POST['brgy'];
        } else {
            $brgy = '';
        }
        $save1 = array(
            'class' => 'webesms',
            'action' => 'save_semstudent',
            'token' => $_SESSION['token'],
            'timestamp' => get_timestamp(),
            'api_appcode' => 'webesms',
            'user' => $_SESSION['appman'],
            'sy' => $_POST['sy'],
            'sem' => $_POST['sem'],
            'studid' => $_POST['studid'],
            'progcode' => trim($_POST['progcode']),
            'level' => $_POST['level']
        );
        $save2 = array(
            'class' => 'webesms',
            'action' => 'save_semstudent_otherinfo',
            'token' => $_SESSION['token'],
            'timestamp' => get_timestamp(),
            'api_appcode' => 'webesms',
            'user' => $_SESSION['appman'],
            'sy' => $_POST['sy'],
            'sem' => $_POST['sem'],
            'studid' => $_POST['studid'],
            'street' => $street,
            'brgy' => $brgy,
            'towncity' => $_POST['towncity'],
            'province' => $_POST['province'],
            'relcat' => $_POST['relcat'],
            'reldenom' => $_POST['reldenom'],
            'relother' => $_POST['relother'],
            'income' => $_POST['inc']
        );
        //var_dump($save1);
        $savestude = $appcall->apiCall($save1);
        $saveother = $appcall->apiCall($save2);        
        $savestude1 = json_decode($savestude);
        $saveother2 = json_decode($saveother);
        $savestude1_fb = '';
        $savestude2_fb = '';
        if(isset($savestude1->data->data->save_semstudentinfo)){
            $savestude1_fb = $savestude1->data->data->save_semstudentinfo;
        }
        if(isset($saveother2->data->data->save_semstudent_otherinfo)){
            $savestude2_fb = $saveother2->data->data->save_semstudent_otherinfo;
        } 
        //var_dump($savestude);
        echo '{"main":"'.$savestude1_fb.'","other":"'.$savestude2_fb.'"}';
        break;
    case "scholstatus":
        $schol = array(            
            'token' => $_SESSION['token'],
            'timestamp' => get_timestamp(),
            'action' =>'update_scholastic_status',
            'user' => $_SESSION['appman'],
            'class' => 'webesms',
            'api_appcode' => 'webesms',
            'sy' => $_POST['sy'],
            'sem' => $_POST['sem'],
            'studid' => $_POST['studid'],
            'status' => $_POST['status']
        );
        $scholsave = $appcall->apiCall($schol);
        $schol = json_decode($scholsave);
        $update = $schol->data->data->update_scholastic_status;
        if(isset($schol->data->error)){
            $error = $schol->data->error;
        } else {
            $error = '';
        }
        $scholsaves = '{"data":{"update":"'.$update.'","error":"'.$error.'"}}';
        $scholsave1 = json_encode($scholsaves);
        echo $scholsaves;
        break;
    default:
        echo'{"default":"sample output"}';
        break;
}
?>

