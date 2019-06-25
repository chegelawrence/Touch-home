<?php


//Database configuration file
require '../config/database.php';
//process user credentials
$username = htmlentities(trim($_POST['username']));
$password = htmlentities($_POST['pass']);

$response = [];
if(strlen($username) == 0){
	$_SESSION['username-error'] = 'Enter your username';
	$response['username-error'] = 'Enter your username';
}
if(strlen($password) == 0){
	$_SESSION['password-error'] = 'Enter your password';
	$response['password-error'] = 'Enter your password';
}

if(empty($response)){
	//check against stored credentials in the database
	$db = new Database();
	$conn = $db->getConnection();
	if($conn != null){
		$query = "SELECT id,username,first_name,last_name,is_admin,password FROM users WHERE email = ?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($username));
		//query should return only one record
		//fetch that record!!
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		if($user){
			//email found
			//verify password!Hashed using BCRYPT algorithm
			if(password_verify($password,$user['password'])){
				//check if user is admin or normal user
				if($user['is_admin'] == 1){
					//redirect to admin dashboard
					$_SESSION['user_id'] = $user['id'];
					$_SESSION['is_admin'] = true;
					$_SESSION['name'] = $user['first_name']." ".$user['last_name'];
					header('Location:/admin/');
				}else{
					//redirect to normal user dashboard
					$_SESSION['user_id'] = $user['id'];
					$_SESSION['name'] = $user['first_name']." ".$user['last_name'];
					header('Location:/home/');
					
				}
			}else{
				//password match failed
				$_SESSION['username-error'] = 'wrong username or password.Try again';
			}
		}else{
			$_SESSION['username-error'] = 'Wrong username or password.Try again';
		}
	}else{
		$_SESSION['server-error'] = 'Critical server error.We are looking into that.';
	}

}




?>