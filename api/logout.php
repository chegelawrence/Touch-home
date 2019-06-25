<?php

session_start();

/**
 * 
 */
class LogOut
{
	public function signOutHandler(){
		//destroy user session
		unset($_SESSION['user_id']);
		unset($_SESSION['name']);
		if(isset($_SESSION['is_admin'])){
			unset($_SESSION['is_admin']);
		}
		
		
		session_destroy();

		return true;

	}
}

if("GET" == $_SERVER["REQUEST_METHOD"]){
	
	$authClass = new LogOut();
	if($authClass->signOutHandler()){
		header("Location: /login/");
	}
}
?>