<?php
session_start();
if(!isset($_SESSION['user_id'])){
	header("Location:/login/?logged_in=false");
}

if('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['rental_id'])){
	//delete rental
	include '../config/database.php';
	$db = new Database();
	$conn = $db->getConnection();

	$query = "DELETE FROM rentals WHERE id = ?";
	$stmt = $conn->prepare($query);
	//setup a transactional execution
	$conn->beginTransaction();
	try{
		$stmt->execute(array(htmlentities(trim($_POST['rental_id']))));
		$conn->commit();
		echo json_encode(array("status"=>"success","message"=>"Rental deleted successfully"));

	}catch(PDOException $e){
		$conn->rollback();
		echo json_encode(array("status"=>"error","message"=>"Failed to delete rental.Try again later"));

	}

	$conn = null;//close database connection



}



?>