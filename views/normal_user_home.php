
<?php
//prevent errors from displaying in browser
//error_reporting(0);
session_start();
if(!isset($_SESSION['user_id'])){
	header('Location:/login/?logged_in=false');
}

include "../config/database.php";

$pageno = "";
if(isset($_GET['page'])){
	$pageno = htmlentities(trim($_GET['page']));
}else{
	$pageno = 1;
}

$no_of_records_per_page = 6;
$offset = ($pageno-1) * $no_of_records_per_page; 

$sql = "SELECT COUNT(*) AS pages FROM rentals";
$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->prepare($sql);
$stmt->execute();
$res = $stmt->fetch(PDO::FETCH_ASSOC);

$total_rows = $res['pages'];
$total_pages = ceil($total_rows / $no_of_records_per_page);
$stmt = null;
$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<?php
		include '../includes/css.php';
	?>
	<style type="text/css">
		
		.card-small{
			/*border:1px solid #e0e0e0*/
		}
		.home-links{
			color: #ee6e73;
		}
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
		<div class="row" style="margin-top: -20px;">
			<div class="col s12 m6 l6">
				<form novalidate method="GET" action="">
					<div class="input-field col s12 m8 l8">
						<h1 style="font-size: 22px;">Filter results by house location</h1>
						<select name="location" class="browser-default">
							<option selected disabled>Choose house location</option>
							<?php
								$query = "SELECT * FROM surburbs";
								$db = new Database();
								$conn = $db->getConnection();
								$stmt = $conn->prepare($query);
								$stmt->execute();
								$locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
								$stmt = null;
								$conn = null;
								foreach ($locations as $location) {
									# code...
									echo "<option value=".$location['id'].">".$location['name']."</option>";
								}

							?>
						</select>
						<div class="input-field col s12 m4 l4">
							<button class="btn btn-flat paper-button white-text"><i class='fas fa-search'></i>&nbsp;Search</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<br>
		<?php
		if(isset($_GET['location'])){
			echo "<div class='row'>";
			
			$db = new Database();
			$conn = $db->getConnection();
			$query = "SELECT surburbs.name AS house_location,rentals.id AS house_id,commitment_fee,monthly_fee,picture_location,house_type,house_description FROM rentals LEFT JOIN surburbs ON rentals.rental_location=surburbs.id WHERE rentals.rental_location=? LIMIT ".$offset.",".$no_of_records_per_page."";
			$stmt = $conn->prepare($query);
			$stmt->execute(array(htmlentities(trim($_GET['location']))));
			$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$conn = null;//close database connection

			foreach ($rentals as $rental) {
				$book_link = "/book/".$rental['house_id']."/";
				echo "<div class='col s12 m3 l4'>
						<div class='card large'>
						<div class='card-image'><img class='materialboxed' width='650' src=".$rental['picture_location']."></div>
						<span class='card-title' style='padding-left:20px;font-size:1.2rem;color:#212121;'>".$rental['house_type']." in ".$rental['house_location']."</span>
						<div class='card-content' style='color:#5f6368;font-size:14px;'>".$rental['house_description']."</div>
						<div class='card-action'>
							
							<a href=".$book_link." class='btn btn-flat bookBtn tooltipped right white-text bookBtn' style='background-color:#FF5A5F!important;text-transform:none;' data-tooltip='Click to book this house'>Book</a>
						</div>
					</div>
				</div>";

			}

			echo "</div>";

		}else{
			echo "<div class='row'>";
			
			$db = new Database();
			$conn = $db->getConnection();
			$query = "SELECT surburbs.name AS house_location,rentals.id AS house_id,commitment_fee,monthly_fee,picture_location,house_type,house_description FROM rentals LEFT JOIN surburbs ON rentals.rental_location=surburbs.id LIMIT ".$offset.",".$no_of_records_per_page."";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$conn = null;//close database connection

			foreach ($rentals as $rental) {
				$book_link = "/book/".$rental['house_id']."/";
				echo "<div class='col s12 m3 l4'>
						<div class='card large'>
						<div class='card-image'><img class='materialboxed' width='650' src=".$rental['picture_location']."></div>
						<span class='card-title' style='padding-left:20px;font-size:1.2rem;color:#212121;'>".$rental['house_type']." in ".$rental['house_location']."</span>
						<div class='card-content' style='color:#5f6368;font-size:14px;'>".$rental['house_description']."</div>
						<div class='card-action'>
							
							<a href=".$book_link." class='btn btn-flat bookBtn tooltipped right white-text bookBtn' style='background-color:#FF5A5F!important;text-transform:none;' data-tooltip='Click to book this house'>Book</a>
						</div>
					</div>
				</div>";

			}

			echo "</div>";
		}
		?>
		<!--
		<ul class="pagination center-align">
			<li class="waves-effect"><a href="?pageno=1">First</a></li>
		    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
        		<a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
   			</li>
		    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
		        <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
		    </li>		
		   <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>   
 		</ul>
 	-->
	</main>
</body>
</html>

<?php
	include '../includes/js.php';
?>
<script type="text/javascript">
	 $(document).ready(function(){
    	$('.materialboxed').materialbox();
  	});
</script>