<?php
include_once 'random_password.php';
require_once '../config/database.php';
require_once('AfricasTalkingGateway.php');

//Used to reset the user's password
function forgotPassword($email){

	$query = "SELECT id,phone FROM users WHERE email = ?";
	$db = new Database();
	$conn = $db->getConnection();
	$stmt = $conn->prepare($query);
	$stmt->execute(array($email));
	$user = $stmt->fetch(PDO::FETCH_ASSOC);
	if($user){
		//user with this email found
		$username   = "kigunda";
		$apikey     = "05d50b3ef2ff060b172639c87e8bc46a96dc6cadb70224025fe3f5b841a3b800";
		// Specify the numbers that you want to send to in a comma-separated list
		// Please ensure you include the country code (+254 for Kenya in this case)
		$recipients = $user['phone'];
		// And of course we want our recipients to know what we really do
		
		// Create a new instance of our awesome gateway class
		$gateway    = new AfricasTalkingGateway($username, $apikey);
		/*************************************************************************************
		  NOTE: If connecting to the sandbox:
		  1. Use "sandbox" as the username
		  2. Use the apiKey generated from your sandbox application
		     https://account.africastalking.com/apps/sandbox/settings/key
		  3. Add the "sandbox" flag to the constructor
		  $gateway  = new AfricasTalkingGateway($username, $apiKey, "sandbox");
		**************************************************************************************/
		// Any gateway error will be captured by our custom Exception class below, 
		// so wrap the call in a try-catch block
		try 
		{ 
			$stmt = null;
			$new_password = generateStrongPassword();
			$password_hash = password_hash($new_password,PASSWORD_BCRYPT);
			$conn->beginTransaction();
			$query = "UPDATE users SET password = ? WHERE id = ?";
			$stmt = $conn->prepare($query);
			$stmt->execute(array($password_hash,$user['id']));
			$stmt = null;
			$message    = "Request to change your Touch Home portal password was successful\n";
			$message .= "Your new password is: \n".$new_password;
			  // Thats it, hit send and we'll take care of the rest. 
			  $results = $gateway->sendMessage($recipients, $message);
			  //416 for success
			  $_SESSION['password-reset-message'] = 'Your password has been changed.An SMS has been sent to your phone';
			  $conn->commit();
		}
		//log general exception
		//Database errors
		//sql errors
		//AfricaTalking gateway error
		catch ( Exception $e )
		{
		  error_log($e->getMessage());
		  $_SESSION['server-error'] = 'An error occured on our end.Try again after some time';
		  $conn->rollback();
		  
		}

	}else{
		$_SESSION['user-not-found'] = 'This email does not match any records';
	}
	$conn = null;//close connection to the database

}
?>