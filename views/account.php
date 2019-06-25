
<?php
//prevent errors from displaying in browser
error_reporting(0);
session_start();
if(!isset($_SESSION['user_id'])){
	header('Location:/login/?logged_in=false');
}
include '../config/database.php';
$db = new Database();
$conn = $db->getConnection();
//fetch account details

$query = "SELECT first_name,last_name,email,phone,id_number FROM users WHERE id = ?";

$stmt = $conn->prepare($query);
$stmt->execute(array($_SESSION['user_id']));
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$conn = null;//close connection






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
				<ul class="collection with-header" style="border-radius: 10px;box-shadow: 0 1px 3px 0 #d4d4d5, 0 0 0 0;border: none;">
					<li class="collection-header" style="font-weight: 600;letter-spacing: .0875rem;color: rgba(0,0,0,.6);">
						Account details
						
					</li>
					<li class="collection-item">
						<?php
						echo "<i style='color:rgba(0,0,0,.6);' class='fas fa-user-circle'></i>&nbsp;".$user['first_name']." ".$user['last_name'];
						?>
					</li>
					<li class="collection-item">
						<?php
						echo "<i style='color:rgba(0,0,0,.6);' class='fas fa-envelope'></i>&nbsp;".$user['email'];
						?>
					</li>
					<li class="collection-item">
						<?php
						echo "<i style='color:rgba(0,0,0,.6);' class='fas fa-user-circle'></i>&nbsp;".$user['id_number'];
						?>
					</li>
					<li class="collection-item">
						<?php
						echo "<i style='color:rgba(0,0,0,.6);' class='fas fa-phone'></i>&nbsp;".$user['phone'];
						?>
					</li>
				</ul>
				<a  href="/reset-password/" style="background-color: #dd4b39!important;" class="btn btn-flat btn-large white-text paper-button center-align">
					<i class="fas fa-key"></i>&nbsp;Change password
				</a>
			</div>
			<div class="col s12 m3 l3"></div>
			
		</div>

		
		
		
	</main>
</body>
</html>
<?php
	include '../includes/js.php';
?>