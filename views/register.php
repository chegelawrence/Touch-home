<?php
//prevent errors from displaying in browser
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Create account</title>
	<link rel="stylesheet" type="text/css" href="/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="/css/semantic.min.css">
	<link rel="stylesheet" type="text/css" href="/css/sweetalert.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro|Google+Sans|Product+Sans|Poppins;' rel='stylesheet' type='text/css'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<link rel="stylesheet" type="text/css" href="/css/font-awesome-4.7.0/css/font-awesome.css">
</head>
<body>
	<?php
		include '../includes/nav.php';


	?>

	<div class="container" style="margin-top: 50px;">
		<div class="row">
			<div class="col s12 m2 l2"></div>
			<div class="col s12 m8 l8">
				<form id="register-form" class="col s12 m12 l12" novalidate>
					<div class="center-align">
						<h1 style="font-size:1.2rem;">Create your account</h1>
					</div>
					<div class="center-align">
						<h2 style="font-size:1.2rem;color:#45A163;" id="status-message">
							
						</h2>
					</div>
					<div class="input-field col s12 m6 l6">
						<label for="firstname">Enter your first name</label>
						<input type="text" name="firstname" autocomplete="off" id="firstname">
						<span class="help-inline" id="fname-error">
							
						</span>
					</div>
					<div class="input-field col s12 m6 l6">
						<label for="lastname">Enter your last name</label>
						<input type="text" name="lastname" autocomplete="off" id="lastname">
						<span class="help-inline" id="lname-error">
							
						</span>
					</div>
					<div class="input-field col s12 m6 l6">
						<label for="username">Username</label>
						<input type="text" name="username" autocomplete="off" id="username">
						<span class="help-inline" id="username-error">
							
						</span>
					</div>
					<div class="input-field col s12 m6 l6">
						<label for="phone">Enter your phone number</label>
						<input type="text" name="phone" autocomplete="off" id="phone">
						<span class="help-inline" id="phone-error">
							
						</span>
					</div>
					<div class="input-field col s12 m6 l6">
						<label for="email">Enter your email address</label>
						<input type="text" name="email" autocomplete="off" id="email">
						<span class="help-inline" id="email-error">
							
						</span>
					</div>
					<div class="input-field col s12 m6 l6">
						<label for="id">Enter your ID number</label>
						<input type="text" name="id-number" autocomplete="off" id="id">
						<span class="help-inline" id="id-error">
							
						</span>
					</div>
					
					<div class="input-field col s12 m6 l6">
						<label for="password">Enter a password</label>
						<input type="password" name="password" autocomplete="off" id="password">
						<span class="help-inline" id="password-error">
							
						</span>
					</div>
					<div class="input-field col s12 m6 l6">
						<label for="cpassword">Confirm the password</label>
						<input type="password" name="cpassword" autocomplete="off" id="cpassword">
						<span class="help-inline" id="cpassword-error">
							
						</span>
					</div>
					<div class="input-field col s12 m12 l12">
						<button class="btn btn-flat paper-button white-text" style="font-size:12px;" type="submit" id="registerBtn">Create account</button>
						<a href="/login/" class="right">Sign in instead</a>
					</div>
				</form>
			</div>
			<div class="col s12 m2 l2"></div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript" src="/libraries/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/libraries/materialize.min.js"></script>
<script type="text/javascript" src="/libraries/sweetalert.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('select').select()
		$('#register-form').submit(function(e){
			$("#registerBtn").html("Submitting...")
			//prevent page from reloading
			e.preventDefault()
			
			//submit form through ajax
			$.ajax({
				method:'POST',
				url:'/forms/register/',
				data:$(this).serialize(),
				dataType:'json',
				success:function(res){
					$("#registerBtn").html("Create account")
					if(res.firstname){
						$('#fname-error').html(res.firstname)
					}else{
						$('#fname-error').html('')
					}
					if(res.lastname){
						$('#lname-error').html(res.lastname)
					}else{
						$('#lname-error').html('')
					}
					if(res.username){
						$('#username-error').html(res.username)
					}else{
						$('#username-error').html('')
					}
					if(res.phone){
						$('#phone-error').html(res.phone)
					}else{
						$('#phone-error').html('')
					}
					if(res.email){
						$('#email-error').html(res.email)
					}else{
						$('#email-error').html('')
					}
					if(res.id){
						$('#id-error').html(res.id)
					}else{
						$('#id-error').html('')
					}
					if(res.password){
						$('#password-error').html(res.password)
					}else{
						$('#password-error').html('')
					}
					if(res.cpassword){
						$('#cpassword-error').html(res.cpassword)
					}else{
						$('#cpassword-error').html('')
					}

					if(res.message){
						$('#status-message').html(res.message)
						$("#register-form")[0].reset()
					}else{
						$('#status-message').html('')
					}
				},
				error:function(ERR){
					$("#registerBtn").html("Create account")
					console.log(ERR)
				}
			})
		})
	})
</script>