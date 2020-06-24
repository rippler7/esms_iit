<?php
ob_start();
session_start();
include("./classes/caller.php");
$appcall = new Caller($config);
include("./header.php");
if (isset($_SESSION['token']) && (isset($_SESSION['empid']) && ($_SESSION['token'] != ''))) {
    $sem = array(
        'class'=>'webesms',
        'action'=>'get_sem',
        'token'=>$token,
        'timestamp'=>get_timestamp(),
        'user'=>$appman,
    );
    $sem1 = $appcall->apiCall($sem);
    $semester = json_decode($sem1)->data;
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
                        <input id="adv-inpt-search" class="form-control search-query" placeholder="Search Student" />
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
                        <p id="idNumber">2014-0000</p>
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
                                                        SEMESTER													
                                                    </div>
                                                    <div id="schoolyear" class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <ul class="nav nav-pills nav-justified">															
                                                                    <li id="semNumber" style="font-weight:bold;font-size:20px;line-height:14px;">2</li>
                                                                    <li id="sYear" >2014-2015</li>
                                                                </ul>														
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
                                                            <div class="col-sm-3"><input type="text" name="studnum" id="studid" placeholder="Student ID" class="col-sm-12" /></div>
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
                                                                    <input id="studmaj" class="form-control search-query" placeholder="Major" />
                                                                    <span class="input-group-btn">
                                                                        <button id="prog-btn-search" class="btn btn-danger" data-type="last" type="button"><i class="glyphicon glyphicon-search"></i></button>
                                                                    </span>
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

                                                                            </select>																		
                                                                            <select id="towncity" class="selecter_basic selecter-element col-sm-4 col-sm-offset-1">

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
                                                            <p>You are logged as <span class="badge badge-default">esms-controller</span></p>
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
} else {
    while (ob_get_status()) {
        ob_end_clean();
    }
    header("location:./login.php");
}
include("./footer.php");
?>
<script type="text/javascript" src="./js/plugins.js"></script>
<script type="text/javascript">
    $.ytLoad();
    var provinces = '';
    var towncities = '';
    var phtml = '';
    var tchtml = ''; 
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
    function setAllUp(studid){
        //console.log(studid);
        $('select#province').html('');
        $('select#towncity').html('');
        phtml = '';
            $.ajax({
               url: './control.php',
                type: 'POST',
                dataType: 'json',
                async: false,
                data:{"action":"setup","studid":studid},
                success:function(feedback){
                    var jdata = $.parseJSON(feedback);
                    provinces = jdata.provinces;
                    towncities = jdata.towncities;
                    $.each(provinces, function(k,v){
                        phtml += '<option value="'+v.province_id+'">'+v.province_name+'</option>';
                    });
                    $('select#province').html(phtml);
                    tchtml = '';
                    $('#semNumber').text(jdata.sem);
                    $('#sYear').text(jdata.sy);
                    if(jdata.studinfo != null){
                        $('input#studid').val(jdata.stid);
                        $('#idNumber').text(jdata.stid);
                        $('input#studname').val(jdata.studinfo.studfullname);
                        $('#tuitionbase').text(jdata.studinfo.payment_scheme_year);
                        $('#studyear').val(jdata.studinfo.studlevel);
                        $('#studmaj').val(jdata.studinfo.progcode);
                        $('#studscholstat').val(jdata.studinfo.scholasticstatus);
                        $('#studscholar').val(jdata.studinfo.schdesc);
                    }
                    if(jdata.studoinfo != null){
                        $('select#province').val(jdata.studoinfo.province_id);
                        $.each(towncities[$('select#province').val()], function(k,v){
                            tchtml += '<option value="'+v.towncity_id+'">'+v.towncity_name+'</option>';
                        });
                        //console.log('tchtml: '+tchtml);
                        $('select#towncity').html(tchtml);
                        $('#brgy').val(jdata.studoinfo.brgy);
                        $('select#towncity').val(jdata.studoinfo.towncity_id);
                    }                                    
                },
                error:function(){
                    $.gritter.add({
                        title: 'SYSTEM LOG:',
                        text: 'There seems to be an error.',
                        class_name: 'gritter-sunflower',
                        sticky: false
                    });
                }
            });
    }
    $(document).ready(function(){
        var stuid = getParameterByName('studid');
        setAllUp(stuid);
    });
    $('select#province').on("change",function(){
        thisProv = $(this).val();
        tchtml = '';
        $.each(towncities[thisProv], function(k,v){
            tchtml += '<option value="'+v.towncity_id+'">'+v.towncity_name+'</option>';
        });
        $('select#towncity').html(tchtml);
        console.log(towncities[thisProv]);
    });
    $("input#adv-inpt-search").on("keyup",function(){
        var input = $(this).val();
        var pageUrl = 'index2.php?studid='+input;
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
        }
    });
    $(window).bind('popstate', function() {
      $.ajax({url:location.pathname+'?studid=',success: function(data){
        $('#content').html(data);
      }});
    });
</script>