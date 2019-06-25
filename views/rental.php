<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== true){
	header('Location:/login/?logged_in=false');
}
if(!isset($_REQUEST['rental'])){
	header('Location:/admin/');
}

include '../config/database.php';

$db = new Database();
$conn = $db->getConnection();

$query = "SELECT * FROM rentals WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute(array(htmlentities(trim($_REQUEST['rental']))));
$rental = $stmt->fetch(PDO::FETCH_ASSOC);

if('POST' == $_SERVER['REQUEST_METHOD']){
	//EDIT RENTAL mahn!!!
	$housetype = htmlentities(trim($_POST['house-type']));
	$commitmentfee = htmlentities(trim($_POST['commitment-fee']));
	$monthlyfee = htmlentities(trim($_POST['monthly-fee']));
	$location = "";
	if(!isset($_POST['location'])){
	$_SESSION['location'] = 'Select this field';
	$response['location'] = 'Select this field';
	}else{
		$location = htmlentities(trim($_POST['location']));
	}
	$description = htmlentities(trim($_POST['description']));
	$response = [];
	if(strlen($housetype) == 0){
		$_SESSION['house-type'] = 'Enter the type of the house';
		$response['house-type'] = 'Enter the type of the house';
	}

	if(strlen($description) == 0){
		$_SESSION['description'] = 'Enter a house description';
		$response['description'] = 'Enter a house description';
	}
	if(strlen($commitmentfee) == 0){
		$_SESSION['commitment-fee'] = 'Enter the commitment fee';
		$response['commitment-fee'] = 'Enter the commitment fee';
	}else{
		if(!is_numeric($commitmentfee)){
			$_SESSION['commitment-fee'] = 'This field must be a number';
			$response['commitment-fee'] = 'must be a number';
		}
	}
	if(strlen($location) == 0){
		$_SESSION['location'] = 'Select this field';
		$response['location'] = 'Select this field';
	}
	if(strlen($monthlyfee) == 0){
		$_SESSION['monthly-fee'] = 'Enter the monthly fee';
		$response['monthly-fee'] = 'Enter the monthly fee';
	}else{
		if(!is_numeric($monthlyfee)){
			$_SESSION['monthly-fee'] = 'This field must be a number';
			$response['commitment-fee'] = 'must be a number';
		}
	}


	if(empty($response)){
		//rental details are valid
		//continue saving to database
		$query = "UPDATE rentals SET house_type = ?,rental_location = ?,commitment_fee = ?,monthly_fee = ?,house_description = ? WHERE id = ?";
		$stmt = $conn->prepare($query);
		$conn->beginTransaction();
		try{
			$stmt->execute(array(ucfirst($housetype),$location,$commitmentfee,$monthlyfee,ucwords($description),htmlentities(trim($_REQUEST['rental']))));
			$conn->commit();
			//success editing resource
			header('location:/rentals/');

		}catch(PDOException $e){
			error_log($e->getMessage());
			$conn->rollback();
			$_SESSION['server-error'] = 'Critical server error.We are looking into that.Try again';
		}
	}

}

$conn = null;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Rental</title>
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
	
			<div class="col s12 m3 l3">
				<p class="center-align">
					<?php
						echo "<img class='circle' height='100px' width='100px' src='/".$rental['picture_location']."'>" ;
					?>
				</p>
			</div>
			<div class="col s12 m9 l9">
				<span class="help-inline" style="margin-left: 20px;">
					<?php
					if(isset($_SESSION['server-error'])){
						echo "<i class='fas fa-exclamation-circle'></i>&nbsp;".$_SESSION['server-error']."<br>";
					}
					unset($_SESSION['server-error']);

					?>
				</span>
				<form class="col s12 m12 l12" novalidate method="POST" action="">
					<div class="input-field col s12 m4 l4">
						<label for="house-type">House type</label>
						<input type="text" autocomplete="off" value="<?=$rental['house_type'];?>" name="house-type" id="house-type">
						<span class="help-inline">
							<?php
							if(isset($_SESSION['house-type'])){
								echo "<i class='fas fa-exclamation-circle'></i>&nbsp;".$_SESSION['house-type']."";
							}
							unset($_SESSION['house-type']);

							?>
						</span>
					</div>
					<div class="input-field col s12 m4 l4">
						<label for="comfee">Commitment fee</label>
						<input type="text" value="<?=$rental['commitment_fee'];?>" autocomplete="off" name="commitment-fee" id="comfee">
						<span class="help-inline">
							<?php
							if(isset($_SESSION['commitment-fee'])){
								echo "<i class='fas fa-exclamation-circle'></i>&nbsp;".$_SESSION['commitment-fee']."";
							}
							unset($_SESSION['commitment-fee']);

							?>
						</span>
					</div>
					<div class="input-field col s12 m4 l4">
						<label for="monthlyfee">Monthly fee</label>
						<input type="text" value="<?=$rental['monthly_fee'];?>" autocomplete="off" name="monthly-fee" id="monthlyfee">
						<span class="help-inline">
							<?php
							if(isset($_SESSION['monthly-fee'])){
								echo "<i class='fas fa-exclamation-circle'></i>&nbsp;".$_SESSION['monthly-fee']."";
							}
							unset($_SESSION['monthly-fee']);

							?>
						</span>
					</div>
					<div class="input-field col s12 m6 l6">
						<select class="browser-default" id='location' name="location">
							<?php
								//fetch surburbs
								$db = new Database();
								$conn = $db->getConnection();
								//fetch data and create a dropdown menu
								$query = "SELECT * FROM surburbs";
								$stmt = $conn->prepare($query);
								$stmt->execute();
								//FETCH AS AN ASSOCIATIVE ARRAY
								$surburbs = $stmt->fetchAll(PDO::FETCH_ASSOC);
								foreach($surburbs as $surburb){
									if($surburb['id'] == $rental['rental_location']){
										//select the location
										echo "<option selected value=".$surburb['id'].">".$surburb['name']."</option>";
									}else{
										echo "<option value=".$surburb['id'].">".$surburb['name']."</option>";
									}
								}
								$conn = null;//close database connection
								
							?>
						</select>
						<span class="help-inline">
							<?php
							if(isset($_SESSION['location'])){
								echo "<i class='fas fa-exclamation-circle'></i>&nbsp;".$_SESSION['location']."";
							}
							unset($_SESSION['location']);

							?>
						</span>
					</div>
					<div class="input-field col s12 m6 l6">
						<label id="description">House description</label>
						<textarea class="materialize-textarea" name="description" autocomplete="off" id="description">
							<?php echo trim($rental['house_description']);?>
						</textarea>
						<span class="help-inline">
							<?php
							if(isset($_SESSION['description'])){
								echo "<i class='fas fa-exclamation-circle'></i>&nbsp;".$_SESSION['description']."";
							}
							unset($_SESSION['description']);

							?>
						</span>
					</div>
					<div class="input-field col s12 m12 l12">
						<button type="submit" class="btn btn-flat paper-button white-text">Save</button>
					</div>
				</form>
			</div>
			
		</div>
	</main>
</body>
</html>

<?php
	include '../includes/js.php';
?>