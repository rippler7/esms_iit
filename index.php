<?php
ob_start();
session_start();
include("./classes/caller.php");
$appcall = new Caller($config);
include("./header.php");
//$test = '{"test":"result","alternative":"secondary"}';
//-------------------------------------------------------
//-------GET ALL SEMESTERS-----------------------
$sem = array(
	    'class'=>'webesms',
	    'action'=>'get_sem',
	    'token'=>$token,
	    'timestamp'=>get_timestamp(),
	    'user'=>$appman,
	);
$sem1 = $appcall->apiCall($sem);
$semester = json_decode($sem1)->data;
//------------------------------------------------------
//------------------get provinces-----------------------
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
//------------------------------------------------------
//-----------------GET ALL TOWNCITIES-------------------
//(NOT DEPENDENT ON PROVINCE)
$tc = array(
    'class'=>'webesms',
    'action'=>'get_alltowncities',
    'token'=>$_SESSION['token'],
    'timestamp'=>get_timestamp(),
    'user'=>$_SESSION['appman']
);
$toci = $appcall->apiCall($tc);
$alltc = json_decode($toci)->data->data;
//-------------------------------------------------------
//----------------GET RELIGION CATEGORY------------------
$relcat = array(
    'class'=>'webesms',
    'action'=>'get_relcat',
    'token'=>$_SESSION['token'],
    'timestamp'=>get_timestamp(),
    'user'=>$_SESSION['appman']
);
$rel = $appcall->apiCall($relcat);
$relig = json_decode($rel);
$religion = $relig->data;
//-------------------------------------------------------
//-------------ALL GET RELIGION DENOMINATION-------------
$denoms = array();
foreach($religion as $key => $value){
	$denom = array(
	    'class'=>'webesms',
	    'action'=>'get_denom',
	    'token'=>$_SESSION['token'],
	    'timestamp'=>get_timestamp(),
	    'user'=>$_SESSION['appman'],
	    'relcat'=>$value->id
	);
	$den = $appcall->apiCall($denom);
	$denomin = json_decode($den);
	$denomination = $denomin->data->data;
	$denoms[] = array("cat_id"=>$value->id,"name"=> $value->catname,"denominations"=>array($denomination));
}
//-------------------------------------------------------
//----------------GET ALL OFFERRED PROGRAMS--------------
$maj = array(
	'class'=>'webesms',
	'action'=>'get_offeredprograms',
	'token'=>$token,
	'timestamp'=>get_timestamp(),
	'user'=>$appman,
	'progcode'=>''
);
$get_progoff = $appcall->apiCall($maj);
//-------------------------------------------------------
//----------------GET STUDENT INFO-----------------------
$sem = 1;
$sy = "2014-2015";
$studid = "not specified";
$validity = $studid;
if(isset($_GET['studid']) && $_GET['studid'] != ''){
	$idnum = explode('-',$_GET['studid']);
	if((strlen($idnum[0]) == 4) && (strlen($idnum[1]) == 4)){
		if((is_numeric($idnum[0])) && (is_numeric($idnum[1]))){
			$studid = $_GET['studid'];
			foreach($semester as $key => $value){
				if($value->iscurrent == 't'){
					$sem = $value->sem;
					$sy = $value->sy;
				}
			}
			$validity = $studid;
		} else {
			$validity = "not numeric";
		}
	} else {
		$validity = "invalid";
	}			
}
//-------------------------------------------------------
//----------------INSTANTIATE VARIABLES------------------
$studid = "";
$currsem = 1;
$curryear = "2014-2015";
if(isset($_GET['studid'])){
	$studid = $_GET['studid'];
	$sdata = '{"main":"","other":"","subjects":""}';
} 
if(!isset($_SESSION['currsem'])){
	foreach($semester as $key => $value){
	    if($value->iscurrent == "t"){
	        $currsem = $value->sem;
	        $curryear = $value->sy;
	    }
	}
}
if (isset($_SESSION['token']) && (isset($_SESSION['empid']) && ($_SESSION['token'] != ''))) {
    ?>
    <div class="container-fluid">
        <!--
        <div class="row">
        <div class="col-sm-12">
        <div class="panel-heading grey-light">
        <h1>MSU-IIT Web eSMS</h1>
        </div>	
        <div class="panel-body grey-dark">
        <p>This is a test content.</p>
        </div>	
        </div>
        </div>
        --> 
        <div class="row">
            <div class="col-sm-2" style="z-index:100;">
                <form id="adv-form-search" name="advformsearch">
                    <div id="adv-search" class="input-group form-search">
                        <input id="adv-inpt-search" class="form-control search-query" placeholder="Search Student" <?php if(isset($_GET['studid'])){echo 'value="'.$_GET['studid'].'"';} ?> />
                        <span class="input-group-btn">
                            <button id="adv-btn-search" class="btn btn-danger" data-type="last" type="button"><i class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div>
                </form>
                <div id="results" class="list-group"></div>
                <br />
                <div id="photo" class="col-xs-12 thumbnail">
                    <img class="img-rounded" src="./img/iit-default-profile.gif" />
                    <div class="caption text-center">
                        <p id="idNumber"><?php echo $validity; ?></p>
                    </div>
                </div>

            </div>
            <div class="col-sm-10">
                <div class="row">
                    <div class="container-fluid">
                        <div class="list-group">
                            <div class="list-group-item active grapefruit-light">
                                <h5>ADVISING &amp; SUBJECT REGISTRATION</h5>							
                            </div>
                            <div class="list-group-item" style="background-color: rgb(248, 246, 250);">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div id="semgroup" class="list-group" style="text-align:center;">
                                                    <div id="semester" class="list-group-item grey-dark">
                                                        SCHOOL YEAR :: SEMESTER													
                                                    </div>
                                                    <div id="schoolyear" class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-sm-12">         
                                                                <select id="semNumber">
                                                                	<?php 
                                                                	if(isset($semester)){
                                                                		foreach($semester as $k => $v){
                                                                			echo '<option id="'.$v->sy.'_'.$v->sem.'" data-sy="'.$v->sy.'" value="'.$v->sem.'">'.$v->sy.' :: '.$v->sem.'</option>';
                                                                		}
                                                                	} else {
                                                                		echo '<option value="1">1</option>';
                                                                	}
                                                                	?>
                                                                </select>													
                                                            </div>
                                                        </div>													
                                                    </div>
                                                    <div class="list-group-item sunflower-light">
                                                        <div class="row">
                                                            <div class="">
                                                                <div class="col-sm-6" style="font-size:10px;text-align:center;">
                                                                    Tuition based on year:
                                                                </div>
                                                                <div id="tuitionbase" class="col-sm-6" style="font-weight:bold;">
                                                                    2012
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>						
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="list-group">
                                                    <div class="list-group-item grey-dark">
                                                        <div class="row" style="text-align:center;">
                                                            STUDENT INFORMATION														
                                                        </div>													
                                                    </div>
                                                    <div class="list-group-item">	
                                                        <div class="row">													
                                                            <div class="col-sm-3"><input type="text" name="studnum" id="studid" placeholder="Student ID" class="col-sm-12" <?php echo 'value="'.$studid.'"'; ?> /></div>
                                                            <div class="col-sm-9"><input type="text" name="stud_name" id="studname" placeholder="Student Name" class="col-sm-12" /></div>									
                                                        </div>
                                                    </div>
                                                    <div class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-sm-3"><input type="text" name="stud_year" id="studyear" placeholder="Year" class="col-sm-12" /></div>
                                                            <div class="col-sm-3 input-grp form-search">                                                                                                                                                                                                                                            
                                                                    <!-- <input type="text" name="stud_major" id="studmaj" placeholder="Major" class="form-control " />
                                                                    <div class="input-group-btn">
                                                                        <button id="progsearch" class="btn btn-danger" data-type="last">
                                                                            search
                                                                        </button>
                                                                    </div> -->
                                                                <div id="prog-search" class="input-group form-search">
                                                                	
                                                                    <input id="studmaj" class="form-control search-query" placeholder="Major" readonly />
                                                                    
                                                                    <span class="input-group-btn">
                                                                        <button id="prog-btn-search" class="btn btn-danger" data-type="last" type="button"><i class="glyphicon glyphicon-search"></i></button>
                                                                    </span>
                                                                    
                                                                    <!--<select id="studmaj" class=""></select>-->
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div id="scholastic-ref" class="input-group form-search">
                                                                    <input type="text" name="stud_scholstatus" id="studscholstat" placeholder="Scholastic Status" class="form-control search-query" />
                                                                    <span class="input-group-btn">
                                                                        <button id="prog-btn-schol" class="btn btn-danger" data-type="last" type="button"><i class="glyphicon glyphicon-refresh"></i></button>
                                                                    </span>                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3"><input type="text" name="stud_scholar" id="studscholar" placeholder="Scholarship Status" class="col-sm-12" /></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>										
                                    </div>								
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">

                                        <div id="regpanel" class="panel">
                                            <ul class="nav nav-tabs nav-default">
                                                <li class="active">
                                                    <a href="#otherinfo" data-toggle="tab">OTHER INFORMATION</a>											
                                                </li>
                                                <li>
                                                    <a href="#registration" data-toggle="tab">SUBJECT REGISTRATION</a>											
                                                </li>	
                                            </ul>
                                            <div id="tabpanes" class="tab-content">										
                                                <div class="tab-pane fade active in" id="otherinfo">													
                                                    <div class="list-group">
                                                        <div class="list-group-item">

                                                            <div class="col-sm-9">
                                                                <div class="list-group">
                                                                    <div class="list-group-item grey-light">ADDRESS</div>	
                                                                    <div class="list-group-item" style="background-color: rgb(248, 246, 250);">
                                                                        <div class="row">
                                                                            <select id="province" class="selecter_basic selecter-element col-sm-5 col-sm-offset-1">
                                                                            <?php 
                                                                            foreach($province as $key => $value){
                                                                            	if($province[$key]->province_id != 0){
                                                                            	echo '<option value="'.$province[$key]->province_id.'">'.$province[$key]->province_name.'</option>';
                                                                            	}
                                                                            }
                                                                            ?>
                                                                            </select>																		
                                                                            <select id="towncity" class="selecter_basic selecter-element col-sm-4 col-sm-offset-1">
                                                                            <?php 
                                                                            	$provid = "";
                                                                            	if(isset($_POST['province_id'])){ 
                                                                            		$provid = $_POST['province_id'];
                                                                            		foreach($alltc as $key => $value){
                                                                            			if($alltc[$key]->province_id == $provid){
                                                                            				echo '<option value="'.$alltc[$key]->towncity_id.'">'.$alltc[$key]->towncity_name.'</option>';
                                                                            			}
                                                                            		}
                                                                            	} else {
                                                                            		foreach($alltc as $key => $value){
                                                                            			if($alltc[$key]->province_id == 1){
                                                                            				echo '<option value="'.$alltc[$key]->towncity_id.'">'.$alltc[$key]->towncity_name.'</option>';
                                                                            			}
                                                                            		}
                                                                            	}
                                                                            ?>
                                                                            </select>																		
                                                                        </div>
                                                                    </div>
                                                                    <div class="list-group-item" style="background-color: rgb(248, 246, 250);">
                                                                        <div class="row">
                                                                            <input type="text" name="barangay" id="brgy" placeholder="Barangay" class="col-sm-5 col-sm-offset-1" />																		
                                                                            <input type="text" name="streetpurok" id="strtpurok" placeholder="Street/Purok" class="col-sm-4 col-sm-offset-1" />																		
                                                                        </div>
                                                                    </div>
                                                                    <div class="list-group-item grey-light">
                                                                        RELIGION
                                                                    </div>
                                                                    <div class="list-group-item" style="background-color: rgb(248, 246, 250);">
                                                                        <div class="row">
                                                                            <select id="religion" class="selecter_basic selecter-element col-sm-5 col-sm-offset-1">

                                                                            </select>
                                                                                <!-- <input type="text" name="relaffiliation" id="relaff" placeholder="Affiliation" class="col-sm-5 col-sm-offset-1" /> -->
                                                                            <select id="denomination" class="selecter_basic selecter-element col-sm-4 col-sm-offset-1">

                                                                            </select>
                                                                            <!-- <input type="text" name="reldenomination" id="relden" placeholder="Denomination" class="col-sm-4 col-sm-offset-1" /> -->

                                                                        </div>
                                                                    </div>
                                                                    <div class="list-group-item" style="background-color: rgb(248, 246, 250);">
                                                                        <div class="row">
                                                                            <input type="text" name="relother" id="reloth" placeholder="Other" class="col-sm-4 col-sm-offset-1" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="list-group">
                                                                    <div class="list-group-item grey-light">GROSS FAMILY INCOME</div>	
                                                                    <div class="list-group-item" style="background-color: rgb(248, 246, 250);">
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio" name="famIncome" id="rad1" value="10,000 and below" />
                                                                                10,000 and below																	
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio" name="famIncome" id="rad2" value=">10,000 to 20,000" />
                                                                                >10,000 to 20,000																	
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio" name="famIncome" id="rad3" value=">20,000 to 30,000" />
                                                                                >20,000 to 30,000																	
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio" name="famIncome" id="rad4" value=">30,000 to 40,000" />
                                                                                >30,000 to 40,000																	
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio" name="famIncome" id="rad5" value=">40,000 to 50,000" />
                                                                                >40,000 to 50,000																	
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio" name="famIncome" id="rad6" value=">50,000 to 60,000" />
                                                                                >50,000 to 60,000																	
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio" name="famIncome" id="rad7" value=">60,000 to 70,000" />
                                                                                >60,000 to 70,000																	
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio" name="famIncome" id="rad8" value=">70,000" />
                                                                                >70,000																	
                                                                            </label>
                                                                        </div>
                                                                    </div>														
                                                                </div>
                                                            </div>													

                                                            <div class="row">
                                                                <div class="col-sm-4 col-sm-offset-4">
                                                                    <button id="infosavebtn" type="button" class="btn btn-danger btn-block col-sm-12">SAVE</button>
                                                                </div>
                                                                <div class="col-sm-4">

                                                                </div>
                                                            </div>												
                                                        </div>											
                                                    </div>											
                                                </div>
                                                <div class="tab-pane fade" id="registration">
                                                    <div class="row">
                                                        <div class="col-sm-2">
                                                            <p>You are logged as <span class="badge badge-default"><?php echo $_SESSION['pos']; ?></span></p>
                                                        </div>
                                                        <div class="col-sm-7">
                                                            <div class="input-group form-search">
                                                                <input id="subj_search" type="text" class="form-control search-query" />                                                                                                            
                                                                <span class="input-group-btn">
                                                                    <button id="subjsearch" type="submit" class="btn btn-info" data-type="last">Add Subject</button>
                                                                </span>                                                                                                            
                                                            </div>
                                                            <div id="subjsearch_box" class=" list-group col-sm-11" data-subjcode="" data-section="">                                                                                                            
                                                                <a href="#">Nothing to show here.</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p>Total Units: <span id="units" class="badge badge-default" style="font-size:14px;">0.00</span></p>
                                                        </div>
                                                    </div>
                                                    <br />
                                                    <div class="row">
                                                        <div class="table-responsive col-sm-12" style="width:95%; margin:0px auto" display="table">
                                                            <table id="subjtable" class="table">
                                                                <thead>
                                                                    <tr class="sunflower-light">
                                                                        <th>#</th>
                                                                        <th>Subject Code</th>
                                                                        <th>Section</th>
                                                                        <th>Description</th>
                                                                        <th>Credit</th>
                                                                        <th>Days</th>
                                                                        <th>Time</th>
                                                                        <th>Room</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>									
                                </div>							
                            </div>						
                        </div>					
                    </div>				
                </div>			
            </div>
        </div>
        <div id="bottom"></div>
    </div>
    <!-- modals -->

    <!-- modal-search-info -->

    <div id="modal-search1" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4>Search Program</h4>
                </div>
                <div class="modal-body">
                    <div class="col-sm-6 col-sm-offset-3">
                        <input type="text" name="searchprog" id="progsearch" placeholder="Example: BSA" class="col-sm-12" value="" />
                    </div>
                    <div class="col-sm-12">
                        <div id="proglistspace" class="list-group">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" id="okbtn" class="btn btn-success">OK</button> -->
                    <button type="button" id="xbtn" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--modal-alert -->

    <div id="modal-alert" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3>Attention!</h3>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to save information? This cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="yesbtn" class="btn btn-success">OK</button>
                    <button type="button" id="xbtn" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- end modal alert -->
    <!-- begin modal subject delete -->

    <div id="modal-subject-delete" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3>Attention!</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="subjdelete" class="col-sm-10 col-sm-offset-1"></div>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <!-- begin modal loading -->
    <div id="loadingModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="text-align:center;">
                    <img src="./images/loading.gif" />
                </div>
            </div>
        </div>
    </div>
    <!-- begin modal subject add -->
    <div id="modal-subject-add" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3>Confirm Add Subject</h3>
                </div>
                <div class="modal-body">
                    <div class="row">		    
                        <div id="subjadd" class="col-sm-12">
                            <!-- INSERT TABLE HERE -->
                            <table id="addsubjtable" class="table-responsive col-sm-12">
                                <thead>
                                    <tr class="sunflower-light">
                                        <th>subjcode</th>
                                        <th>section</th>
                                        <th>schedule</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="tdsubjcode"></td>
                                        <td id="tdsection"></td>
                                        <td id="tdsched"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <br />
                        <div class="col-sm-10 col-sm-offset-1"><p>Are you sure you want to add the subject above to <span id="addstude" style="font-weight: bold;"></span>?</p></div>
                        <br />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="sa-ok" class="btn btn-success" data-student="" data-addsubj="" data-addsect="">OK</button>
                    <button type="button" id="sa-no" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end subject add modal -->
    <!-- begin loading modal -->
    <div id="modal-loading" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">                
                <div class="modal-body">
                    <div class="col-sm-12">
                        <img src="./img/loading.gif" alt="loading..." />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end loading modal -->
    <?php
}
?>
<script type="text/javascript">
$.ytLoad();
var provinces = <?php echo json_encode($provi->data->data); ?>;
var result = $.parseJSON(<?php echo json_encode($toci); ?>); 
var sems = <?php echo $sem1; ?>;
var relcat = <?php echo json_encode($rel); ?>;
var denoms = <?php echo json_encode($denoms); ?>;
var majors = $.parseJSON(<?php echo json_encode($get_progoff); ?>);
var currsem = 1;
var curryear = '2014-2015';
activeSem = $("#semNumber").val();
activeYear = $("#semNumber").children(":selected").attr("data-sy");
var relcathtml = "";
var denhtml = "";
var majhtml = "";
//console.log(majors);
$.each(sems, function(k,v){
	$.each(v,function(l,w){
		if(w.iscurrent == 't'){
			currsem = w.sem;
			currsyear = w.sy;
		}
	});
});
/*
$.each(majors,function(k,v){
	$.each(v,function(l,w){
		//console.log(w.progcode);
		majhtml += '<option value="'+$.trim(w.progcode)+'">'+$.trim(w.progcode)+'</option>';
	});
});
*/
$('div#modal-subject-delete div.modal-dialog div.modal-content div.modal-footer').html('<button type="button" id="dyesbtn" class="btn btn-danger">OK</button><button type="button" id="xbtn" class="btn btn-success" data-dismiss="modal">Close</button>');
var rc = $.parseJSON(relcat);
//console.log(rc.data);
$.each(rc,function(k,v){
	$.each(v,function(l,w){
		relcathtml += '<option id="relcat_'+w.id+'" value="'+w.id+'">'+w.catname+'</option>';
	});
});
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
function listDenoms(){
	denhtml = '';
	var currRel = $("select#religion").val();
	$.each(denoms,function(k,v){
		if(v.cat_id == currRel){
			$.each(v,function(l,w){
				if($.isArray(w)){
					$.each(w,function(m,x){
						$.each(x,function(n,y){
							denhtml += '<option value="'+y.id+'">'+y.relname+'</option>';
						});
					});
				}
			});
		}
	});
	$("select#denomination").html(denhtml);
}
function getTowncities(){
	var pval = $("#province").val();
	var tchtml = '';
	$('#towncity').html('');
	$.each(result, function(k,v){
		$.each(v,function(l,w){
			$.each(w, function(k,v){
				if(v.province_id == pval){
					tchtml += '<option value="'+v.towncity_id+'">'+v.towncity_name+'</option>';
				}
			});
		});
	});
	$('#towncity').html(tchtml);
}
function searchStude(stu){
	//console.log("stu:"+stu+", sem: "+activeSem+", sy:"+activeYear);
	$.ajax({
            type: "POST",
            url: "./control.php",
            data: {action: 'studesearch', stude: stu, limit:9, sem:activeSem, sy:activeYear},
            cache: false,
            async: false,
            beforeSend:function(){
            },
            success: function(feedback) {
                var fb = $.parseJSON(feedback);
                var counter = 0;
                var rhtml='';
                $.each(fb,function(k,v){
                	counter++;
                	//console.log(v);
                	rhtml += '<a href="#" id="' + v.studid + '" class="list-group-item"><span class="search_studid">' + v.studid + '</span>, <span class="search_studfullname">' + v.studfullname + '</span></a>';
                });
                if(counter > 1){
                	$.gritter.add({
		                title: 'SEARCH RESULTS:',
		                text: 'Found '+counter+' results.',
		                class_name: 'gritter-sunflower',
		                sticky: false
		            });
                	$('div#results').html(rhtml);
                	$("div#results").fadeIn();
                } else {
                	$("div#results").fadeOut();
                    $("div#results").html('');
                	var studentID = '';
                	$.each(fb,function(k,v){
                		studentID = v.studid;
                	});
                	getStudent(studentID);
                }
            },
            complete:function(){
                
            }
        });
	$('div#results a').on('click', function(e) {
	    e.preventDefault();
	    console.log("hey!");
	    $("#results").fadeOut();
	    var studid = $(this).attr('id');
	    $('input#adv-inpt-search').val(studid);
	    var name = $("#"+studid+" span.search_studfullname").text();
	    $("#studname").val(name);
	    console.log("name is: "+name);
	    getStudent(studid);
	});
}
function getStudent(stuid){
	//console.log("student id is "+stuid);
	var dt = "";
	$.ajax({
		url: './control.php',
        type: 'POST',
        dataType: 'json',
        async: false,
        data:{"action":"getStudent","studid":stuid,"sem":activeSem,"sy":activeYear},
        success:function(feedback){ 
    		dt = $.parseJSON(feedback);    		
	        setUp(dt);
        },
        error:function(feedback){
        	//var OriginalString =feedback.responseText;
        	//var StrippedString = OriginalString.replace(/(<([^>]+)>)/ig,"");
        	//var dataset = $(feedback.responseText).content();
        	var errormssg = feedback.responseText;
        	//console.log("stuid is: "+stuid);
        	$("#idNumber").text(stuid);
			$("#studid").val(stuid);
        	$.gritter.add({
			    title: 'SEARCH RESULTS:',
			    text: 'There seems to be an error finding info on this student.',
			    class_name: 'gritter-sunflower',
			    sticky: false
			});
			$("#studyear").val('');
			$("#studscholar").val('');
			$("#studmaj").val('');
			$("#studscholstat").val('');
			$("#tuitionbase").text('');
			$("#reloth").val('');
			$("#brgy").val('');
			$("#strtpurok").val('');
			$('input:radio[value="10,000 and below"]').parent().trigger('click');
        }
	});
}
function setUp(dataset){
	console.log(dataset);
		var main = "";
		var other = "";
		var subjects = "";
	    $.each(dataset,function(k,v){
		    if(k == 'studinfo'){
		        main = v;
		    }
		    if(k == 'studoinfo'){
		    	other = v;
		    }
		    if(k == 'studsubjects'){
		    	subjects = v;
		    }
		});
		$("#idNumber").text(main.studid);
		$("#studid").val(main.studid);
		$("#studname").val(main.studfullname);
		$("#studyear").val(main.studlevel);
		$("#studscholar").val(main.schdesc);
		$("#studmaj").val(main.progcode);
		$("#studscholstat").val(main.scholasticstatus);
		$("#tuitionbase").text(main.payment_scheme_year);
		$("#province").val(other.province_id);
		$("#province").trigger("change");
		$("#towncity").val(other.towncity_id);
		$("#religion").val(other.religion_category_id);
		$("#religion").trigger("change");
		$("#denomination").val(other.religion_id);
		$("#reloth").val(other.religion_other);
		$("#brgy").val(other.brgy);
		$("#strtpurok").val(other.street);
		if (other.familymonthlyincome == '') {
	    $('input:radio').attr('checked', false);
	        console.log("none!");
	    } else {
	        $('input:radio[value="' + other.familymonthlyincome + '"]').parent().trigger('click');
	    }
	    $("table#subjtable").html('<thead><tr class="sunflower-light"><th>#</th><th>Subject Code</th><th>Section</th><th>Description</th><th>Credit</th><th>Days</th><th>Time</th><th>Room</th><th>Action</th></tr></thead><tbody></tbody>');
	    $("tr", "table#subjtable tbody").remove();
	    //console.log("total subjects: "+subjects.length);
	    if(subjects.length != 0){
	    	$.each(subjects, function(k, v) {
                var num = (k + 1);
                $('table#subjtable tbody').fadeIn(speed, function() {
                    $('table#subjtable tbody:last').append('<tr id="row_' + num + '"><td>' + num + '</td><td>' + v.subjcode + '</td><td>' + v.section + '</td><td>' + v.subjdesc + '</td><td>' + v.subjcredit + '</td><td>' + v.days + '</td><td>' + v.time + '</td><td>' + v.roomno + '</td><td><div class="btn-group-vertical"><button type="button" class="btn btn" onclick="delClick(\'row_' + num + '\');"><i class="glyphicon glyphicon-trash"></i></button></div></td></tr>');
                });
            });
	    } else {
	    	$('table#subjtable tbody').fadeIn(speed, function() {
                $('table#subjtable tbody:last').append('<tr id="row_1"><td colspan="2">Nothing to show here.</td></tr>');
            }); 
	    }
	    var sum = 0;
        var counter = 1;
        $.each($("table#subjtable tbody tr"),function(k,v){
        var credits = $.trim($("table#subjtable tbody tr[id=row_"+counter+"] td").eq(4).text());
        if($.isNumeric(credits)){
            var num = parseFloat(credits);
            sum = sum+num;
        }
        counter++;
        });
        //console.log("counter: "+counter+", total credits: "+sum.toFixed(2));
        $('span#units').text(sum.toFixed(2));
}
function delClick(rowId) {
    $('div#modal-subject-delete').modal({
        "backdrop": "static",
        "keyboard": true,
        "show": true
    });
    var subjcode = $('#' + rowId + ' td').eq(1).text();
    var subjtitle = $('#' + rowId + ' td').eq(3).text();
    var section = $('#' + rowId + ' td').eq(2).text();
    $('div#subjdelete').html('Are you sure you want to delete <span id="subjdel" style="font-weight:bold;">' + subjcode + '</span>: <span id="subjecttitle" style="font-weight:bold;">' +subjtitle+',</span> <span id="subsect" style="font-weight:bold;">'+ section + '</span>?');
}
function createMajList(m) {
    var listItems = '';
    var num = 0;
    $("a", "div#proglistspace").remove();
    $.each(m, function(k, v) {
        var x = num;
        //console.log(v.progcode);
        listItems += "<a href='#' id='prog_" + x + "' class='majlist list-group-item' alt='" + v.progcode + "' data-desc='" + v.progdesc + "'><span style='font-weight:bold;'>" + v.progcode + "</span>&nbsp;" + v.progdesc + "</a>"
        num++;
    });
    $('#proglistspace').html(listItems);
    $('a.majlist').on("click", function(ev) {
        ev.preventDefault();
        var progc = $(this).attr('id');
        var progd = $('#' + progc).attr('data-desc');
        var prog = $.trim($('#' + progc).attr('alt'));
        //console.log(progd);
        $('input#studmaj').val(prog);
        $('#progsearch').val(prog);
        //$('#modal-search1 div.modal-dialog div.modal-content div.modal-header button').trigger('click');
        $('#modal-search1').modal('hide');
    });
}
function findSubjects(su) {
        if (su.length >= 2) {
            var semester = activeSem;
            var syear = activeYear;
            //console.log(semester);
            //console.log(syear);
            //console.log(su);
            var subjlist = '';
            $.ajax({
                url: './control.php',
                type: 'POST',
                dataType: 'json',
                async: false,
                data: {action: 'get_subjects', sy: syear, sem: semester, subj: su},
                success: function(subjects) {
                    var s = subjects.data;
                    //console.log(s);
                    if (s.length > 0) {
                        $.each(s, function(k, v) {
                            subjlist += '<a href="#" id="subj_' + k + '" class="subsearch list-group-item"><span id="scode_' + k + '">' + v.subjcode + '</span>, <span id="sect_' + k + '">' + v.section + '</span>, <span id="sched_' + k + '">' + v.slinetxt + '</span></a>';
                        });
                        $('#subjsearch_box').html(subjlist);
                        $('a.subsearch').on('click', function(ev) {
                            ev.preventDefault();
                            $('div#subjsearch_box').fadeOut();
                            var selectedSubj = $(this).attr('id');
                            var subjCode = $.trim($('#' + selectedSubj + " span").eq(0).text());
                            var subjSect = $.trim($('#' + selectedSubj + " span").eq(1).text());
                            var subjSched = $.trim($('#' + selectedSubj + " span").eq(2).text());
                            $('#subj_search').val(subjCode + ', ' + subjSect + ', ' + subjSched);
                            $('#subj_search').attr('data-subjcode', subjCode);
                            $('#subj_search').attr('data-section', subjSect);
                            $('#subj_search').attr('data-sched', subjSched);
                        });
                    }
                }
            });
        } else {
            $('#subjsearch_box').html('<a href="#">Nothing to show here.</a>');
        }
    }
$(document).ready(function(){
	var stuid = getParameterByName('studid');
	//console.log(stuid);	
	$("#semNumber").val(currsem);
	activeSem = $("#semNumber").val();
	activeYear = $("#semNumber").children(":selected").attr("data-sy");
	//console.log(activeSem);
	$("select#religion").html(relcathtml);
	var currRel = $("select#religion").val();
	$.each(denoms,function(k,v){
		if(v.cat_id == currRel){
			$.each(v,function(l,w){
				if($.isArray(w)){
					$.each(w,function(m,x){
						$.each(x,function(n,y){
							denhtml += '<option value="'+y.id+'">'+y.relname+'</option>';
						});
					});
				}
			});
		}
	});
	$("select#denomination").html(denhtml);
	
	//$("#studmaj").html(majhtml);
	searchStude(stuid);
});
$("#semNumber").on("change",function(){
	var syr1 = $(this).children(":selected").attr("id");
	//var syr1 = $("#semNumber option[value="+syr+"]").attr("data-sy");
	activeSem = $("#"+syr1).attr("value");
	activeYear = $("#"+syr1).attr("data-sy");
	//console.log(syr1+":"+activeYear+":"+activeSem);

});
$("#province").on("change",function(){
	getTowncities();
});
$("select#religion").on("change",function(){
	listDenoms();
});
$("input#adv-inpt-search").on("keyup",function(){
    var input = $(this).val();
    var pageUrl = 'index.php?studid='+input;
    if(pageUrl!=window.location){
        window.history.pushState({path:pageUrl},'',pageUrl);
    }
});
$("input#adv-inpt-search").keypress(function(k){
    if(k.which == 13){
        var input = $(this).val();
        var pageUrl = 'index.php?studid='+input;
        if(pageUrl!=window.location){
            window.history.pushState({path:pageUrl},'',pageUrl);
        }
        k.preventDefault();
        var stuid = getParameterByName('studid');
        $(this).data('timer', setTimeout(searchStude(stuid), 100));
    }
});
$("button#adv-btn-search").on("click", function(v) {
	v.preventDefault();
	if (($('input#adv-inpt-search') !== '') || ($('input#adv-inpt-search') !== null)) {
                clearTimeout($.data(this, 'timer'));
                // Set Search String
                var search_string = $('input#adv-inpt-search').val();
                // Do Search
                if ((search_string == '') || (search_string == null)) {
                    $("div#results").fadeOut();
                    //$('h4#results-text').fadeOut();
                } else {
                    $("div#results").fadeIn();
                    //$('h4#results-text').fadeIn();
                    var student = $('input#adv-inpt-search').val();
                    $(this).data('timer', setTimeout(searchStude(student), 100));
                }
                ;
            } else {
                $.gritter.add({
                    title: 'SEARCH STUDENT',
                    text: 'Cannot search using empty parameters.',
                    class_name: 'gritter-sunflower',
                    sticky: false
                });
            }

});
$("#prog-btn-search").on("click", function() {
    $("#modal-search1").modal({
        "backdrop": "static",
        "keyboard": true,
        "show": true
    });
    var major = $('input#studmaj').val();
    $('input#progsearch').val(major);
});
$('#progsearch').on("keyup", function() {
    var progcode = $(this).val();
    if (progcode.length >= 2) {
        //console.log("Hey!");
        $.ajax({
            url: './control.php',
            type: 'POST',
            timeout:5000,
            dataType: 'json',
            async: false,
            data: {action: 'get_maj', program: progcode},
            success: function(maj) {
                var m = maj.data;
                createMajList(m);
                //console.log(m);
            }
        });
    }
});
$('#subj_search').on('keyup', function() {
    var logTest = $(this).checkLog();
    if (logTest) {
        var search_subj = $.trim($(this).val());
        clearTimeout($.data(this, 'timer'));
        if ((search_subj == '') || (search_subj == null)) {
            $('div#subjsearch_box').fadeOut();
        } else {
            $('div#subjsearch_box').fadeIn();
            $(this).data('timer', setTimeout(findSubjects(search_subj), 100));
        }
    }
});
$('#modal-alert button#yesbtn').on('click', function() {
        $('#modal-alert').modal('hide');
});
$("#modal-search").on("hide", function() { // remove the event listeners when the dialog is dismissed
    $("#modal-search .modal-dialog .modal-content > .modal-footer button#okbtn").off("click");
});
$('div#modal-subject-delete div.modal-dialog div.modal-content div.modal-footer button#dyesbtn').on("click", function() {
        var content = $('div#subjdelete span').eq(0).text();
        var contsect = $('div#subjdelete > span').eq(2).text();
        var studentID = $('input#studid').val();
        var sems = activeSem;
        var scy = activeYear;     
        console.log("subject is: "+content+"section is: "+contsect+" studid: "+studentID+" semester:"+sems+" school-year:"+scy);
        $.ajax({
            url:'./control.php',
            type:'POST',
            dataType:'json',
            async:false,
            data:{action:'remove_subj',sy:scy,sem:sems,studid:studentID,subjcode:content,section:contsect},
            beforeSend:function(){
            },
            success:function(delfeed){
               //console.log(delfeed.data.data.remove_semstudent_subject);
               getStudent(studentID);
                $.gritter.add({
                    title: 'SUBJECT REMOVE STATUS:',
                    text: content+' '+contsect+': '+delfeed.data.data.remove_semstudent_subject,
                    class_name: 'gritter-sunflower',
                    sticky: false
                });
            },
            error: function() {
                $('#modal-subject-delete').modal('hide');
                $.gritter.add({
                    title: 'SUBJECT REMOVE STATUS:',
                    text: 'An error has occurred. Nothing removed.',
                    class_name: 'gritter-sunflower',
                    sticky: false
                });
            },
            complete: function() {
                
                $('#modal-subject-delete').modal('hide');
            }
        });
    });
$('button#subjsearch').on('click', function(d) {
		d.preventDefault();
        var dtEntry = $('#subj_search').val();
        var dtSubject = $('#subj_search').attr('data-subjcode');
        var dtSect = $('#subj_search').attr('data-section');
        var dtSched = $('#subj_search').attr('data-sched');
        var idNum = $('#idNumber').text();
        if ((dtEntry.length > 0) && (dtSubject.length > 0)) {
            //console.log(dtSect);
            $('button#sa-ok').attr('data-student', idNum);
            $('#addstude').text(idNum);
            $('button#sa-ok').attr('data-addsubj', dtSubject);
            $('button#sa-ok').attr('data-addsect', dtSect);
            $('#tdsubjcode').text(dtSubject);
            $('#tdsection').text(dtSect);
            $('#tdsched').text(dtSched);
            $("#modal-subject-add").modal({
                "backdrop": "static",
                "keyboard": true,
                "show": true
            });
        } else {
            $('#subj_search').attr('data-subjcode', '');
        }
    });
$('button#sa-ok').on('click', function() {
        var semester = activeSem;
        var syear = activeYear;
        var stude = $(this).attr('data-student');
        var subjc = $(this).attr('data-addsubj');
        var sectn = $(this).attr('data-addsect');
        var sched = $('#tdsched').text();
        //console.log(stude+', '+subjc+', '+sectn);
        console.log('add subjects: {sem: '+semester+', school year: '+syear+', stude: '+stude+', subjcode: '+subjc+', section: '+sectn+', schedule: '+sched+'}');
        $.ajax({
            url: './control.php',
            type: 'POST',
            dataType: 'json',
            async: false,
            data: {action: 'add_subj', subjcode: subjc, section: sectn, studid: stude, sy: syear, sem: semester},
            beforeSend:function(){
                    
            },
            success: function(feedback) {
                console.log("add-subject: "+ feedback.data.data.add_semstudent_subject);
                getStudent(stude);
                $.gritter.add({
                    title: 'SUBJECT ADD STATUS:',
                    text: feedback.data.data.add_semstudent_subject,
                    class_name: 'gritter-sunflower',
                    sticky: false
                });
                $('#subj_search').val('');
            },
            error: function() {
                $.gritter.add({
                    title: 'SUBJECT ADD STATUS:',
                    text: 'An error has occurred.',
                    class_name: 'gritter-sunflower',
                    sticky: false
                });
            },
            complete: function() {
                
                $('#modal-subject-add').modal('hide');
                $('#subj_search').focus();
            }
        });
    });
$('#prog-btn-schol').on("click", function(){        
        var scholastic = $('input#studscholstat').val();
        if(scholastic !== '' || scholastic !== null){
            $.ajax({
                type:'POST',
                dataType: 'json',
                async:false,
                url:'./control.php',
                data:{
                    action: 'scholstatus',
                    sy: activeYear,
                    sem: activeSem,
                    studid: $("#studid").val(),
                    status:$('input#studscholstat').val()
                },
                success:function(feedback){
                    var feed = "";
                    if(feedback.data.update !== ''){
                        feed = feedback.data.update;
                    }else{
                        feed = feedback.data.error;
                    }
                    console.log('scholastic satus feedback: '+feedback);
                    $.gritter.add({
                        title: 'UPDATE SCHOLASTIC STATUS:',
                        text: 'Update Status: '+feed,
                        class_name: 'gritter-sunflower',
                        sticky: false
                    });
                },
                error:function(){
                    $.gritter.add({
                        title: 'UPDATE SCHOLASTIC STATUS:',
                        text: 'An error has occurred.',
                        class_name: 'gritter-sunflower',
                        sticky: false
                    });
                }
            });
        } else {
            $.gritter.add({
                title: 'UPDATE SCHOLASTIC STATUS:',
                text: 'Cannot leave scholastic status blank.',
                class_name: 'gritter-sunflower',
                sticky: false
            });
        }
        getStudent($("#studid").val());
    });
$("#infosavebtn").on("click", function() {
        var sname = $('input#studname').val();
        var idnum = $('input#studid').val();
        var majr = $('#studmaj').val();
        if ((sname != '') && (idnum != '') && (majr != '')) {
            $("#modal-alert").modal({
                "backdrop": "static",
                "keyboard": true,
                "show": true
            });
        } else {
            $.gritter.add({
                title: 'SAVE STUDENT INFO STATUS:',
                text: 'Cannot save info, no name, id number or major specified.',
                class_name: 'gritter-sunflower',
                sticky: false
            });
        }
    });
$('#yesbtn').on('click', function() {
        var famIncome = $.trim($('input:radio[name=famIncome]:checked').attr('value'));
        console.log("family income is: "+famIncome);
        var province1 = $('select#province').val();
        var towncity1 = $('select#towncity').val();
        console.log(activeSem+":"+activeYear+":"+$("#religion").val()+":"+$("#denomination").val());
        $.ajax({
            type: "POST",
            url: "./control.php",
            data: {
                action: 'save_studinfo',
                sy: activeYear,
                sem: activeSem,
                studid:  $('input#studid').val(),
                progcode: $('#studmaj').val(),
                level: $('input#studyear').val(),
                street: $('input#strtpurok').val(),
                towncity: towncity1,
                brgy: $('input#brgy').val(),
                province: province1,
                relcat: $('select#religion').val(),
                reldenom: $('select#denomination').val(),
                relother: $('input#reloth').val(),
                inc: famIncome
            },
            cache: false,
            async: false,
            success: function(fb) {
            	
            	console.log("fb is: "+fb);
                var feed = $.parseJSON(fb);
                var feed1 = feed.main;
                var feed2 = feed.other;
                $.gritter.add({
                    title: 'SAVE STUDENT INFO STATUS:',
                    text: 'Main Info: ' + feed1 + '<br />' + 'Other Info: ' + feed2,
                    class_name: 'gritter-sunflower',
                    sticky: false
                });
				
            },
            complete:function(){
                getStudent( $('input#studid').val());
            }
        });
    });
</script>
<?php 
include("./footer.php");
?>