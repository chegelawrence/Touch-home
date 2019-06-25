<?php


//Database configuration file
require '../config/database.php';
//process user credentials
$outskirt = htmlentities(trim($_POST['surburb']));

$response = [];
if(strlen($outskirt) == 0){
	$_SESSION['surburb'] = 'Enter the name of the surburb you want to add';
	$response['surburb'] = 'Enter the name of the location you want to add';
}

if(empty($response)){
	//check against stored credentials in the database
	$db = new Database();
	$conn = $db->getConnection();
	if($conn != null){
		$query = "SELECT id FROM surburbs WHERE name = ?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array(ucfirst($outskirt)));
		$location = $stmt->fetch(PDO::FETCH_ASSOC);
		if($location){
			//location already added
			$_SESSION['surburb'] = 'The surburb already exists';
		}else{
			//add location
			$query = "INSERT INTO surburbs(name)VALUES(?)";
			$conn->beginTransaction();
			try{
				$stmt = $conn->prepare($query);
				$stmt->execute(array(ucfirst($outskirt)));
				$conn->commit();
				$_SESSION['location-add-success'] = "The new surburb has been added successfully";
				//success

			}catch(PDOException $e){
				//error
				//Database or some other server error
				$conn->rollback();
				$_SESSION['server-error'] = 'Critical server error.We are looking into that.';

			}
			

		}
	}else{
		$_SESSION['server-error'] = 'Critical server error.We are looking into that.';
	}
	$conn = null;//close database connection

}




?>