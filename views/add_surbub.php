
<?php
//prevent errors from displaying in browser
error_reporting(0);
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== true){
	header('Location:/login/?logged_in=false');
}
$surburb = "";
if('POST' == $_SERVER['REQUEST_METHOD']){
	$surburb = htmlentities(trim($_POST['surburb']));
	include '../api/new_surburb.php';
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>New surburb</title>
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
			<div class="col s12 m2 l2"></div>
			<div class="col s12 m8 l8">
				<h1 style="font-size:1.2rem" class="center-align">Enter the surburb name below and click submit</h1>
				<form class="col s12 m12 l12" method="POST" action='/new-surburb/'>
					<div class="input-field col s12 m12 l12">
						<span class="help-inline">
							<?php
							if(isset($_SESSION['server-error'])){
								echo "<i class='fa fa-warning'></i>&nbsp;".$_SESSION['server-error']."<br>";
							}
							unset($_SESSION['server-error']);

							?>
						</span>
						<div class="alert alert-success">
							<?php
							if(isset($_SESSION['location-add-success'])){
								echo "<i class='fa fa-check'></i>&nbsp;".$_SESSION['location-add-success']."<br>";
							}
							unset($_SESSION['location-add-success']);

							?>
						</div>
						<input type="text" name="surburb" autocomplete="off" placeholder="Enter the surbub name">
						<span class="help-inline">
							<?php
							if(isset($_SESSION['surburb'])){
								echo "<i class='fa fa-exclamation-circle'></i>&nbsp;".$_SESSION['surburb']."<br>";
							}
							unset($_SESSION['surburb']);

							?>
						</span>
					</div>
					<div class="input-field col s12 m12 l12">
						<button class="btn btn-flat paper-button white-text">Submit</button>
					</div>
				</form>
			</div>
			<div class="col s12 m2 l2"></div>
		</div>
	</main>
</body>
</html>
<?php
	include '../includes/js.php';
?>