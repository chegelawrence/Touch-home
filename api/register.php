<?php

require '../config/database.php';

/**
 * 
 */

if('POST' == $_SERVER['REQUEST_METHOD']){
	$firstname = htmlentities(trim($_POST['firstname']));
	$lastname = htmlentities(trim($_POST['lastname']));
	$username = htmlentities(trim($_POST['username']));
	$email = htmlentities(trim($_POST['email']));
	$phone = htmlentities(trim($_POST['phone']));
	$id = htmlentities(trim($_POST['id-number']));
	$password = htmlentities($_POST['password']);
	$cpassword = htmlentities($_POST['cpassword']);


	//response to be sent back to client
	//in JSON format
	$response = [];

	if(strlen($firstname) == 0){
		$response['firstname'] = "Enter firstname";
	}
	if(strlen($lastname) == 0){
		$response['lastname'] = "Enter lastname";
	}
	if(strlen($email) == 0){
		$response['email'] = "Enter email";
	}else{
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$response['email'] = "This email is invalid";
		}else{
			$db = new Database();
			$conn = $db->getConnection();
			$query = "SELECT count(*) as num_user FROM users WHERE email = ?";
			$stmt = $conn->prepare($query);
			$stmt->execute(array($email));
			$res = $stmt->fetch(PDO::FETCH_ASSOC);
			if($res["num_user"] == 1){
				//event exist
				$response['email'] = "Email already exists";

			}
		}
		$conn = null;
	}
	if(strlen($username) == 0){
		$response['username'] = "Enter username";
	}else{
		$db = new Database();
		$conn = $db->getConnection();
		
		$query = "SELECT count(*) as num_user FROM users WHERE username = ?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($username));
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if($res["num_user"] == 1){
			//event exist
			$response['username'] = "Username already exists";

		}
		$conn = null;
	
	}
	if(strlen($phone) == 0){
		$response['phone'] = "Enter phone number";
	}
	else if(!preg_match('/^(\+254|0)\d{9}$/', $phone)){
		$response['phone'] = 'Phone number format is not correct';
	}
	else{
		$db = new Database();
		$conn = $db->getConnection();
		
		$query = "SELECT count(*) as num_user FROM users WHERE phone = ?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($phone));
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if($res["num_user"] == 1){
			//event exist
			$response['phone'] = "Phone number already exists";

		}
		$conn = null;
	
	}
	if(strlen($id) == 0){
		$response['id'] = "Enter ID number";
	}else{
		$db = new Database();
		$conn = $db->getConnection();
		
		$query = "SELECT count(*) as num_user FROM users WHERE ID = ?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($id));
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if($res["num_user"] == 1){
			//event exist
			$response['id'] = "ID number already exists";

		}
		$conn = null;
	
	}
	if(strlen($password) == 0){
		$response['password'] = "Enter a password";
	}else{
		if(strlen($password) < 8){
			$response['password'] = 'Password should be atleast 8 characters long';
		}
		if(strlen($cpassword) == 0){
		$response['cpassword'] = "Confirm the password";
		}else{
			if(strcmp($password, $cpassword) != 0){
				$response['password'] = 'Passwords do not match';
			}
		}

	}

	if(!empty($response)){
		//send back form errors
		header("Content-Type:application/json");
		echo json_encode($response);
	}else{
		header("Content-Type:application/json");
		//no form errors
		//register user
		$db = new Database();
		$conn = $db->getConnection();
		if($conn != null){
			$query = "INSERT INTO users(first_name,last_name,username,email,phone,id_number,password)VALUES(?,?,?,?,?,?,?)";
			$stmt = $conn->prepare($query);
			$conn->beginTransaction();
			try{
				$stmt->execute(array(ucfirst($firstname),ucfirst($lastname),ucfirst($username),strtolower($email),$phone,$id,password_hash($password,PASSWORD_BCRYPT)));
				$conn->commit();
				$response['message'] = "Account creation success.You can now sign in";

			}catch(PDOException $e){
				error_log($e->getMessage());
				$conn->rollback();
				//$response['status'] = "Account creation failed.Try again later";
			}
			$conn = null;//close connection
		}
		echo json_encode($response);
	}
	





}



?>