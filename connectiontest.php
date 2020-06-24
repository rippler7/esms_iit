<?php
session_start();
include("./classes/caller.php");
$appcall = new Caller($config);
echo $_SESSION['appman'];
$appman = $_SESSION['appman'];
$token = $_SESSION['token'];
echo "<br />";
//------------------------------------------
echo"token: ".$_SESSION['token']."<br />";
echo get_timestamp();
echo"<br />";
//------------------------------------------
echo "<h3>get_sem</h3>";
echo "<hr />";
echo "<br />";
$sem = array(
    'class'=>'webesms',
    'action'=>'get_sem',
    'token'=>$_SESSION['token'],
    'timestamp'=>get_timestamp(),
    'user'=>$_SESSION['appman'],
    );
$sem1 = $appcall->apiCall($sem);
$semester = json_decode($sem1)->data;
var_dump($sem1);
var_dump($semester);
foreach($semester as $k => $v){
    echo $v->sy.", ".$v->sem.", ".$v->iscurrent."<br />";
}
//var_dump($semester->sy);
//------------------------------------------
echo "<br />";
echo "<h3>get_semstudentinfo</h3>";
echo "<hr />";
$req2 = array(
    'class'=>'webesms',
    'action'=>'get_semstudentinfo',
    'token'=>$_SESSION['token'],
    'timestamp'=>get_timestamp(),
    'sy'=>'2014-2015',
    'sem'=>1,
    'studid'=>'2012-0036',
    'user'=>$_SESSION['appman']
);
$stud_info = $appcall->apiCall($req2);
$stud_info = json_decode($stud_info);
$studinfo = $stud_info->data;
foreach($studinfo as $key => $value){
    echo $key.": ".$value."<br />";
}
echo "<br />";
var_dump($studinfo);
echo "<br />";
//------------------------------------------
echo "<br />";
echo "<br />";
echo "<h3>get_semstudent_otherinfo</h3>";
echo "<hr />";
$req3 = array(
    'class'=>'webesms',
    'action'=>'get_semstudent_otherinfo',
    'token'=>$_SESSION['token'],
    'timestamp'=>get_timestamp(),
    'studid'=>'2012-0036',
    'user'=>$_SESSION['appman']
);
$stud_otherinfo = $appcall->apiCall($req3);
$stud_otherinfo = json_decode($stud_otherinfo);
$studoinfo = $stud_otherinfo->data;
foreach($studoinfo as $key => $value){
    echo $key.": ".$value."<br />";
}
echo "<br />";
var_dump($studoinfo);
echo "<br />";
echo "<hr />";
echo "<br />";
//------------------------------------------
echo "<br />";
echo "<br />";
echo "<h3>get_semstudent_subjects</h3>";
echo "<hr />";

$req1 = array(
    'class'=>'webesms',
    'action'=>'get_semstudent_subjects',
    'token'=>$_SESSION['token'],
    'timestamp'=>get_timestamp(),
    'sy'=>'2014-2015',
    'sem'=>1,
    'studid'=>'2012-0036',
    'user'=>$_SESSION['appman']
);
$get_studsubj = $appcall->apiCall($req1);
$studsubj = json_decode($get_studsubj);
$subjects = $studsubj->data;
echo "<table><tbody>";
foreach($subjects as $key => $value){
    echo "<tr>";
    foreach($value as $k => $v){
        echo "<td>".$v."</td>";
    }
    echo "</tr><br/>";
}
echo "</tbody></table>";
echo "<br />";
var_dump($subjects);
echo "<br />";
echo "<hr />";
echo "<br />";
//------------------------------------------
echo "<br />";
//------------------------------------------
echo "<br />";
echo "<br />";
echo "<h3>get_offeredprograms</h3>";
echo "<hr />";
$maj = array(
    'class'=>'webesms',
    'action'=>'get_offeredprograms',
    'token'=>$_SESSION['token'],
    'timestamp'=>get_timestamp(),
    'user'=>$_SESSION['appman'],
    'progcode'=>'met'
);
$get_progoff = $appcall->apiCall($maj);
$progoff = json_decode($get_progoff);
$prog = $progoff->data;
foreach($prog as $key => $value){
    echo "progcode: ".$prog[$key]->progcode." :: progdesc: ".$prog[$key]->progdesc."<br />";
}
echo "<br />";
var_dump($progoff);
echo "<br />";
echo "<hr />";
echo "<br />";
//-------------------------------------------
echo "<br /><br />";
echo "<h3>get_semsubject_offerings</h3>";
echo "<hr />";
$subj = array(
    'class' => 'webesms',
    'action' => 'get_semsubject_offerings',
    'token' => $_SESSION['token'],
    'timestamp' => get_timestamp(),
    'api_appcode' => 'webesms',
    'user' => $_SESSION['appman'],
    'sy' => '2014-2015', 
    'sem' => 1,
    'subjcode' => 'MKTG,a'
);
$get_subjoff = $appcall->apiCall($subj);
$subjoff = json_decode($get_subjoff);
$subj = $subjoff->data;
foreach($subj as $key => $value){
    echo "[subjcode] ".$subj[$key]->subjcode." :: [section] ".$subj[$key]->section."<br />";
}
echo "<br />";
var_dump($subjoff);
echo "<br /><hr /><br /><br />";
//-----------------------------------------------
echo "<br /><br />";
echo "<h3>find_student</h3>";
echo "<hr />";
$stude = array(
    'class'=>'webesms',
    'action'=>'find_student',
    'token'=>$_SESSION['token'],
    'timestamp'=>get_timestamp(),
    'user'=>$_SESSION['appman'],
    'stude'=>'2012-0068'
);
$studes = $appcall->apiCall($stude);
$studes = json_decode($studes);
$students = $studes->data;
foreach ($students as $key => $value){
    echo "[studid] = ".$students[$key]->studid.":: [studfullname] = ".$students[$key]->studfullname."<br />";
}
var_dump($studes);
echo "<br /><hr /><br /><br />";
//-----------------------------------------------
echo "<br /><br />";
echo "<h3>get_relcat</h3>";
echo "<hr />";
$relcat = array(
    'class'=>'webesms',
    'action'=>'get_relcat',
    'token'=>$_SESSION['token'],
    'timestamp'=>get_timestamp(),
    'user'=>$_SESSION['appman']
);
$rel = $appcall->apiCall($relcat);
$relig = json_decode($rel);
var_dump($relig);
$religion = $relig->data;
echo "<br />";
foreach($religion as $key => $value){
    echo $religion[$key]->id." :: ".$religion[$key]->catname."<br />";
}
echo "<br /><hr /><br /><br />";
//-----------------------------------------------
echo "<br /><br />";
echo "<h3>get_denom</h3>";
echo "<hr />";
$denom = array(
    'class'=>'webesms',
    'action'=>'get_denom',
    'token'=>$_SESSION['token'],
    'timestamp'=>get_timestamp(),
    'user'=>$_SESSION['appman'],
    'relcat'=>1
);
$den = $appcall->apiCall($denom);
$denomin = json_decode($den);
$denomination = $denomin->data->data;
var_dump($denomination);
echo "<br />";
foreach($denomination as $key => $value){
    echo $denomination[$key]->id." :: ".$denomination[$key]->relname."<br />";
}
echo "<br /><hr /><br /><br />";
//-----------------------------------------------
echo "<br /><br />";
echo "<h3>get_provinces</h3>";
echo "<hr />";
$prov = array(
    'class'=>'webesms',
    'action'=>'get_provinces',
    'token'=>$_SESSION['token'],
    'timestamp'=>get_timestamp(),
    'user'=>$_SESSION['appman']
);
$pr = $appcall->apiCall($prov);
$provi = json_decode($pr);
$province = $provi->data->data;
var_dump($province);
echo "<br />";
foreach($province as $key => $value){
    echo $province[$key]->province_id." :: ".$province[$key]->province_name."<br />";
}
echo "<br /><hr /><br /><br />";
//-----------------------------------------------
echo "<br /><br />";
echo "<h3>get_towncity</h3>";
echo "<hr />";
$tc = array(
    'class'=>'webesms',
    'action'=>'get_towncity',
    'token'=>$_SESSION['token'],
    'timestamp'=>get_timestamp(),
    'user'=>$_SESSION['appman'],
    'province'=>49
);
$toci = $appcall->apiCall($tc);
$towcit = json_decode($toci);
$towncity = $towcit->data->data;
var_dump($towncity);
echo "<br />";
foreach($towncity as $key => $value){
    echo $towncity[$key]->towncity_id." :: ".$towncity[$key]->towncity_name."<br />";
}
echo "<br /><hr /><br /><br />";
//-----------------------------------------------
echo "<br /><br />";
echo "<h3>save_semstudent</h3>";
echo "<hr />";
        $save1 = array(
            'class' => 'webesms',
            'action' => 'save_semstudent',
            'token' => $_SESSION['token'],
            'timestamp' => get_timestamp(),
            'api_appcode' => 'webesms',
            'user' => $_SESSION['appman'],
            'sy' => '2013-2014',
            'sem' => $_POST['sem'],
            'studid' => $_POST['studid'],
            'progcode' => $_POST['progcode'],
            'level' => $_POST['level']
        );
        $save2 = array(
            'class' => 'webesms',
            'action' => 'save_semstudent',
            'token' => $_SESSION['token'],
            'timestamp' => get_timestamp(),
            'api_appcode' => 'webesms',
            'user' => $_SESSION['appman'],
            'studid' => $_POST['studid'],
            'street' => $_POST['street'],
            'towncity' => $_POST['towncity'],
            'province' => $_POST['province'],
            'relcat' => $_POST['relcat'],
            'reldenom' => $_POST['reldenom'],
            'relother' => $_POST['relother'],
            'income' => $_POST['inc']
        );
        $savestude = $appcall->apiCall($save1);
        $saveother = $appcall->apiCall($save2);
    $savestude = $appcall->apiCall($save1);
    $ss = json_decode($savestude);
    var_dump($savestude);
//-----------------------------------------------
echo "<br /><br />";
echo "<h3>getaddsubject</h3>";
echo "<hr />";
$add = array(
            'class' => 'webesms',
            'action' => 'add_semstudent_subject',
            'token' => $_SESSION['token'],
            'timestamp' => get_timestamp(),
            'api_appcode' => 'webesms',
            'user' => $_SESSION['appman'],
            'sy' => '2013-2014',
            'sem' => 'S',
            'studid' => '1999-1787',
            'subjcode' => 'CWTS-1',
            'section' => 'AAA'
        );
$conf = $appcall->apiCall($add);
$as = json_decode($conf);
$adds = $as;
var_dump($conf);
echo "<br />";
echo "<br /><hr /><br /><br />";
//-----------------------------------------------
$tc = array(
    'class'=>'webesms',
    'action'=>'get_alltowncities',
    'token'=>$_SESSION['token'],
    'timestamp'=>get_timestamp(),
    'user'=>$_SESSION['appman']
);
$toci = $appcall->apiCall($tc);
$alltc = json_decode($toci)->data->data;
//$t = $alltc;
$arr1 = array();
$conf = is_array($alltc);
$counter = 0;
foreach($alltc as $key => $value){
    if($value->province_id == 41){
        $arr1[$counter]['tc_id'] = $value->towncity_id;
        $arr1[$counter]['tc_name'] = $value->towncity_name;
        $counter++;
    }
}  
var_dump($arr1); 

?>