<?php

//process user credentials
include '../config/database.php';
$housetype = htmlentities(trim($_POST['house-type']));
$commitmentfee = htmlentities(trim($_POST['commitment-fee']));
$monthlyfee = htmlentities(trim($_POST['monthly-fee']));
$location = "";
$description = htmlentities(trim($_POST['description']));
if(!isset($_POST['location'])){
	$_SESSION['location'] = 'Select this field';
	$response['location'] = 'Select this field';
}else{
	$location = htmlentities(trim($_POST['location']));
}

$picture = "";
$picturetmpname = "";
$picturetype = "";
$allowedtypes = "";
$imageExt = "";
$actualimageExt = "";

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



 if(!isset($_FILES['rental-picture'])){
    	$_SESSION['rental-picture-error'] = "Select an image";
    	$response['rental-pciture-error'] = 'Select an image';
    }else{
    	$picture = htmlentities(trim($_FILES['rental-picture']['name']));
    	$picturetmpname = $_FILES['rental-picture']['tmp_name'];
		$picturetype = $_FILES['rental-picture']['type'];
		$allowedtypes = ['jpg','jpeg','png'];
		$imageExt = explode('.',$picture);
		$actualimageExt = strtolower(end($imageExt));
    	if($picturetmpname == ""){
    		$_SESSION['rental-picture-error'] = "Select an image";
    		$response['rental-pciture-error'] = 'Select an image';
    	}else{
    		if(getimagesize($picturetmpname) === false){
	    	$_SESSION['rental-picture-error'] = "This file does not seem to be an image";
	    	$response['rental-pciture-error'] = 'Select an image';
		    }else{
		    	if(!in_array($actualimageExt, $allowedtypes)){
		    		$_SESSION['rental-picture-error'] = "This image type not allowed";
		    		$response['rental-pciture-error'] = 'This image type not allowed';
		    	}
		    }
    	}
	    
    }


if(empty($response)){
	//check against stored credentials in the database
	$db = new Database();
	$conn = $db->getConnection();
	$newimagename = uniqid('',true).".".$actualimageExt;
    $imagedestination = '../uploads/'.$newimagename;
	if($conn != null){

			if(move_uploaded_file($picturetmpname, $imagedestination)){
				$query = "INSERT INTO rentals(commitment_fee,rental_location,house_description,monthly_fee,house_type,picture_location)VALUES(?,?,?,?,?,?)";
				$conn->beginTransaction();
				try{
					//upload rental picture
					
					$stmt = $conn->prepare($query);
					$stmt->execute(array($commitmentfee,$location,ucwords($description),$monthlyfee,ucwords($housetype),$imagedestination));
					$conn->commit();
					//send success
					$_SESSION['housetype'] = ucfirst($housetype);
					$_SESSION['commitmentfee'] = $commitmentfee;
					$_SESSION['monthlyfee'] = $monthlyfee;
					$_SESSION['housepicture'] = $imagedestination;
					$_SESSION['houselocation'] = $location;
					$_SESSION['confirm-details'] = true;
					header('Location:/confirm-new-rental-details/');
				}catch(PDOException $e){
					//Database or some other server error
					$conn->rollback();
					$_SESSION['server-error'] = 'Critical server error.We are looking into that.Try again';

				}
			}else{
				$_SESSION['server-error'] = 'Critical server error.We are looking into that.Try again';
			}



			
	}else{
		$_SESSION['server-error'] = 'Critical server error.We are looking into that.';
	}
	$conn = null;//close database connection

}




?>