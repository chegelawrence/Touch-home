	<!--side nav-->
   	 <ul id="slide-out" class="side-nav fixed light lighten-2 z-depth-0" style="border-right: none;background-color: #5a6a75;">
        <br>

        <br>
        <br>
         <ul class="collapsible grey-text" data-collapsible="accordion" style="font-family: 'Roboto';">
        <?php
            if(isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true){
                //echo admin dashboard links
                echo "<a style='font-size: .875rem;letter-spacing: 1px;font-family:". 'Google Sans'.";' class='grey-text' href='/admin/'>
                <li>
                    <div class='collapsible-header'>
                        <i class='fas fa-home'></i>&nbsp;Dashboard
                    </div>
               </li>
            </a>
            <div class='divider'></div>
            <a style='font-size: .875rem;letter-spacing: 1px;font-family:". 'Google Sans'.";' class='grey-text' href='/rentals/'>
                <li>
                    <div class='collapsible-header'>
                        <i class='fas fa-home'></i>&nbsp;Rentals
                    </div>
               </li>
            </a>
            <div class='divider'></div>
            <a class='grey-text' href='/new-surburb'>
                <li>
                    <div class='collapsible-header' style='font-size: .875rem;letter-spacing:.01785714em;font-family:". 'Google Sans'.";'>
                        <i class='fas fa-plus'></i>&nbsp;Add surburb
                    </div>
                </li>
            </a>
            <div class='divider'></div>
            <a style='font-size: .875rem;letter-spacing: 1px;font-family:". 'Google Sans'.";' class='grey-text' href='/profile'>
                <li>
                    <div class='collapsible-header'>
                        <i class='fas fa-user-cog'></i>&nbsp;Personal info
                    </div>
               </li>
            </a>
            <div class='divider'></div>
            <a style='font-size: 13px;letter-spacing: 1px;font-family:". 'Google Sans'.";' id='logoutBtn' class='grey-text' href='/signout/'>
                <li>
                    <div class='collapsible-header'>
                        <i class='fas fa-sign-out-alt'></i>&nbsp;Signout
                    </div>
                </li>
            </a>";
            }else{
                 echo "<a style='font-size: .875rem;letter-spacing: 1px;font-family:". 'Google Sans'.";' class='grey-text' href='/home/'>
                <li>
                    <div class='collapsible-header'>
                        <i class='fas fa-home'></i>&nbsp;Home
                    </div>
               </li>
            </a>
            <div class='divider'></div>
            <a style='font-size: .875rem;letter-spacing: 1px;font-family:". 'Google Sans'.";' class='grey-text' href='/profile/'>
                <li>
                    <div class='collapsible-header'>
                        <i class='fas fa-user'></i>&nbsp;Account
                    </div>
               </li>
            </a>
            <div class='divider'></div>
            <a class='grey-text' href='/signout/'>
                <li>
                    <div class='collapsible-header' style='font-size: .875rem;letter-spacing:.01785714em;font-family:". 'Google Sans'.";'>
                        <i class='fas fa-sign-out-alt'></i>&nbsp;Signout
                    </div>
                </li>
            </a>";

            }
        ?>
       
             
        </ul>
    </ul>