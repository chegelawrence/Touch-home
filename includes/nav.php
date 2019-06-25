<nav class="z-depth-1" style="background-color: #4c87ea;">
    <div class="nav-wrapper">
      <a href="/" class="brand-logo" style="font-family: 'Google Sans';">TouchHome</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">

      	<?php

      	if(!isset($_SESSION['user_id'])){
      		echo "<li><a href='/login/' class='btn btn-flat white-text auths' style='background-color: #ee6e73;border-radius: 50px;text-transform: none;'>Sign In</a></li>";
      		echo "<li><a href='/register/'  class='btn btn-flat white-text auths' style='background-color: #ee6e73;border-radius: 50px;text-transform: none;'>REGISTER</a></li>";
      	}else{
      		echo "<a href='#!' class='btn btn-flat paper-button white-text red' style='border-radius:50px;'>".$_SESSION['name']."</a>";
      	}

      	?>
      </ul>
    </div>
</nav>