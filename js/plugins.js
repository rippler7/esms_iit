(function($){
	var ret = '0';
    $.fn.loadInHere = function(options){
        var settings = $.extend({
          'theURL':''
        },options);
        $.ajax({
            url:settings.theURL,
            type:'POST',
            async: false
        });
        $(this).load(settings.theURL).hide().fadeIn('slow');
    }
	$.fn.checkLog = function(){
	   var retVal = '';
	   $.ajax({
            url:'./checklog.php',
            type:'POST',
            async: false, //This part here is responsible for enabling the ajax call success to evaluate first before the return value
            dataType:'json',
            data:({checklog:'checklog'}),
            success:function(rcvd){
               retVal = rcvd['logged'];              
            },
            error:function(){
                window.location.href = "./logout.php"; //Redirect to logout.php, which redirects to login page if session is out.
            }
        });
        return retVal;
	}
    $.fn.showPanel = function(options){
        var settings = $.extend({
            'conf':''
        },options);
        //console.log('ret is: '+ret);
        if(settings.conf == 0){
            $('#loginarea').hide().fadeIn('slow');
            $('#logged').show().fadeOut('slow');
            $('body').addClass('login');
            $('head').append('<link rel="stylesheet" href="assets/css/pages/login-soft.css" type="text/css" />');
            //$('body').append('<script type="text/javascript" src="./assets/scripts/login-soft.js"></script>');
            //Login.init();
        } else {
            $('#loginarea').show().fadeOut('slow');
            $('#logged').hide().fadeIn('slow');
            $('body').removeClass('login');
            $('link[href*="assets/css/pages/login-soft.css"]').remove();
            //$('script[src*="./assets/scripts/login-soft.js"]').remove();
        }
    }
    $.fn.logMe = function(option){
        var settings = $.extend({
            'username':'',
            'password':''
        },option);
		var reply = 0;
        $.ajax({
            url:'./logme.php',
            type:'POST',
            dataType:'json',
            data:({sbmtlogin:'sbmtlogin',username:settings.username,password:settings.password}),
			async:false,
            success:function(rcvd){
               //console.log(rcvd);
			   if(rcvd.mcode == 1){
				reply = 1;
			   } else if(rcvd.mcode == 2){
				reply = 2;
			   } else {
				reply = 0;
			   }
            }
        });
		return reply;
    }
    $.fn.loadOptions = function(){
            var uempid = $('#userbox div.modal-body div.row-fluid div.span6 h4').text();
            var cont = $(this).val();
            $.ajax({
                url:'./actions.php',
                type:'POST',
                dataType:'json',
                data:({listmodules:'listmodules',appoption:cont}),
                success:function(dt){
                    var dat = $.parseJSON(dt);
                    //var counter = dat.length;
                    var htmcontent = '';
                    $.each(dat,function(k,v){
                       //$.each(v,function(y,x){
                           htmcontent += "<option value='"+v["module_id"]+"'>"+v['module_name']+"</option>";
                       //}); 
                    });
                    $("#moduleslist").html(htmcontent);
                },
                error:function(){
                    var tester = $(this).checkLog();
                    $(this).showPanel({conf:tester});
                }
            });        
    }
    $.fn.loadSelection = function(option){
        var settings = $.extend({
            'URL':'',
            'actions':'',
            'appnum':'',
            'fval':'',
            'nval':'',
            'sBar':''
        },option);
        
        $.ajax({
            url:settings.URL,
            type:'POST',
            dataType:'json',
            data:({listItems:settings.actions,appoption:settings.appnum}),
            beforeSend:function(){
                    $('#modal-loading').modal({
                            "backdrop": "static",
                            "keyboard": false,
                            "show": true
                    });
            },
            success:function(dt){
                var dat = $.parseJSON(dt);
                var htmcontent = '';
                $.each(dat,function(k,v){
                    htmcontent += "<option value='"+v[settings.fval]+"'>"+v[settings.nval]+"</option>";
                });
                $("#"+settings.sBar).html(htmcontent);
            },
            error:function(){
                var tester = $(this).checkLog();
                $(this).showPanel({conf:tester});
            },
            complete:function(){
               $('#modal-loading').modal('hide'); 
            }
        });
        
    }
    $.fn.loadTable = function(option){
        var pars = $.extend({
            'trigger':'',
            'target':'',
            'signature':'',
            'user':'',
            'heading':'',
            'ident':'',
            'classes':'',
            'btns':''
        },option);
        $.ajax({
            url:pars.trigger,
            type:'POST',
            dataType:'json',
            data:({makeTable:pars.signature,usr:pars.user}),
            success:function(fb){
                var r = $.parseJSON(fb);
                console.log(r);
                var headings = '';
                var midh = '';
                if(r.error){
                    midh += '<tr><td>'+r.error+'</td></tr>'; 
                    headings +='<th>Error</th>';
                } else {
                    var x = r.data;                    
                        //headings += '<th>Data</th>';
                        headings +='<th>office_code</th><th>effectivedate</th>';
                        $.each(x,function(k,v){
                            midh += '<tr><td>'+v.office_code+'</td><td>'+v.effectivedate+'</td><tr>';
                        });
                        //midh += '<tr><td>'+r+'<td></tr>';
                }
                
                var htmlc = '<div class="portlet box blue"><div class="portlet-title"><div class="caption"><i class="icon-comments"></i>'+pars.heading+'</div></div><div class="portlet-body">';
                htmlc += '<table id="'+pars.ident+'" class="'+pars.classes+'">';
                htmlc += '<thead><tr>'+headings+'</tr></thead>';
                htmlc += '<tbody>';
                htmlc += midh;
                htmlc += '</tbody></table></div></div>';
                $('table#'+pars.ident+' thead tr').html(headings);
                var test = $('#'+pars.ident+' thead tr').text();
                //console.log(test);
                $(pars.target).html(htmlc);
            }
        });
        
    }
    $.fn.loadUserApps = function(option){
        var tester = $(this).checkLog();
        if(tester == 1){
           var params = $.extend({
                'appid':'',
                'empid':'',
                'URL':'',
                'actions':'',
                'target':''
            },option);
            $.ajax({
                url:params.URL,
                type:'POST',
                dataType:'json',
                data:({LUA:params.actions,applid:params.appid,emplid:params.empid}),
                success:function(fb){
                    var rcv = $.parseJSON(fb);
                    var htmcontent = '<div class="portlet box purple"><div class="portlet-title"><div class="caption"><i class="icon-comments"></i>Current Access Details</div></div><div class="portlet-body">';
                    htmcontent += '<table class="table table-striped table-hover"><thead><tr><th>Module ID</th><th>Readonly</th><th>Can Print</th><th>Action</th></tr></thead><tbody>';
                    $.each(rcv.modules, function(k,v){
                        if(($.isArray(v))){
                            $.each(v, function(l,w){
                                htmcontent += "<tr id='"+w.modid+"'><td>"+w.modid+"</td><td>"+w.readonly+"</td><td>"+w.canprint+"</td><td><a href='#confdeluser' data-toggle='modal' id='DropUserMod_"+w.modid+"' class='dropmodbutton btn red' type='button' data-id='"+w.userid+"'><i class='icon-remove-sign'></i></button></td></tr>";
                            });
                        } else {
                            htmcontent += "<tr id='"+v.modid+"'><td>"+v.modid+"</td><td>"+v.readonly+"</td><td>"+v.canprint+"</td><td><a href='#confdeluser' data-toggle='modal' id='DropUserMod_"+v.modid+"' class='dropmodbutton btn red' type='button' data-id='"+v.userid+"'><i class='icon-remove-sign'></i></button></td></tr>";
                        }
                    });
                    htmcontent += '</tbody></table></div></div>';
                    $('#'+params.target).html(htmcontent);
                    $('.dropmodbutton').on('click',function(){
                        var rowid = $(this).parent().parent().attr('id');
                        var mid = $('#'+rowid+" td").eq(0).text();
                        //var eid = $('#userbox div.modal-body div.row-fluid div.span6 h4').text();
                        var user = $('#userbox div.modal-header').attr('data-id');
                        if((mid != '') || (mid != null)){
                            $('div#confdeluser div.modal-header h3').text('CONFIRM DELETION');
                            $('div#confdeluser div.modal-body p').html('Are you sure you want to remove the module '+mid+' from '+params.empid+'?');
                            $('#delOffBtn').on('click',function(){
                                $.ajax({
                                    url:'./actions.php',
                                    type:'POST',
                                    dataType:'json',
                                    data:({dropusermod:"dropusermod",userid:user,modid:mid}),
                                    success:function(fb){
                                        console.log(fb);
                                        $('div#confdel div.modal-header button.close').trigger('click');
                                        $('div#userbox div.modal-header button.close').trigger('click');
                                        $('#users').load('./users.php');
                                    }
                                });
                            });
                        }            
                    });
                    $("#applicationlist").val(1);
                    $("#applicationlist").trigger('change');
                },
                error:function(){
                    var tester = $(this).checkLog();
                    $(this).showPanel({conf:tester});
                }
            }); 
        } else {
            $(this).showPanel({conf:tester});
        }        
    }
    $.fn.setUp = function(option){
        var params = $.extend({
            'stud_id':'',
            'sem':'',
            'sy':''
        },option);
        $("div#photo img").attr('src','http://x4150idp.msuiit.edu.ph/images/employees/timthumb.php?src='+params.stud_id+'&h=100&w=100&zc=1&q=100');
        $('p#idNumber').html(params.stud_id);
        $('input#studid').val(params.stud_id);
        console.log('setUp!');
        var semNum = params.sem;
        var syDate = params.sy;
        var output = '';
        var studentInfoMain = '';
        var studentInfoOther = '';
        var studentSubjects = '';
        $('input:radio[name=famIncome]').attr('checked',false);
        
        $.ajax({
            url:'./search.php',
            type:'POST',
            dataType:'json',
            async:false,
            data:({action:'get_studentinfo',studid:params.stud_id,sem:semNum,sy:syDate}),
            success:function(feed){
                //console.log(feed);
                if(!feed.error){
                    studentInfoMain = feed.data;
                }
            }
        });
        $.ajax({
            url:'./search.php',
            type:'POST',
            dataType:'json',
            async:false,
            data:({action:'get_studentoinfo',studid:params.stud_id}),
            success:function(feed){
                console.log(feed);
                if(!feed.error){
                    studentInfoOther = feed.data;
                    //$('input#studname').val(feed.data.studfullname);
                }
            }
        });
        var parsed1 = JSON.stringify(studentInfoMain);
        var parsed2 = JSON.stringify(studentInfoOther);
        $.ajax({
            url:'./search.php',
            type:'POST',
            dataType:'json',
            async:false,
            data:({action:'get_studsubjects',studid:params.stud_id,sem:semNum,sy:syDate}),
            success:function(feed){
                console.log(feed);
                if(!feed.error){
                    studentSubjects = feed;
                    //$('input#studname').val(feed.data.studfullname);
                }
            }
        });
        var parsed3 = JSON.stringify(studentSubjects);
        output = '{"main":'+parsed1+',"other":'+parsed2+',"subjects":'+parsed3+'}'; //add subjects here
        return output;
    }
})(jQuery);

