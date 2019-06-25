<?php
$firstname = "";
$lastname = "";
$phone = "";
$message = "";
$response = [];
if('POST' == $_SERVER['REQUEST_METHOD']){
	$firstname = htmlentities(trim($_POST['firstname']));
	$lastname = htmlentities(trim($_POST['lastname']));
	$phone = htmlentities(trim($_POST['phone']));
	$message = htmlentities(trim($_POST['message']));
	if(strlen($firstname) == 0){
		$response['firstname'] = 'This field is required';
	}
	if(strlen($lastname) == 0){
		$response['lastname'] = 'This field is required';
	}
	if(strlen($phone) == 0){
		$response['phone'] = 'This field is required';
	}else{
		if(!preg_match('/^(\+254|0)\d{9}$/', $phone)){
	        $response['phone'] = 'Phone number format is not correct';
    	}
	}
	if(strlen($message) == 0){
		$response['message'] = 'This field is required';
	}else{
		if(strlen($message) < 20){
			$response['message'] = 'Message should not be less than 20 characters';
		}
	}

	if(empty($response)){
		//send sms here
		include __DIR__ .'/api/AfricasTalkingGateway.php';
		$Message = ucfirst($firstname). " ".ucfirst($lastname)." with phone number:".$phone." has contacted you. Below is the message:-\n";
		$Message .= $message;
		$username   = "kigunda";
		$apikey     = "05d50b3ef2ff060b172639c87e8bc46a96dc6cadb70224025fe3f5b841a3b800";
		// Specify the numbers that you want to send to in a comma-separated list
		// Please ensure you include the country code (+254 for Kenya in this case)
		$recipients = '0792444398';
		// And of course we want our recipients to know what we really do
		
		// Create a new instance of our awesome gateway class
		$gateway    = new AfricasTalkingGateway($username, $apikey);
		try{
			$results = $gateway->sendMessage($recipients, $Message);
			$response['send-success'] = 'Thank you for contacting us. We will get back to you shortly';

		}catch(Exception $e){
			error_log($e->getMessage());
			$response['server-error'] = 'Something went wrong. Try again after some time';
		}
	}

}




?>
<!DOCTYPE html>
<html>
<head>
	<title>Touch Home</title>
	<link rel="stylesheet" type="text/css" href="/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="/css/semantic.min.css">
	<link rel="stylesheet" type="text/css" href="/css/sweetalert.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro|Google+Sans|Product+Sans|Poppins' rel='stylesheet' type='text/css'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<style type="text/css">
		body {
		    display: flex;
		    min-height: 100vh;
		    flex-direction: column;
		    font-family: 'Google Sans';
  		}

	 	 main {
	    	flex: 1 0 auto;
	  	}
	  	.auths:hover{
	  		transition: 2s;
	  	}
	  	.auths:hover{
	  		background-color: #202124!important;
	  	}
	  	input:not([type]), input[type=text], input[type=password], input[type=email], input[type=url], input[type=time], input[type=date], input[type=datetime], input[type=datetime-local], input[type=tel], input[type=number], input[type=search], textarea.materialize-textarea {
	    background-color: transparent;
	    border: none;
	    border-bottom: 2px solid #9e9e9e!important;
	    border-radius: 0;
	    outline: none;
	    height: 3rem;
	    width: 100%;
	    font-size: 1rem;
	    margin: 0 0 20px 0;
	    padding: 0;
	    box-shadow: none;
	    box-sizing: content-box;
	    transition: all 0.3s;
	    font-family: 'Google Sans','Helvetica',sans-serif;
	}

	input:not([type]):focus:not([readonly]), input[type=text]:focus:not([readonly]), input[type=password]:focus:not([readonly]), input[type=email]:focus:not([readonly]), input[type=url]:focus:not([readonly]), input[type=time]:focus:not([readonly]), input[type=date]:focus:not([readonly]), input[type=datetime]:focus:not([readonly]), input[type=datetime-local]:focus:not([readonly]), input[type=tel]:focus:not([readonly]), input[type=number], input[type=search]:focus:not([readonly]), textarea.materialize-textarea:focus:not([readonly]) {
		border-bottom: 2px solid rgb(51, 103, 214)!important;
	}
	.help-inline{
		font-size: 13px;
		color: red;
		font-family: 'Poppins';
	}
	.success-inline{
		font-size: 16px;
		color: green;
		font-family: 'Poppins';
	}
	</style>
</head>
<body>
	<nav class="z-depth-1" style="background-color: #4c87ea;">
	    <div class="nav-wrapper">
	    	<a href="/" class="brand-logo" style="font-family: 'Google Sans';">TouchHome</a>
		      <ul id="nav-mobile" class="right hide-on-med-and-down">
	      		<li>
	      			<a href="/login/" class="btn btn-flat white-text auths" style="background-color: #ee6e73;border-radius: 50px;text-transform: none;">Sign In</a>
	      		</li>
	      		<li>
	      			<a href="/register/" class="btn btn-flat white-text auths" style="background-color: #ee6e73;border-radius: 50px;text-transform: none;">Create account</a>
	      		</li>
		      </ul>
	    </div>
	</nav>
	<main>
		<div class="row slider">
	         <ul class="slides">
	              <li>
	                 <img src="/images/mountain-view-ar-rental-houses-homes-for-rent-colorado-arkansas-4-bedroom-latest-in-mount-warren-park-mar-design-ideas-exciting-vie.jpg" alt="" class="responsive-img"/>
	                 <div class="caption center-align">
	                    
	                 </div>
	             </li>
	             <li>
	                 <img src="/images/RF.jpg" alt="" class="responsive-img"/>
	             </li>
	             <li>
	                 <img src="/images/housing.jpg" alt="" class="responsive-img"/>
	                 <div class="caption right-align">
	                     
	                 </div>
	             </li>
	            
	             <li>
	                 <img src="/images/7875.jpg" alt="" class="responsive-img"/>
	                 <div class="caption center-align">
	                 </div>
	             </li>
	         </ul>
     	</div>
     	<div class="row container">
     		<div class="col s12 m6 l6 ">
     			<h2 class="center-align">About us</h2>
     			<p style="font-family: 'Poppins';font-size:13px;color:#202124;" class="center-align">
     				TouchHome is a Kenyan based web application that basically allows residents in Nairobi city and its surburbs locate affordable and vacant housing premises based on their location hence helping them save time and money when looking for accomodation.
     				<br><br>
     				
     			</p>
     			<p class="center-align">
	     			<a href="/login/" class="btn btn-flat btn-large white-text" style="background-color: #ee6e73;border-radius: 50px;text-transform: none;">
	     				Sign in
	     			</a>
	     			or
	     			<a href="/register/" class="btn btn-flat btn-large white-text" style="background-color: #ee6e73;border-radius: 50px;text-transform: none;">
	     				Create account
	     			</a>
     			</p>
     		</div>
     		<div class="col s12 m6 l6 card" style="box-shadow: none;">
     			<h2>Contact us</h2>
     			<form novalidate method="POST" action="/" style="margin-bottom: 30px;">
     				<div class="col s12 m6 l6 input-field">
     					<label for="firstname"><i class="material-icons">person_outline</i>&nbsp;First Name</label>
						<input type="text" name="firstname" id="firstname" autocomplete="off" value="<?=$firstname?>">
						<span class="help-inline">
							<?php
							if(isset($response['firstname'])){
								echo $response['firstname'];
							}
							unset($response['firstname']);
							?>
						</span>
     				</div>
     				<div class="col s12 m6 l6 input-field">
     					<label for="lastname">Last Name</label>
						<input type="text" name="lastname" id="lastname" autocomplete="off" value="<?=$lastname?>">
						<span class="help-inline">
							<?php
							if(isset($response['lastname'])){
								echo $response['lastname'];
							}
							unset($response['lastname']);
							?>
						</span>
     				</div>
     				<div class="col s12 m12 l12 input-field">
     					<label for="phone"><i class="material-icons">phone</i>&nbsp;Phone</label>
						<input type="text" name="phone" id="phone" autocomplete="off" value="<?=$phone?>">
						<span class="help-inline">
							<?php
							if(isset($response['phone'])){
								echo $response['phone'];
							}
							unset($response['phone']);
							?>
						</span>
     				</div>
     				<div class="col s12 m12 l12 input-field">
     					<label for="message"><i class="material-icons">comment</i>&nbsp;Message</label>
     					<textarea class="materialize-textarea" name="message" id="message"></textarea>
     					<span class="help-inline">
							<?php
							if(isset($response['message'])){
								echo $response['message'];
							}
							unset($response['message']);
							?>
						</span>
						<span class="help-inline">
							<?php
							if(isset($response['server-error'])){
								echo "<i class='material-icons'>warning</i>&nbsp;".$response['server-error'];
							}
							unset($response['server-error']);
							?>
						</span>
						<span class="success-inline">
							<?php
							if(isset($response['send-success'])){
								echo "<i class='material-icons'>done</i>&nbsp;".$response['send-success'];
							}
							unset($response['send-success']);
							?>
						</span>
     				</div>
     				<div class="col s12 m12 l12 input-field">
     					<button class="btn btn-flat white-text" style="background-color: #ee6e73;border-radius: 50px;text-transform: none;">Send message</button>
     				</div>
     			</form>
     		</div>
     	</div>
	</main>
	 <footer class="page-footer">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                 	<h5 class="white-text">Contact Us</h5>
	                <ul>
	                  <li><a class="text-lighten-3" href="#!" style="letter-spacing: 0.8px;font-size: 13px;color: #202124;">erickngari@gmail.com</a></li>
	                  <li><a class="text-lighten-3" href="#!" style="letter-spacing: 0.8px;font-size: 13px;color: #202124;">+254 792 444 398</a></li>
	                </ul>
              </div>
              <div class="col l4 offset-l2 s12">
                
              </div>
            </div>
          </div>
          <div class="footer-copyright" style="height: 40px;">
            <div class="container">
	           <?php
	           echo "<p style='text-align:center;'><span style='font-family:Google Sans;font-size:13px;'>&copy ".date('Y')." TouchHome.All rights reserved</span></p>";
	           ?>
            </div>
          </div>
        </footer>
	 

</body>
</html>
<script type="text/javascript" src="/libraries/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/libraries/materialize.min.js"></script>
<script type="text/javascript" src="/libraries/sweetalert.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.slider').slider();
	})
</script>