<?php
ob_start();
session_start();
require("./classes/caller.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>MSU-IIT Web eSMS</title>
    <!-- Sets initial viewport load and disables zooming  -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- SmartAddon.com Verification -->
    <meta name="smartaddon-verification" content="936e8d43184bc47ef34e25e426c508fe" />
    <link rel="shortcut icon" href="favicon_16.ico"/>
    <link rel="bookmark" href="favicon_16.ico"/>
    <!-- site css -->
    <link rel="stylesheet" href="css/site.min.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery.gritter.css" />
    <link rel="stylesheet" href="./css/main.css" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700,400italic,600italic,700italic,800italic,300italic" rel="stylesheet" type="text/css">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="./js/site.min.js"></script>
    <script type="text/javascript" src="./js/bootbox.js"></script>
    <script type="text/javascript" src="js/jquery.gritter.js"></script>
  </head>
  <body class="index" style="background-color:#AAB2BD;">
<?php
$appcall = new Caller($config);
if(isset($_SESSION['token']) && (isset($_SESSION['empid']) &&($_SESSION['token'] != ''))){
	echo "You are already logged in. Click here to <a href='./logout.php'>log out</a>.";
	header("location:./index.php");
} else {
?>
<div class="container-fluid">
  <div class="row">
  	<h2></h2>
  	<div class="col-sm-4 col-sm-offset-4">
  		<div class="panel panel-danger">
  			<!-- <form action="./logme.php" method="POST" name="loginForm"> -->
	  			<div class="panel-heading grey-dark" style="text-align:center;">
	  				
	  			</div>
	  			<div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12" style="text-align:center;">
                                            <img src="./img/logo-iit-login.png" width="219" height="219" alt="Welcome to MSU-IIT web eSMS!" />
                                        </div>
                                    </div>
		  				<div class="row" style="text-align:center;">
			  				<div class="col-xs-10 col-xs-offset-1"><input type="text" id="login-main" name="logname" class="col-xs-12" placeholder="Enter username" /></div>
			  			</div>
			  			<br />
			  			<div class="row" style="text-align:center;">
			  				<div class="col-xs-10 col-xs-offset-1"><input type="password" id="pass-main" name="passname" class="col-xs-12" placeholder="Enter password" /></div>
		  				</div>

	  			</div>
	  			<div class="panel-footer">
	  				<div class="row">
	  					<div class="col-xs-6 col-xs-offset-3">
	  						<button type="submit" id="submt-main" name="sbmtlogin" class="btn btn-warning col-xs-12" style="font-weight:bold;color:#333;">Log In</button>
	  					</div>
	  				</div>
	  			</div>
  			<!-- </form> -->
  		</div>
  	</div>
  </div>
</div>
<script type="text/javascript" src="./js/plugins.js"></script>
<script type="text/javascript">
$(document).ready(function(){

});
/*
$('input#login-main').keypress(function(b){
	var key = b.which;
	if(key == 13){
		$('input#pass-main').focus();
		return false;
	}
});
*/
$('input#pass-main').keypress(function(c){
	$('input#login-main').off('keypress');
	var key = c.which;
	if(key == 13){
		$('#submt-main').trigger('click');
		return false;
	}
});

	$('button#submt-main').on('click', function(e){		
		e.preventDefault();
		var usern = $('input#login-main').val();
		var passw = $('input#pass-main').val();
		var access = $(this).logMe({
			username:usern,
			password:passw
		});
		var textm = "Sorry, but the system doesn't recognize you. Please check if your <b>login details</b> are correct, and if you still aren't recognized, <b>check your network</b>.";
		if(access == 1){
			textm = "Login Successful. Welcome, <b>"+usern+"</b>!";
			window.setTimeout(function() {
		    	window.location.href = './index.php';
			}, 1000);
		} else if (access == 2){
			textm = "Sorry, "+usern+", but the system declares you are not authorized to use this app.";
		}
		$.gritter.add({
            title:'SYSTEM LOG:',
            text:textm,
            class_name:'gritter-sunflower',
            sticky:false
        });
	});
</script>
<?php
}
//include("./footer.php");
?>
</body>
</html>