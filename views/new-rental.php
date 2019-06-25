
<?php

error_reporting(0);
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== true){
	header('Location:/login/?logged_in=false');
}

if(isset($_SESSION['housetype'])){
	unset($_SESSION['housetype']);
}
if(isset($_SESSION['commitmentfee'])){
	unset($_SESSION['commitmentfee']);
}
if(isset($_SESSION['monthlyfee'])){
	unset($_SESSION['monthlyfee']);
}
if(isset($_SESSION['housepicture'])){
	unset($_SESSION['housepicture']);
}
if(isset($_SESSION['confirm-details'])){
	unset($_SESSION['confirm-details']);
}

//Database configuration file
$housetype = "";
$commitmentfee = "";
$monthlyfee = "";
$description = "";
if('POST' == $_SERVER['REQUEST_METHOD']){
	include '../api/add_new_rental.php';
}else{
	include '../config/database.php';
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Add rental</title>
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
			<div class="col s12 m12 l12">
				<h1 style="font-size: 1.2rem;color: #333;margin-left: 20px;">Add a new rental below</h1>
				<span class="help-inline" style="margin-left: 20px;">
					<?php
					if(isset($_SESSION['server-error'])){
						echo "<i class='fas fa-exclamation-circle'></i>&nbsp;".$_SESSION['server-error']."<br>";
					}
					unset($_SESSION['server-error']);

					?>
				</span>
				<form class="col s12 m12 l12" enctype="multipart/form-data"  novalidate method="POST" action="/add-rental/">
					<div class="input-field col s12 m4 l4">
						<label for="house-type">Enter house type</label>
						<input type="text" autocomplete="off" value="<?=$housetype;?>" name="house-type" id="house-type">
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
						<label for="comfee">Enter the commitment fee</label>
						<input type="text" value="<?=$commitmentfee;?>" autocomplete="off" name="commitment-fee" id="comfee">
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
						<label for="monthlyfee">Enter the monthly fee</label>
						<input type="text" value="<?=$monthlyfee;?>" autocomplete="off" name="monthly-fee" id="monthlyfee">
						<span class="help-inline">
							<?php
							if(isset($_SESSION['monthly-fee'])){
								echo "<i class='fas fa-exclamation-circle'></i>&nbsp;".$_SESSION['monthly-fee']."";
							}
							unset($_SESSION['monthly-fee']);

							?>
						</span>
					</div>
					<div class="input-field col s12 m4 l4">
						<select class="browser-default" id='location' name="location">
							<option value=""  disabled selected>Select house location</option>
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
									echo "<option value=".$surburb['id'].">".$surburb['name']."</option>";
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
					<div class="input-field col s12 m8 l8">
						<label id="description">Enter a description of the house</label>
						<textarea name="description" class="materialize-textarea" autocomplete="off" id="description"></textarea>
						<span class="help-inline">
							<?php
							if(isset($_SESSION['description'])){
								echo "<i class='fas fa-exclamation-circle'></i>&nbsp;".$_SESSION['description']."";
							}
							unset($_SESSION['description']);

							?>
						</span>
					</div>
					
					<div class="input-field file-field col s12 m12 l12">
						<div class="btn btn-flat paper-button white-text">
							<span>Choose picture</span>
							<input type="file" name="rental-picture">
							<span class="help-inline"></span>
						</div>
						<div class="file-path-wrapper">
        					<input class="file-path validate" type="text">
      					</div>
      					<span class="help-inline">
							<?php
							if(isset($_SESSION['rental-picture-error'])){
								echo "<i class='fas fa-exclamation-circle'></i>&nbsp;".$_SESSION['rental-picture-error']."";
							}
							unset($_SESSION['rental-picture-error']);

							?>
						</span>
					</div>
					<div class="col s12 m12 l12">
						<button type="submit" class="btn btn-flat paper-button white-text" style="background-color: #dd4b39!important;border: none;"><i class="fas fa-paper-plane"></i>&nbsp;Submit</a>
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
<script type="text/javascript">
	$(document).ready(function(){
		$('select').select()
	})
</script>