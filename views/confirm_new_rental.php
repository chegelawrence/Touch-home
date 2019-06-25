
<?php
//prevent errors from displaying in browser
error_reporting(0);
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== true){
	header('Location:/login/?logged_in=false');
}
if(!isset($_SESSION['confirm-details'])){
	header('Location:/add-rental/');
}
include '../config/database.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>View added details</title>
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
			/*border:1px solid #e0e0e0*/
		}
		.home-links{
			color: #ee6e73;
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
		<div class="row container">
			<div class="col s12 m2 l2"></div>
			<div class="col s12 m8 l8">
				<p class="center-align">
					<?php
						echo "<img src=".$_SESSION['housepicture']." class='circle' height='100px' width='100px'>";
					?>
				</p>
				<h1 style="font-size: 1.2rem;" class="center-align">The following house has been added</h1>
				<ul class="collection" style="border-radius: 10px;box-shadow: 0 1px 3px 0 #d4d4d5, 0 0 0 0;border: none;">
					<li class="collection-item">
						<?php
							echo "House type - ".$_SESSION['housetype'];
						?>
					</li>
					<li class="collection-item">
						<?php
							$db = new Database();
							$conn = $db->getConnection();
							$query = "SELECT name FROM surburbs WHERE id = ?";
							$stmt = $conn->prepare($query);
							$stmt->execute(array($_SESSION['houselocation']));
							$location = $stmt->fetch(PDO::FETCH_ASSOC);
							echo "House location - ".$location['name'];
							$conn = null;
						?>
					</li>
					<li class="collection-item">
						<?php

							echo "Commitment fee - Ksh ".$_SESSION['commitmentfee'];
						?>
					</li>
					<li class="collection-item">
						<?php
							echo "Monthly fee - Ksh ".$_SESSION['monthlyfee'];
						?>
					</li>
				</ul>
			</div>
			<div class="col s12 m2 l2"></div>
		</div>			
	</main>
</body>
</html>
<?php
	include '../includes/js.php';
?>