<?php
//prevent errors from displaying in browser
error_reporting(0);
session_start();

$username = "";
$password = "";
if('POST' == $_SERVER['REQUEST_METHOD']){
	include '../api/forgot_password.php';
	//echo back to input fields
	$response = [];
	$email = htmlentities(trim($_POST['username']));
	if(strlen($email) == 0){
		$_SESSION['username-error'] = "This field is required";
		$response['email'] = "This field is required";
	}else{
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$_SESSION['username-error'] = "Invalid email address";
			$response['email'] = "Invalid email address";
		}
	}
	if(empty($response)){
		forgotPassword($email);
	}
}



?>
<!DOCTYPE html>
<html>
<head>
	<title>Forgot password</title>
	<link rel="stylesheet" type="text/css" href="/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="/css/semantic.min.css">
	<link rel="stylesheet" type="text/css" href="/css/sweetalert.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro|Google+Sans|Product+Sans|Poppins' rel='stylesheet' type='text/css'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<link rel='stylesheet' type='text/css' href='/css/fontawesome/css/all.min.css'>
</head>
<body>
	<?php
		include '../includes/nav.php';


	?>

	<div class="container" style="margin-top: 50px;">
		<div class="row">
			<div class="col s12 m3 l3"></div>
			<div class="col s12 m6 l6">
				<form class="col s12 m12 l12" novalidate method="POST" action="/forgot-password/">
					<div class="center-align">
						<h1 style="font-size:1.2rem"><i class="fas fa-key fa-2x"></i>&nbsp;Request password reset</h1>
					</div>
					<div class="col s12 m12 l12">
						<span class="help-inline">
							<?php
								if(isset($_SESSION['username-error'])){
									echo "<i class='fas fa-exclamation-circle'></i>&nbsp;".$_SESSION['username-error']."<br>";
								}
								unset($_SESSION['username-error']);
							?>
						</span>
						<span class="help-inline">
							<?php
								if(isset($_SESSION['server-error'])){
									echo "<i class='fas fa-exclamation-triangle'></i>&nbsp;".$_SESSION['server-error']."<br>";
								}
								unset($_SESSION['server-error']);
							?>
						</span>
						<span class="help-inline">
							<?php
								if(isset($_SESSION['user-not-found'])){
									echo "<i class='fas fa-exclamation-triangle'></i>&nbsp;".$_SESSION['user-not-found']."<br>";
								}
								unset($_SESSION['user-not-found']);
							?>
						</span>
						<span class="help-inline" style="color: green;">
							<?php
								if(isset($_SESSION['password-reset-message'])){
									echo "<i class='fas fa-check'></i>&nbsp;".$_SESSION['password-reset-message']."<br>";
								}
								unset($_SESSION['password-reset-message']);
							?>
						</span>

					</div>
					<div class="input-field col s12 m12 l12">
						<label for="username">Enter your email address</label>
						<input type="email" name="username" class="validate" autocomplete="off" id="username" value="<?=$username;?>">
						
					</div>
					<div class="input-field col s12 m12 l12">
						<button class="btn btn-flat paper-button white-text">Reset password</button>
						<a href="/login/" class="right">Sign in instead</a>
					</div>
				</form>
			</div>
			<div class="col s12 m3 l3"></div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript" src="/libraries/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/libraries/materialize.min.js"></script>
<script type="text/javascript" src="/libraries/sweetalert.min.js"></script>