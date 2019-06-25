<?php
//prevent errors from displaying in browser
error_reporting(0);
session_start();

$username = "";
$password = "";
if('POST' == $_SERVER['REQUEST_METHOD']){
	include '../api/login.php';
	//echo back to input fields
	$username = htmlentities(trim($_POST['username']));
	$password = htmlentities($_POST['pass']);
}



?>
<!DOCTYPE html>
<html>
<head>
	<title>Log In</title>
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
				<form class="col s12 m12 l12" novalidate method="POST" action="/login/">
					<div class="center-align">
						<h1 style="font-size:1.2rem">Log in to your account</h1>
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
								if(isset($_SESSION['password-error'])){
									echo "<i class='fas fa-exclamation-circle'></i>&nbsp;".$_SESSION['password-error']."<br>";
								}
								unset($_SESSION['password-error']);
							?>
						</span>
						<span class="help-inline">
							<?php
								if(isset($_SESSION['server-error'])){
									echo "<i class='fas fa-warning'></i>&nbsp;".$_SESSION['server-error']."<br>";
								}
								unset($_SESSION['server-error']);
							?>
						</span>

					</div>
					<div class="input-field col s12 m12 l12">
						<label for="username">Enter your email address</label>
						<input type="email" name="username" class="validate" autocomplete="off" id="username" value="<?=$username;?>">
						
					</div>
					<div class="input-field col s12 m12 l12">
						<label for="pass">Enter your password</label>
						<input type="password" name="pass" autocomplete="off" id="pass" value="<?=$password;?>">
					</div>
					<div class="input-field col s12 m12 l12">
						<button class="btn btn-flat paper-button white-text">Sign In</button>
						<a href="/forgot-password/" class="right">Forgot password</a>
					</div>
					<div class="input-field col s12 m12 l12">
						<a href="/register/">Create account</a>
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