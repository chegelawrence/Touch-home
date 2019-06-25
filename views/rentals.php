
<?php
//prevent errors from displaying in browser
error_reporting(0);
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== true){
	header('Location:/login/?logged_in=false');
}
include '../config/database.php';

$tableContent = '';

if('GET' == $_SERVER['REQUEST_METHOD']){
	if(isset($_GET['search']) && strlen(htmlentities(trim($_GET['search']))) != 0){
		//user search for something
		$_SESSION['search-term'] = htmlentities(trim($_GET['search']));
		$tableContent = searchRentals(htmlentities(trim($_GET['search'])));

	}else{

		$tableContent = rentals();

	}
}


function rentals(){
	$tableContent = '';
	$db = new Database();
	$conn = $db->getConnection();
	$query = "SELECT surburbs.name AS house_location,rentals.id AS house_id,commitment_fee,monthly_fee,picture_location,house_type FROM rentals LEFT JOIN surburbs ON rentals.rental_location=surburbs.id";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($rentals as $rental) {
		$resource_link = "/rental/".$rental['house_id']."/";
		# code...
		$tableContent .= "<tr>
		<td style='padding:1px;'><img class='circle' height='50px' width='50px' src=".$rental['picture_location']."></td>
		<td style='padding:1px;'>".$rental['house_type']."</td>
		<td style='padding:1px;'>".$rental['house_location']."</td>
		<td style='padding:1px;'>Ksh ".$rental['commitment_fee']."</td>
		<td style='padding:1px;'>Ksh ".$rental['monthly_fee']."</td>
		<td>
			<a href=".$resource_link." class='btn btn-flat paper-button white-text tooltipped edit-rental' data-tooltip='Edit' style='background-color:#21ba45!important;'><i class='fas fa-pencil-alt'></i></a>
			<button id=".$rental['house_id']." class='btn btn-flat paper-button white-text tooltipped delete-rental' data-tooltip='Delete' style='background-color:#db2828!important;'><i class='fas fa-trash'></i></button>
		</td>
		</tr>";
	}
	$conn = null;

	return $tableContent;
}



function searchRentals($keyword){
	$tableContent = '';
	$keyword .= '%';
	$db = new Database();
	$conn = $db->getConnection();
	$query = "SELECT surburbs.name AS house_location,rentals.id AS house_id,commitment_fee,monthly_fee,picture_location,house_type FROM rentals LEFT JOIN surburbs ON rentals.rental_location=surburbs.id WHERE rentals.house_type LIKE ? OR surburbs.name LIKE ?";
	$stmt = $conn->prepare($query);
	$stmt->execute(array($keyword,$keyword));
	$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if(count($rentals) == 0){
		//no match found
		$tableContent .= "<tr>
								<td colspan='6' class='center-align' style='padding:1px;color:#db2828;font-weight:bold;'>NO MATCH FOUND!!!</td>
								</tr>";
	}

	foreach ($rentals as $rental) {
		$resource_link = '/rental/'.$rental['house_id'].'/';
		# code...
		$tableContent .= "<tr>
								<td style='padding:1px;'><img class='circle' height='50px' width='50px' src=".$rental['picture_location']."></td>
								<td style='padding:1px;'>".$rental['house_type']."</td>
								<td style='padding:1px;'>".$rental['house_location']."</td>
								<td style='padding:1px;'>Ksh ".$rental['commitment_fee']."</td>
								<td style='padding:1px;'>Ksh ".$rental['monthly_fee']."</td>
								<td>
									<a href=".$resource_link." class='btn btn-flat paper-button white-text tooltipped edit-rental' data-tooltip='Edit' style='background-color:#21ba45!important;'><i class='fas fa-pencil-alt'></i></a>
									<button id=".$rental['house_id']." class='btn btn-flat paper-button white-text tooltipped delete-rental' data-tooltip='Delete' style='background-color:#db2828!important;'><i class='fas fa-trash'></i></button>
								</td>
								</tr>";

	}


	$conn = null;

	return $tableContent;
}



?>

<!DOCTYPE html>
<html>
<head>
	<title>Rentals</title>
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
				<form novalidate method="GET" action="/rentals/">
					<div class="input-field col s12 m4 l4 left">
						<input autocomplete="off" type="text" name="search" style="border-radius: 50px;height: 35px;" placeholder="Search by house location or house type">
					</div>
				</form>
				<br>
				<a href="/add-rental/" class="btn btn-flat paper-button white-text right" style="background-color: #dd4b39!important;border: none;margin-right: 20px;"><i class="fas fa-plus"></i>&nbsp;Add rental</a>
			</div>
		</div>
		<div class="row">
			<!--display rentals here-->
			<div class="col s12 m12 l12">
				<table class="bordered highlight">
					<thead>
						<tr>
							<th></th>
							<th>House Type</th>
							<th>Location</th>
							<th>Commitment Fee</th>
							<th>Monthly Fee</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<!--fetch rentals from the database-->
						<?php
							echo $tableContent;
						?>
					</tbody>
				</table>
				<br>
				<?php
			      if(isset($_SESSION['search-term']) && $_SESSION['search-term'] != ''){
			        echo "<a class='btn btn-flat paper-button white-text' href='/rentals/'><i class='fas fa-times'></i>&nbsp;Cancel</a>";
			      }
			      unset($_SESSION['search-term']);
			     ?>
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
		$('.delete-rental').on('click',function(event){
			swal({
	            title: "Are you sure?",
	            text: "This book will be deleted!",
	            type: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Yes",
	            closeOnConfirm: false
	          },
	          function(){
	            $target = $(event.target)
				const id = $target.attr('id')

	            $.ajax({
					type:'POST',
					url:'http://localhost/api/delete_rental.php/',
					data:{"rental_id":id,"token":"delete_rental"},
					dataType:'json',
					success:function(res){
						console.log(res)
						alert(res.message)
						location.reload()
					},
					error:function(err){
						console.log(err)
						swal('Error','An error occured.Try again later','error')
					}
				})
	            
	          });




			
		})
	})
</script>