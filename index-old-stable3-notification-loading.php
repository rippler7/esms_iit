<?php
ob_start();
session_start();
include("./header.php");
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
    var studid = '';
    var studsubjects = '';
    var provinceNum = '';
    //------------------------------------- FUNCTIONS ------------------------------------------------------------------
    function listReligions(){
        var religionlist='';
        $.ajax({
                url: './search.php',
                type: 'POST',
                dataType: 'json',
                async: false,
                data: {action: 'get_rel'},
                success: function(religion) {
                    //console.log(religion.data);
                    $.each(religion.data, function(k, v) {
                        religionlist += "<option name='relselect' id='rel" + v.id + "' value='" + v.id + "'>" + v.catname + "</option>";
                    });
                    $('select#religion').html(religionlist);
                    populateDenom();
                }
            });
    }
    function setSemSY(){
        var semNum = '';
            var syDate = '';
            $.ajax({
                url: './search.php',
                type: 'POST',
                dataType: 'json',
                async: false,
                data: {action: 'getSem'},
                success: function(sem) {
                    semNum = sem.data.sem;
                    syDate = sem.data.sy;
                    semCurrent = sem.data.iscurrent;
                }
            });
            //console.log(semNum+", "+syDate+", "+semCurrent);
            $("li#semNumber").text(semNum);
            $("li#sYear").text(syDate);
    }
    function populateDenom() {
        var denomlist = '';
        var rel = $('select#religion').val();
        //console.log('relcat: '+rel);
        if (rel !== null) {
            $.ajax({
                url: './search.php',
                type: 'POST',
                dataType: 'json',
                async: false,
                data: {action: 'get_denom', relcat: rel},
                success: function(denom) {
                    //console.log('denom data: '+denom.data.data);
                    $.each(denom.data.data, function(k, v) {
                        denomlist += "<option name='denomselect' id='den" + v.id + "' value='" + v.id + "'>" + v.relname + "</option>";
                    });
                    $('select#denomination').html(denomlist);
                }
            });
        } else {
            $('select#denomination').html('');
        }
    }
    function populateTownCity() {
        var tclist = '';
        var prov = $('select#province').val();
        //console.log('relcat: '+rel);
        if (prov !== null) {
            $.ajax({
                url: './search.php',
                type: 'POST',
                dataType: 'json',
                async: false,
                data: {action: 'get_towncity', province: prov},
                success: function(tc) {
                    //console.log('denom data: '+denom.data.data);
                    tclist += "<div class='selecter-options'>";
                    $.each(tc.data.data, function(k, v) {
                        tclist += "<option name='tcselect' id='tc" + v.towncity_id + "' value='" + v.towncity_id + "'>" + v.towncity_name + "</option>";
                    });
                    tclist += "</div>";
                    $('select#towncity').html(tclist);
                }
            });
        } else {
            $('select#towncity').html('');
        }
    }
    function createRows(items) { //For subjects
        //console.log("createRows!");
        $("table#subjtable").html('<thead><tr class="sunflower-light"><th>#</th><th>Subject Code</th><th>Section</th><th>Description</th><th>Credit</th><th>Days</th><th>Time</th><th>Room</th><th>Action</th></tr></thead><tbody></tbody>');
        if (items.length !== 0) {
            $("tr", "table#subjtable tbody").remove();
            $.each(items, function(k, v) {
                var num = (k + 1);
                $('table#subjtable tbody').fadeIn(speed, function() {
                    $('table#subjtable tbody:last').append('<tr id="row_' + num + '"><td>' + num + '</td><td>' + v.subjcode + '</td><td>' + v.section + '</td><td>' + v.subjdesc + '</td><td>' + v.subjcredit + '</td><td>' + v.days + '</td><td>' + v.time + '</td><td>' + v.roomno + '</td><td><div class="btn-group-vertical"><button type="button" class="btn btn" onclick="delClick(\'row_' + num + '\');"><i class="glyphicon glyphicon-trash"></i></button></div></td></tr>');
                });
            });
        } else {
            $("tr", "table#subjtable tbody").remove();
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
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
    
    function search(stu) {
        var loadingGrit = '';
        $.ajax({
            type: "POST",
            url: "search.php",
            data: {action: 'studesearch', stude: stu, limit:9},
            cache: false,
            async: false,
            beforeSend:function(){
                    loadingGrit = $.gritter.add({
                        title:"LOADING...",
                        image:"./img/red-loading.gif",
                        class_name: 'gritter-sunflower',
                        sticky:true
                    });
            },
            success: function(html) {
                if ((provinceNum != null) || (provinceNum != '')) {
                    $('select#province option[id=prov' + provinceNum + ']').removeAttr('selected');
                }
                var feed = $.parseJSON(html);
                var htmlcontent = '';
                if(feed.data.length == 1){
                    layOut(feed.data[0]['studid']);
                    $("div#results").fadeOut();
                    $("div#results").html('');
                } else {
                    $(feed.data).each(function() {
                        htmlcontent += '<a href="#" id="' + this.studid + '" class="list-group-item"><span class="search_studid">' + this.studid + '</span>, <span class="search_studfullname">' + this.studfullname + '</span></a>';
                    });
                    $('div#results').html(htmlcontent);
                    $.gritter.add({
                        title: 'Search Results:',
                        text: 'Returned ' + feed.data.length + ' results.',
                        class_name: 'gritter-sunflower',
                        sticky: false
                    });

                    $('div#results a').on('click', function(e) {
                        e.preventDefault();
                        var detail = $(this).attr('id');
                        //console.log('id: '+detail);
                        var studid = $(this).attr('id');
                        $("div#results").fadeOut();
                        $('input#adv-inpt-search').val(studid);
                        layOut(studid);
                    });
                } 
            },
            complete:function(){
                $.gritter.remove(loadingGrit,{
                    fade:true,
                    speed:'fast'
                });
            }
        });
    }
    function layOut(studid){
    $('select#religion').html('');
    listReligions();
        var details = $(this).setUp({//THIS ONE HERE, REFER TO PLUGINS.JS FOR THE DEFINITION
                        stud_id: studid,
                        sem: $("li#semNumber").text(),
                        sy: $("li#sYear").text()
                    });
                    var parsed = $.parseJSON(details);
                    //---------------------------------------------
                    var input = $("input#adv-inpt-search").val();
                    var pageUrl = 'index.php?studid='+input;
                    //console.log(input);
                    if(pageUrl!=window.location){
                        window.history.pushState({path:pageUrl},'',pageUrl);
                    }
                    //---------------------------------------------
                    console.log(parsed);
                    var relID = parsed.other.religion_category_id;
                    $('input#studname').val(parsed.main.studfullname);
                    $('input#studyear').val(parsed.main.studlevel);
                    $('input#studmaj').val($.trim(parsed.main.progcode));                    //modal-search1
                    $('input#studscholstat').val(parsed.main.scholasticstatus);
                    $('input#studscholar').val(parsed.main.schdesc);
                    $('#tuitionbase').text(parsed.main.payment_scheme_year);
                    //$('input:radio[value="'+parsed.other.familymonthlyincome+'"]').attr('checked',true);
                    if (parsed.other.familymonthlyincome == '') {
                        $('input:radio').attr('checked', false);
                        console.log("none!");
                    } else {
                        $('input:radio[value="' + parsed.other.familymonthlyincome + '"]').parent().trigger('click');
                    }
                    $('input#prov').val(parsed.other.province_name);
                    $('input#tcity').val(parsed.other.towncity_name);
                    $('input#strtpurok').val(parsed.other.street);
                    $('input#brgy').val(parsed.other.brgy);
                    //$('input#relaff').val(parsed.other.religion_categoryname);
                    $('input#relden').val(parsed.other.religionname);
                    $('select#religion option[id=rel' + relID + ']').attr('selected', 'selected');
                    $('select#religion option[id=rel' + relID + ']').trigger('change');
                    $('#reloth').val(parsed.other.religion_other);
                    //console.log('before: '+provinceNum);                                
                    provinceNum = parsed.other.province_id;
                    //console.log('after: '+provinceNum);
                    if (parsed.other.religion_id == null) {
                        $('select#denomination').html('');
                    } else {
                        populateDenom();
                        $('select#denomination option[id=den' + parsed.other.religion_id + ']').attr('selected', 'selected');
                    }
                    $('input#relother').val(parsed.other.religion_other);                  
                    studsubjects = parsed.subjects.data;
                    $('select#province option[id=prov' + provinceNum + ']').attr('selected', 'selected');
                    $('select#province option[id=prov' + provinceNum + ']').trigger('change');
                    $('select#province').val(provinceNum);
                    //console.log($('select#province').val());
                    if (parsed.other.towncity_id == null) {
                        $('select#towncity').html('');
                    } else {
                        populateTownCity();
                        $('select#towncity option[id=tc' + parsed.other.towncity_id + ']').attr('selected', 'selected');
                    }
                    $('select#towncity').val(parsed.other.towncity_id);
                    createRows(parsed.subjects.data);
    }
    function findSubjects(su) {
        if (su.length >= 2) {
            var semester = $("li#semNumber").text();
            var syear = $("li#sYear").text();
            //console.log(semester);
            //console.log(syear);
            //console.log(su);
            var subjlist = '';
            $.ajax({
                url: './search.php',
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
    //-------------------------------------------------------------------------------------
    $(document).ready(function() {
        var stuid = getParameterByName('studid');
        var checked = $(this).checkLog();
        if (checked) {
            var provlist = '';
            setSemSY();
            $('select#religion').html('');
            var religions = '';
            listReligions();
            $.ajax({
                url: './search.php',
                type: 'POST',
                dataType: 'json',
                async: false,
                data: {action: 'get_prov'},
                success: function(prov) {
                    //console.log("province: "+prov.data.data);
                    var province = prov.data.data
                    $.each(province, function(k, v) {
                        provlist += "<option name='relselect' id='prov" + v.province_id + "' value='" + v.province_id + "'>" + v.province_name + "</option>";
                    });
                    $('select#province').html(provlist);
                    populateTownCity();
                }
            });
            console.log('stuid is: '+stuid);
            if(stuid != ''){
                var input = stuid;
                var pageUrl = 'index.php?studid='+input;
                console.log(input);
                if(pageUrl!=window.location){
                    window.history.pushState({path:pageUrl},'',pageUrl);
                }
                $("input#adv-inpt-search").val(stuid);
                layOut(stuid);
            }
        }
    });    

    /*
     $("#myModal").on("show", function() { // wire up the OK button to dismiss the modal when shown
     $("#myModal modal-dialogue modal-content > modal-footer button.btn").on("click", function(e) {
     console.log("button pressed"); // just as an example...
     $("#myModal").modal('hide'); // dismiss the dialog
     });
     });
     
     $("#myModal").on("hide", function() { // remove the event listeners when the dialog is dismissed
     $("#myModal button.btn").off("click");
     });
     $("#myModal").on("hidden", function() { // remove the actual elements from the DOM when fully hidden
     $("#myModal").remove();
     });
     $("#myModal").modal({ // wire up the actual modal functionality and show the dialog
     "backdrop" : "static",
     "keyboard" : true,
     "show" : true // ensure the modal is shown immediately
     });
     */
    //end modal    
    //-------------------------------------------- EVENTS ----------------------------------------------
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
            $("div#results").fadeIn();
            $(this).data('timer', setTimeout(search(input), 100));
            k.preventDefault();
        }
    });
    $("button#adv-btn-search").on("click", function(v) {
        v.preventDefault();
        var logTest = $(this).checkLog();
        if (logTest) {
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
                    $(this).data('timer', setTimeout(search(student), 100));
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
        } 
        //console.log("Clicked the 'OK' button!");
        //$("#modal-search").modal('hide');  
    });
    $('#modal-alert button#yesbtn').on('click', function() {
        $('#modal-alert').modal('hide');
    });
    $("#modal-search").on("hide", function() { // remove the event listeners when the dialog is dismissed
        $("#modal-search .modal-dialog .modal-content > .modal-footer button#okbtn").off("click");
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
        var loadingGrit = '';
        var famIncome = $.trim($('input:radio[name=famIncome]:checked').attr('value'));
        var province1 = $('select#province option[name=relselect]:selected').val();
        var towncity1 = $('select#towncity option[name=tcselect]:selected').val();
        $.ajax({
            type: "POST",
            url: "search.php",
            data: {
                action: 'save_studinfo',
                sy: $("li#sYear").text(),
                sem: $("li#semNumber").text(),
                studid: $('input#adv-inpt-search').val(),
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
            beforeSend:function(){
                loadingGrit = $.gritter.add({
                        title:"LOADING...",
                        image:"./img/red-loading.gif",
                        class_name: 'gritter-sunflower',
                        sticky:true
                    });
            },
            success: function(fb) {
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
                 layOut($('input#adv-inpt-search').val());
                 $.gritter.remove(loadingGrit,{
                     fade:true,
                     speed:'fast'
                 });
            }
        });
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
    $('#prog-btn-schol').on("click", function(){
        var loadingGrit = '';
        var scholastic = $('input#studscholstat').val();
        if(scholastic !== '' || scholastic !== null){
            $.ajax({
                type:'POST',
                dataType: 'json',
                async:false,
                url:'./search.php',
                data:{
                    action: 'scholstatus',
                    sy: $("li#sYear").text(),
                    sem: $("li#semNumber").text(),
                    studid: $('input#adv-inpt-search').val(),
                    status:$('input#studscholstat').val()
                },
                beforeSend:function(){
                        loadingGrit = $.gritter.add({
                        title:"LOADING...",
                        image:"./img/red-loading.gif",
                        class_name: 'gritter-sunflower',
                        sticky:true
                    });
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
                },
                complete:function(){
                    $.gritter.remove(loadingGrit,{
                        fade:true,
                        speed:'fast'
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
        layOut($('input#adv-inpt-search').val());
    });
    $('#progsearch').on("keyup", function() {
        var progcode = $(this).val();
        if (progcode.length >= 2) {
            //console.log("Hey!");
            $.ajax({
                url: './search.php',
                type: 'POST',
                timeout:5000,
                dataType: 'json',
                async: false,
                data: {action: 'get_maj', program: progcode},
                success: function(maj) {
                    var m = maj.data;
                    createMajList(m);
                }
            });
        }
    });
    $('div#modal-subject-delete div.modal-dialog div.modal-content div.modal-footer').html('<button type="button" id="yesbtn" class="btn btn-danger">OK</button><button type="button" id="xbtn" class="btn btn-success" data-dismiss="modal">Close</button>');
    $('div#modal-subject-delete div.modal-dialog div.modal-content div.modal-footer button#yesbtn').on("click", function() {
        var loadingGrit = '';
        var content = $('div#subjdelete span').eq(0).text();
        var contsect = $('div#subjdelete > span').eq(2).text();
        var studentID = $('input#studid').val();
        var sems = $("li#semNumber").text();
        var scy = $("li#sYear").text();     
        console.log("subject is: "+content+"section is: "+contsect+" studid: "+studentID+" semester:"+sems+" school-year:"+scy);
        $.ajax({
            url:'./search.php',
            type:'POST',
            dataType:'json',
            async:false,
            data:{action:'remove_subj',sy:scy,sem:sems,studid:studentID,subjcode:content,section:contsect},
            beforeSend:function(){
                    loadingGrit = $.gritter.add({
                        title:"LOADING...",
                        image:"./img/red-loading.gif",
                        class_name: 'gritter-sunflower',
                        sticky:true
                    });
            },
            success:function(delfeed){
                console.log(delfeed.data.data.remove_semstudent_subject);
                layOut(studentID);
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
                $.gritter.remove(loadingGrit,{
                    fade:true,
                    speed:'fast'
                });
                $('#modal-subject-delete').modal('hide');
            }
        });
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
    $('button#subjsearch').on('click', function() {
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
        var loadingGrit = '';
        var semester = $("li#semNumber").text();
        var syear = $("li#sYear").text();
        var stude = $(this).attr('data-student');
        var subjc = $(this).attr('data-addsubj');
        var sectn = $(this).attr('data-addsect');
        var sched = $('#tdsched').text();
        //console.log(stude+', '+subjc+', '+sectn);
        console.log('add subjects: {sem: '+semester+', school year: '+syear+', stude: '+stude+', subjcode: '+subjc+', section: '+sectn+', schedule: '+sched+'}');
        $.ajax({
            url: './search.php',
            type: 'POST',
            dataType: 'json',
            async: false,
            data: {action: 'add_subj', subjcode: subjc, section: sectn, studid: stude, sy: syear, sem: semester},
            beforeSend:function(){
                    loadingGrit = $.gritter.add({
                        title:"LOADING...",
                        image:"./img/red-loading.gif",
                        class_name: 'gritter-sunflower',
                        sticky:true
                    });
            },
            success: function(feedback) {
                console.log("add-subject: "+ feedback.data.data.add_semstudent_subject);
                layOut(stude);
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
                $.gritter.remove(loadingGrit,{
                    fade:true,
                    speed:'fast'
                });
                $('#modal-subject-add').modal('hide');
                $('#subj_search').focus();
            }
        });
    });
    $('select#religion').on('change', function() {
        populateDenom();
    });
    $('select#province').on('change', function() {
        populateTownCity();
    });
    $("a#aFind").on("click", function() {
        /* bootbox.alert("Hello world!", function() {
         console.log("Hey!");
         });
         */
        $("#modal-search").modal({
            "backdrop": "static",
            "keyboard": true,
            "show": true
        });
        //console.log('Hey!');
    });
</script>