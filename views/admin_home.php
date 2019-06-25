
<?php
//prevent errors from displaying in browser
error_reporting(0);
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== true){
	header('Location:/login/?logged_in=false');
}

include '../config/database.php';


$tableHTML = '';

if('GET' == $_SERVER['REQUEST_METHOD'] && !isset($_GET['search']) || trim($_GET['search']) == ''){
  //init page
  $tableHTML = getBookings();

}
$_SESSION['search-term'] = '';

if('GET' == $_SERVER['REQUEST_METHOD'] && isset($_GET['search']) && trim($_GET['search']) != ''){
  $search_keyword = htmlentities(trim($_GET['search']));
  $_SESSION['search-term'] = $search_keyword;
  $tableHTML = searchBookings($search_keyword);
}




//search bookings

function searchBookings($keyword){
  $keyword .= '%';
  $html = "";
  $db = new Database();
  $conn = $db->getConnection();
  if($conn != null){
    $query = "SELECT bookings.id,bookings.first_name,bookings.email,bookings.nationality,package.destination AS destination FROM bookings LEFT JOIN package ON bookings.package_id = package.id WHERE bookings.email LIKE ?";
    
    $stmt = $conn->prepare($query);
    $stmt->execute(array($keyword));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(count($results) == 0)
    {
      $html .= "<tr class='black-text' style='font-size:15px;letter-spacing:1px;cursor:pointer;font-family:'Google Sans';'><td colspan='5' style='padding:5px 5px;text-align:center;'><i class='fa fa-times' style='color:#d01919;font-size:20px;'></i>&nbsp;NO MATCH FOUND!</td></tr>";
    }else{
      
      foreach ($results as $result) {
        # code...
         $html .= "<tr class='grey-text' style='font-size:15px;letter-spacing:1px;cursor:pointer;font-family:'Google Sans''><td style='padding:5px 5px;'>".$result['first_name']."</td><td style='padding:5px 5px;'>".$result['email']."</td><td style='padding:5px 5px;'>".$result['destination']."</td><td style='padding:5px 5px;'><button data-id=".$result['id']." class='btn btn-flat tooltipped more-details' data-tooltip='More details' data-position='left' data-delay='40'  style='padding:0 1em;border: 1px solid rgb(218, 220, 224);color:rgb(51, 103, 214);font-size:13px;font-weight:600;text-transform:none'>View</button>&nbsp;<button id=".$result['id']." class='btn btn-flat tooltipped delete-button' data-tooltip='Delete' data-position='right' data-delay='right' style='padding:0 1em;border: 1px solid rgb(218, 220, 224);font-size:13px;font-weight:600;color:#db2828;text-transform:none;'>Trash</button></td></tr>";
      }
    }
  }
  $conn = null;
  return $html;
}


//fetch booking details

/**
 * 
 */

	
	function getBookings(){
    $html = '';
		$db = new Database();
		$conn = $db->getConnection();

		$query =  "SELECT first_name,last_name,id_number,phone,bookings.id AS booking_id,bookings.check_in,rentals.house_type,rentals.commitment_fee,rentals.monthly_fee,surburbs.name FROM users RIGHT JOIN bookings ON users.id=bookings.user_id LEFT JOIN rentals ON bookings.house_id=rentals.id LEFT JOIN surburbs ON rentals.rental_location=surburbs.id";

		$stmt = $conn->prepare($query);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$conn = null;//close DB connection;


		if(count($results) == 0){
			$html .= "<tr><td colspan='10' style='text-align:center;color:red;font-weight:600;'><i class='fas fa-exclamation-triangle'></i>&nbsp;No bookings found at the moment</td>	</tr>";

		}else{
			foreach ($results as $result) {
		      $html .= "<tr>
		      <td style='font-family:".'Google Sans;'."'>".$result['first_name']."</td>
		      <td style='font-family:".'Google Sans;'."'>".$result['last_name']."</td>
		      <td style='font-family:".'Google Sans;'."'>".$result['id_number']."</td>
		      <td style='font-family:".'Google Sans;'."'>".$result['phone']."</td>
		      <td style='font-family:".'Google Sans;'."'>".$result['house_type']."</td>
		        <td style='font-family:".'Google Sans;'."'>".$result['name']."</td>
		      <td style='font-family:".'Google Sans;'."'>".$result['commitment_fee']."</td>
			  <td style='font-family:".'Google Sans;'."'>".$result['monthly_fee']."</td>
			  <td style='font-family:".'Google Sans;'."'>".$result['check_in']."</td>
			  <td><button id=".$result['booking_id']." class='btn btn-flat paper-button white-text tooltipped delete-booking' data-tooltip='Delete' style='background-color:#db2828!important;'><i class='fas fa-trash'></i></button></td>
		      </tr>";
	    	}

		}

	   

		return $html;

	}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
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
		<h1 style="font-size: 1.2rem;margin-left: 10px;">Bookings</h1>
		<div class="row">
			<table class="bordered">
                <thead style="border-bottom: 1px solid rgba(34,36,38,.15);background-color: rgb(249, 250, 251);">
                    <tr>
                      
                        <th style="font-family: 'Google Sans';font-size: 14px;letter-spacing: 1px;font-weight: 400;">
                            First name
                        </th>
                        <th style="font-family: 'Google Sans';font-size: 14px;letter-spacing: 1px;font-weight: 400;">
                            Last name
                        </th>
                        <th style="font-family: 'Google Sans';font-size: 14px;letter-spacing: 1px;font-weight: 400;">
                            ID number
                        </th>
                        <th style="font-family: 'Google Sans';font-size: 14px;letter-spacing: 1px;font-weight: 400;">
                            Phone
                        </th>
                        <th style="font-family: 'Google Sans';font-size: 14px;letter-spacing: 1px;font-weight: 400;">
                            House type
                        </th>
                        <th style="font-family: 'Google Sans';font-size: 14px;letter-spacing: 1px;font-weight: 400;">
                            House Location
                        </th>
                        <th style="font-family: 'Google Sans';font-size: 14px;letter-spacing: 1px;font-weight: 400;">
                            Commitment fee
                        </th>
                        <th style="font-family: 'Google Sans';font-size: 14px;letter-spacing: 1px;font-weight: 400;">
                            Monthly fee
                        </th>
                       
                        <th style="font-family: 'Google Sans';font-size: 14px;letter-spacing: 1px;font-weight: 400;">
                           Check in date
                        </th>
                        <th></th>
                       
                    </tr>
                </thead>
                <tbody id="bookings-table-body">
                	<?php
                	echo $tableHTML;
                	?>

                </tbody>
    		</table>
		</div>
	</main>
</body>
</html>
<?php
	include '../includes/js.php';
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.delete-booking').on('click',function(event){
			swal({
	            title: "Are you sure?",
	            text: "This record will be deleted!",
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
					url:'http://localhost/api/delete_booking.php/',
					data:{"booking_id":id,"token":"delete_booking"},
					dataType:'json',
					success:function(res){
						console.log(res)
						swal("Success",res.message,"success")
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