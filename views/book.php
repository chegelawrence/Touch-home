<?php
//set the http headers
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Headers:content-type");
header("Content-Type:application/json");
include "../config/database.php";
$conn = new Database();
$db = $conn->getConnection();
if($db === null){
	$error = array("msg"=>"Connection to the database could not be established");
	echo json_encode($error);
	exit(1);
}

if('GET' === $_SERVER['REQUEST_METHOD']){
	fetchBooks($db);
}

if('POST' === $_SERVER['REQUEST_METHOD']){
	echo json_encode(json_decode($_POST['name']));
}

function fetchBooks($db){
	$query = "SELECT id, name, author FROM books";
	$stmt = $db->prepare($query);
	$stmt->execute();

	$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($books);
}
function addBook($db,$name,$author){
	$query = "INSERT INTO books(name,author) VALUES(?,?)";
	$stmt = $db->prepare($query);
	$stmt->execute();
	http_response_code(200);
	echo json_encode(array("msg"=>"Book has been added successfully"));

}

?>