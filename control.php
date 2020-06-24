<?php
session_start();
include("./classes/caller.php");
define('DEBUG', true);

if(DEBUG == true)
{
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}
else
{
    ini_set('display_errors', 'Off');
    error_reporting(0);
}
function arrayToObject($array) {
    if (!is_array($array)) {
        return $array;
    }
    
    $object = new stdClass();
    if (is_array($array) && count($array) > 0) {
        foreach ($array as $name=>$value) {
            $name = strtolower(trim($name));
            if (!empty($name)) {
                $object->$name = arrayToObject($value);
            }
        }
        return $object;
    }
    else {
        return FALSE;
    }
}
$appcall = new Caller($config);
$token = $_SESSION['token'];
$appman = $_SESSION['appman'];
if(isset($_POST['sem'])){
	$semester = $_POST['sem'];
}
if(isset($_POST['sy'])){
	$sy = $_POST['sy'];
}

	switch($_POST['action']){
		case 'setup':
			$prov = array(
	            'class'=>'webesms',
	            'action'=>'get_provinces',
	            'token'=>$token,
	            'timestamp'=>get_timestamp(),
	            'user'=>$appman
	        );
	        $pr = $appcall->apiCall($prov);
	        $provinces = json_encode(json_decode($pr)->data->data);
	        $provi=json_decode($pr);
	        $province = $provi->data->data;
            //$provincess = json_decode($pr)->data->data;
			$provincess = array();
			foreach($province as $key => $value){
			    //echo $province[$key]->province_id." :: ".$province[$key]->province_name."<br />";
			    $provincess[] = array($province[$key]->province_id, $province[$key]->province_name); 
			}
			$towncities = array();
			foreach ($provincess as $k => $v){
				if(is_array($v)){
			    	$towncities[] = $v[0];
				} else {
					$towncities = $v;
				}
			    $tc = array(
			        'class'=>'webesms',
			        'action'=>'get_towncity',
			        'token'=>$_SESSION['token'],
			        'timestamp'=>get_timestamp(),
			        'user'=>$_SESSION['appman'],
			        'province'=>$v[0]
			    );
			    $toci = $appcall->apiCall($tc);
			    $towcit = json_decode($toci)->data->data;
			    if(is_array($towcit)){
			        $towncities[$v[0]] = $towcit;
			    }
			}
			//var_dump($towncities);
			//var_dump($towncities[41]);
			$tcities = json_encode($towncities);	        
	        if(isset($_POST['province']) && ($_POST['province'] != '')){
	        	$province = $_POST['province'];
	        } else {
	        	$province = 0;
	        }
		    
			$sem = array(
	        	'class'=>'webesms',
	            'action'=>'get_sem',
	            'token'=>$token,
	            'timestamp'=>get_timestamp(),
	            'user'=>$appman,
	        );
        	$sem1 = $appcall->apiCall($sem);
        	$sem1 = json_decode($sem1);
        	//$semester = $sem1->data->sem;
        	//$semester = 1;
        	//$sy = $sem1->data->sy;
        	//$iscurrent = $sem1->data->iscurrent;
        	if($_POST['studid']){
        		$studid = trim($_POST['studid']);
				$req1 = array(
		            'class'=>'webesms',
		            'action'=>'get_semstudentinfo',
		            'token'=>$token,
		            'timestamp'=>get_timestamp(),
		            'sy'=>$sy,
		            'sem'=>$semester,
		            'studid'=>$studid,
		            'user'=>$appman
		        );
		        $stud_info = $appcall->apiCall($req1);
		        $studinfo = json_decode($stud_info);
		        $req2 = array(
		            'class'=>'webesms',
		            'action'=>'get_semstudent_otherinfo',
		            'token'=>$_SESSION['token'],
		            'timestamp'=>get_timestamp(),
		            'studid'=>$_POST['studid'],
		            'user'=>$appman
		        );
		        $stud_otherinfo = $appcall->apiCall($req2);
		        $stud_otherinfo = json_encode(json_decode($stud_otherinfo)->data);
		        $req3 = array(
		            'class'=>'webesms',
		            'action'=>'get_semstudent_subjects',
		            'token'=>$token,
		            'timestamp'=>get_timestamp(),
		            'sy'=>$sy,
		            'sem'=>$semester,
		            'studid'=>$studid,
		            'user'=>$appman
		        );
		        $get_studsubj = $appcall->apiCall($req3);
		        $getstudsubj = json_encode(json_decode($get_studsubj)->data); 
		        echo json_encode('{"stid":"'.$studid.'","sem":"'.$semester.'","sy":"'.$sy.'","studinfo":{"studfullname":"'.$studinfo->data->studfullname.'","studlevel":"'.$studinfo->data->studlevel.'","progcode":"'.str_replace(" ", "", $studinfo->data->progcode).'","progdesc":"'.$studinfo->data->progdesc.'","schcode":"'.str_replace(" ", "", $studinfo->data->schcode).'","schdesc":"'.$studinfo->data->schdesc.'","payment_scheme_year":"'.$studinfo->data->payment_scheme_year.'","scholasticstatus":"'.$studinfo->data->scholasticstatus.'","adviser":"'.$studinfo->data->adviser.'"},"studoinfo":'.$stud_otherinfo.',"studsubjects":'.$getstudsubj.',"provinces":'.$provinces.',"towncities":'.$tcities.'}');
        		//echo json_encode($studinfo); //October 9, 2014 --> null returned; solution, set active semester to 1
        	} else {
        		echo json_encode('{"stid":"'.$studid.'","sem":"'.$semester.'","sy":"'.$sy.'","provinces":'.$provinces.',"towncities":'.$tcities.'}');
        	}			
			
			break;
		case "get_maj":
	        $maj = array(
	            'class'=>'webesms',
	            'action'=>'get_offeredprograms',
	            'token'=>$token,
	            'timestamp'=>get_timestamp(),
	            'user'=>$appman,
	            'progcode'=>$_POST['program']
	        );
	        $get_progoff = $appcall->apiCall($maj);
	        echo $get_progoff;
	        break;
	    case "get_subjects":
	        $subj = array(
	            'class' => 'webesms',
	            'action' => 'get_semsubject_offerings',
	            'token' => $token,
	            'timestamp' => get_timestamp(),
	            'api_appcode' => 'webesms',
	            'user' => $appman,
	            'sy' => $_POST['sy'], 
	            'sem' => $_POST['sem'],
	            'subjcode' => $_POST['subj']
	        );
	        $get_subjoff = $appcall->apiCall($subj);
	        echo $get_subjoff;
	        break;
		case "studesearch":
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
	        $studes1 = json_encode(json_decode($studes)->data);
        echo $studes1;
	        break;
	    case "getStudent":
	    	if(isset($_POST['studid']) && $_POST['studid'] != ''){
	    		$studid = trim($_POST['studid']);
	    		$sem = $_POST['sem'];
	    		$sy = $_POST['sy'];
	    		$req1 = array(
		            'class'=>'webesms',
		            'action'=>'get_semstudentinfo',
		            'token'=>$token,
		            'timestamp'=>get_timestamp(),
		            'sy'=>$sy,
		            'sem'=>$sem,
		            'studid'=>$studid,
		            'user'=>$appman
		        );
		        $stud_info = $appcall->apiCall($req1);
		        $studinfo = json_decode($stud_info);
		        $req2 = array(
		            'class'=>'webesms',
		            'action'=>'get_semstudent_otherinfo',
		            'token'=>$token,
		            'timestamp'=>get_timestamp(),
		            'studid'=>$_POST['studid'],
		            'user'=>$appman
		        );
		        $stud_otherinfo = $appcall->apiCall($req2);
		        $stud_otherinfo = json_encode(json_decode($stud_otherinfo)->data);
		        $req3 = array(
		            'class'=>'webesms',
		            'action'=>'get_semstudent_subjects',
		            'token'=>$token,
		            'timestamp'=>get_timestamp(),
		            'sy'=>$sy,
		            'sem'=>$sem,
		            'studid'=>$studid,
		            'user'=>$appman
		        );
		        $get_studsubj = $appcall->apiCall($req3);
		        $getstudsubj = json_encode(json_decode($get_studsubj)->data);
		        echo json_encode('{"sem":"'.$sem.'","sy":"'.$sy.'","studinfo":{"studid":"'.$studinfo->data->studid.'","studfullname":"'.$studinfo->data->studfullname.'","studlevel":"'.$studinfo->data->studlevel.'","progcode":"'.str_replace(" ", "", $studinfo->data->progcode).'","progdesc":"'.$studinfo->data->progdesc.'","schcode":"'.str_replace(" ", "", $studinfo->data->schcode).'","schdesc":"'.$studinfo->data->schdesc.'","payment_scheme_year":"'.$studinfo->data->payment_scheme_year.'","scholasticstatus":"'.$studinfo->data->scholasticstatus.'","adviser":"'.$studinfo->data->adviser.'"},"studoinfo":'.$stud_otherinfo.',"studsubjects":'.$getstudsubj.'}');
	    	}else{
	    		echo json_encode('{"error":"no student number specified."}');
	    	}	    	
				
	    	break;
	    case "add_subj":
	    	$studid = trim($_POST['studid']);
	    	$sem = $_POST['sem'];
	    	$sy = $_POST['sy'];
	    	$add = array(
	            'class' => 'webesms',
	            'action' => 'add_semstudent_subject',
	            'token' => $token,
	            'timestamp' => get_timestamp(),
	            'api_appcode' => 'webesms',
	            'user' => $appman,
	            'sy' => $sy,
	            'sem' => $sem,
	            'subjcode' => $_POST['subjcode'],
	            'section' => $_POST['section'],
	            'studid' => $studid
	        );
	        $conf = $appcall->apiCall($add);
	        echo $conf;
	    	break;
	    case "remove_subj":
	    	$studid = trim($_POST['studid']);
	    	$sem = $_POST['sem'];
	    	$sy = $_POST['sy'];
	        $remove = array(
	            'class' => 'webesms',
	            'action' => 'remove_semstudent_subject',
	            'token' => $token,
	            'timestamp' => get_timestamp(),
	            'api_appcode' => 'webesms',
	            'user' => $appman,
	            'sy' => $sy,
	            'sem' => $sem,
	            'subjcode' => $_POST['subjcode'],
	            'section' => $_POST['section'],
	            'studid' => $studid
	        );
	        $confirm = $appcall->apiCall($remove);
	        echo $confirm;
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
	    case "save_studinfo":
	        if(isset($_POST['street'])){
	        	$street = $_POST['street'];
	        } else {
	        	$street = "";
	        }
	        if(isset($_POST['brgy'])){
	        	$brgy = $_POST['brgy'];
	        } else {
	        	$brgy = "";
	        }
	        $action = $_POST['action'];
	        $income = $_POST['inc'];
	        $level = $_POST['level'];
	        $progcode = trim($_POST['progcode']);
	        $province = $_POST['province'];
	        $relcat = $_POST['relcat'];
	        $reldenom = $_POST['reldenom'];
	        $relother = $_POST['relother'];
	        $sem = $_POST['sem'];
	        $sy = $_POST['sy'];
	        $studid = $_POST['studid'];
	        $tc = $_POST['towncity'];
	        $save1 = array(
	            'class' => 'webesms',
	            'action' => 'save_semstudent',
	            'token' => $token,
	            'timestamp' => get_timestamp(),
	            'api_appcode' => 'webesms',
	            'user' => $appman,
	            'sy' => $sy,
	            'sem' => $sem,
	            'studid' => $studid,
	            'progcode' => $progcode,
	            'level' => $level
	        );
	        $save2 = array(
	            'class' => 'webesms',
	            'action' => 'save_semstudent_otherinfo',
	            'token' => $token,
	            'timestamp' => get_timestamp(),
	            'api_appcode' => 'webesms',
	            'user' => $appman,
	            'sy' => $sy,
	            'sem' => $sem,
	            'studid' => $studid,
	            'street' => $street,
	            'brgy' => $brgy,
	            'towncity' => $tc,
	            'province' => $province,
	            'relcat' => $relcat,
	            'reldenom' => $reldenom,
	            'relother' => $relother,
	            'income' => $income
	        );
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
	        echo '{"main":"'.$savestude1_fb.'","other":"'.$savestude2_fb.'"}';
       		break;
		default:
			echo json_encode('{"test":"example"}');
	}
?>