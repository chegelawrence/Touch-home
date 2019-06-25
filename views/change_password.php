
<?php
//prevent errors from displaying in browser
error_reporting(0);
session_start();
if(!isset($_SESSION['user_id'])){
	header('Location:/login/?logged_in=false');
}

if('POST' == $_SERVER['REQUEST_METHOD']){
	$response = [];
	include '../config/database.php';
	//change password;
	$password = htmlentities($_POST['current-password']);
	$newpassword = htmlentities($_POST['new-password']);
	$confirmpassword = htmlentities($_POST['confirm-password']);

	if(strlen($password) == 0){
		$_SESSION['password'] = 'Enter your password';
		$response['password'] = true;
	}else{
		$db = new Database();
		$conn = $db->getConnection();
		$query = "SELECT password FROM users WHERE id = ?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($_SESSION['user_id']));
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		$conn = null;
		if(!password_verify($password,$res['password'])){
			$_SESSION['password'] = 'Your current password is not correct';
			$response['password'] = true;
		}
	}
	if(strlen($newpassword) == 0){
		$_SESSION['new-password'] = 'Enter your new password';
		$response['new-password'] = true;
	}else{
		if(strlen($confirmpassword) == 0){
			$_SESSION['new-password'] = 'Confirm the new password';
			$response['new-password'] = true;
		}else{
			if(strcmp($newpassword, $confirmpassword) != 0){
				//passwords do not match
				$_SESSION['new-password'] = 'The passwords do not match';
				$response['new-password'] = true;
			}
		}
	}

	if(empty($response)){
		//no errors
		$db = new Database();
		$conn = $db->getConnection();
		$query = "UPDATE users SET password = ? WHERE id = ?";
		$stmt = $conn->prepare($query);
		$conn->beginTransaction();
		try{
			$stmt->execute(array(password_hash($newpassword,PASSWORD_BCRYPT),$_SESSION['user_id']));
			$conn->commit();
			$_SESSION['password-updated'] = 'Your password has been updated';

		}catch(PDOException $e){
			//error changing password
			$conn->rollback();
			$_SESSION['server-error'] = 'Critical server.We are looking into that.Try again later';


		}
		$conn = null;
	}




}









?>

<!DOCTYPE html>
<html>
<head>
	<title>My account</title>
	<?php
		include '../includes/css.php';
	?>
	<style type="text/css">
		#slide-out{
			width:200px!important;
		}
		header,main,footer{
			padding-left:200px;
		}
		@media only screen and(max-width: 992px;){
			header,main,footer{
				padding-left:0;
			}	
		}
		.card-small{
			border:1px solid #e0e0e0
		}
	</style>
</head>
<body>
	<header>
		<?php
			include '../includes/nav.php';
		?>
	</header>
	<?php
		include '../includes/side-nav.php';
	?>
	<main>
		<br>
		<div class="row">
			<div class="col s12 m3 l3"></div>
			<div class="col s12 m6 l6">
				<h2 style="font-size: 1.2rem;" class="center-align">Change password</h2>
				<form novalidate method="POST" action="/reset-password/">
					<div class="input-field col s12 m12 l12">
						<span class="help-inline">
							<?php
							if(isset($_SESSION['server-error'])){
								echo "<i class='fa fa-warning'></i>&nbsp;".$_SESSION['server-error']."";
							}
							unset($_SESSION['server-error']);

							?>
						</span>
						<span class="alert alert-success">
							<?php
							if(isset($_SESSION['password-updated'])){
								echo "<i class='fa fa-check'></i>&nbsp;".$_SESSION['password-updated']."";
							}
							unset($_SESSION['password-updated']);

							?>
						</span>
					</div>
					<div class="input-field col s12 m12 l12">
						<label for="current-password">Current password</label>
						<input type="password" name="current-password" id="current-password">
						<span class="help-inline">
							<?php
							if(isset($_SESSION['password'])){
								echo "<i class='fa fa-exclamation-circle'></i>&nbsp;".$_SESSION['password']."";
							}
							unset($_SESSION['password']);
							?>
						</span>
					</div>
					<div class="input-field col s12 m6 l6">
						<label for="new-password">New password</label>
						<input type="password" name="new-password" id="new-password">
						<span class="help-inline">
							<?php
							if(isset($_SESSION['new-password'])){
								echo "<i class='fa fa-exclamation-circle'></i>&nbsp;".$_SESSION['new-password']."";
							}
							unset($_SESSION['new-password']);
							?>
						</span>
					</div>
					<div class="input-field col s12 m6 l6">
						<label for="confirm-password">Confirm password</label>
						<input type="password" name="confirm-password" id="confirm-password">
					</div>
					<div class="input-field col s12 m12 l12">
						<button type="submit" class="btn btn-flat paper-button white-text"><i class="fas fa-paper-plane"></i>&nbsp;Submit</button>
					</div>
				</form>
			</div>
			<div class="col s12 m3 l3"></div>
			
		</div>

		
		
		
	</main>
</body>
</html>
<?php
	include '../includes/js.php';
?>