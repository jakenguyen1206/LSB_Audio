<!DOCTYPE html>
<html lang="vi">
<?php
  error_reporting(0);
  date_default_timezone_set('asia/ho_chi_minh');
  if (!isset($_SESSION)) session_start();
  if (isset($_SESSION['user'])){
    unset($_SESSION['guesttoken']);
    header('location: index.php');
  }
  else{
    if (!isset($_SESSION['guesttoken'])){
      $_SESSION['guesttoken'] = bin2hex(random_bytes(16));
    }
    include "connectdb.php";
    $qr = $conn->prepare("select siteinfo.companyname as companyname, siteinfo.slogan as slogan, siteinfo.seokeywords as seokeywords, siteinfo.seodescription as seodescription, multimedia.url as logo from siteinfo, multimedia where siteinfo.logo = multimedia.id limit 1;");
    $qr->execute();
    $rs_siteinfo = $qr->fetch();
  }
?>

<head>
  <title><?php echo ($rs_siteinfo['companyname']) . " | " . ($rs_siteinfo['slogan']); ?></title>
  <link href="<?php echo ($rs_siteinfo['logo']); ?>" type="image/png" rel="shortcut icon" />
  <meta name="keywords" content="<?php echo ($rs_siteinfo['seokeywords']); ?>" />
  <meta name="description" content="<?php echo ($rs_siteinfo['seodescription']); ?>" />
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
  <style>
	body { font-family: 'Open Sans', sans-serif;}
	html,body{ height: 100%;}
	.center-of-screen{
	  position: fixed;
	  top: 50%;
	  left: 50%;
	  transform: translate(-50%, -50%);
	}
	.center{
		text-align: center;
	}
	#opacity-screen{
	  width: 100%; height: 100%;
	  position: fixed; z-index: 1001;
	  top: 0px; left: 0px;
	  padding: 0px; margin: 0px;
	  background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('picture/bg-login.jpg');
	  background-size: cover;
	}
	#bg-login{
	  position: absolute; z-index: 10;
	  left: 0px; top: 0px;
	  width: 100%; height: 100%;
	  display: none;
	}
	.panel{ padding: 0px; border: none;}
	#loginbox .panel-heading{ background-color: #50B948;}
	#signupbox .panel-heading{ background-color: #DD5347;}
	.panel-title{ font-size: 20px; font-weight: bold; color: white;}
	.panel-body{ padding-top: 30px !important;}
	.btn{ padding: 5px 10px;}
	.btn i{ margin-right: 5px; }
  </style>
</head> 

<body data-spy="scroll" data-target=".navbar" data-offset="60">
	<div id="opacity-screen">
		<img id="bg-login" src="picture/bg-login.jpg">
    	<input type="text" id="guest-token" value="<?php echo $_SESSION['guesttoken']; ?>" hidden="true"></input>
	  	<div id="loginbox" class="mainbox center-of-screen col-lg-4 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-8 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	    	<div class="panel panel-info">
	      		<div class="panel-heading">
	        		<div class="panel-title">SIGN IN</div>
	      		</div>
	      		<div style="padding-top: 30px" class="panel-body">
	        		<div id="loginform" class="form-horizontal" rule="form">
	          			<div style="margin-bottom: 25px;" class="input-group">
	            			<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            				<input id="login-id" type="text" class="form-control" value="" placeholder="Username" required></input>
	          			</div>
	          			<div style="margin-bottom: 25px;" class="input-group">
	            			<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
	            			<input id="login-pw" type="password" class="form-control" placeholder="Password" required></input>
	          			</div>
	          			<div style="margin-top: 10px" class="form-group">
	            			<div class="center col-md-12 col-xs-12 controls">
	              				<button id="login-btn" class="btn btn-success"><i class="fa fa-sign-in"></i> Sign in</button>
	            			</div>
	          			</div>
	          			<div class="form-group">
	            			<div class="col-md-12 col-xs-12 control">
	              				<div style="border-top: 1px solid #888; padding-top: 15px; font-size: 85%" ><a href="#signupbox" onClick="$('#loginbox').hide(); $('#signupbox').show()">Go to SIGN UP</a>
	              				</div>
		            		</div>
		          		</div>
		        	</div>
		      	</div>
		    </div>
		</div>
  		<div id="signupbox" style="display: none;" class="mainbox center-of-screen col-lg-4 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-8 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	    	<div class="panel panel-info">
	      		<div class="panel-heading">
	        		<div class="panel-title">SIGN UP</div>
	      		</div>
	      		<div class="panel-body" >
	        		<div id="signupform" class="form-horizontal" role="form">
            			<div style="margin-bottom: 25px;" class="input-group">
				            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				            <input id="signup-id" type="text" class="form-control" value="" placeholder="Username" required></input>
	          			</div>
			            <div style="margin-bottom: 25px;" class="input-group">
				            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
				            <input id="signup-pw" type="password" class="form-control" value="" placeholder="Password" required></input>
		          		</div>
						<div class="form-group">
						  	<div class="center col-md-12 col-xs-12 control">
						      	<button id="signup-btn" type="button" class="btn btn-danger"><i class="glyphicon glyphicon-send"></i> Sign up</button>
		              		</div>
		          		</div>
						<div class="form-group">
							<div class="col-md-12 col-xs-12 control">
								<div style="border-top: 1px solid #888; padding-top: 15px; font-size: 85%" ><a href="#loginbox" onclick="$('#signupbox').hide(); $('#loginbox').show()">Go back to SIGN IN</a>
							  	</div>
							</div>
						</div>
	        		</div>
	      		</div>
	    	</div>
	  	s</div>
	</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
	$("#login-id").focus(function(){
	  $(this).css('border-color','');
	});

	$("#login-id").blur(function(){
	  if (!/^[a-zA-Z][a-zA-Z0-9_]{4,}$/.test($(this).val())) $(this).css('border-color','#D52349');
	  else $(this).css('border-color','#50B948');
	});

	$("#login-pw").focus(function(){
	  $(this).css('border-color','');
	});

	$("#login-pw").blur(function(){
	  if ($(this).val().length<5)  $(this).css('border-color','#D52349');
	  else $(this).css('border-color','#50B948');
	});
	$("#login-btn").click(function(){
	  var id = $("#login-id").val().toLowerCase();
	  var pw = $("#login-pw").val();
	  var guesttoken = $("#guest-token").val();	
	  if (/^[a-zA-Z][a-zA-Z0-9_]{4,}$/.test(id) && pw.length >= 5){
	    $.ajax({
	      url: "auth.php",
	      method: "post",
	      data: { loginbtn : "true", guesttoken : guesttoken, loginid : id, loginpw : pw},
	      success : function(response){
	        if (response == "login success"){
	          window.location="";
	        }
	        else if (response == "login failure"){
	          alert("Incorrect Username Password! Please, Try again!!!");
	          window.location="";
	        }
	      }
	    });
	  }
	});

	$("#signup-id").focus(function(){
	  $(this).css('border-color','');
	});

	$("#signup-id").blur(function(){
	  if (!/^[a-zA-Z][a-zA-Z0-9_]{4,}$/.test($(this).val())) $(this).css('border-color','#D52349')
	  else $(this).css('border-color','#50B948');
	});

	$("#signup-pw").focus(function(){
	  $(this).css('border-color','');
	});

	$("#signup-pw").blur(function(){
	  if ($(this).val().length<5)  $(this).css('border-color','#D52349');
	  else $(this).css('border-color','#50B948');
	});

	$("#signup-btn").click(function(){
	  $("*").css("cursor", "wait");
	  var id = $("#signup-id").val().toLowerCase();
	  var pw = $("#signup-pw").val();
	  var guesttoken = $("#guest-token").val();
	  /*Set up ID va Password when Sign Up*/
	  if (/^[a-zA-Z][a-zA-Z0-9_]{4,}$/.test(id) && pw.length>=5){
	    $.ajax({
	      url: "auth.php",
	      type: "POST",
	      data: { signupbtn : "true", guesttoken : guesttoken, signupid : id, signuppw : pw},
	      success : function(response){
	      	$("*").css("cursor", "default");
	        if (response == "signup success"){
	          alert("Sign Up Success!");
	          window.location="";
	        }
	        else if (response == "signup failure"){
	          alert("Error! Try again.");
	          window.location="";
	        }
	      }
	    });
	  }
	});
</script>
</body>
</html>
