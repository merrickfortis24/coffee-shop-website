<?php
session_start();
include_once "./config/dbconnect.php";
?>
       
<!-- nav -->
<nav class="navbar navbar-expand-lg navbar-light px-5" style="background-color: #3B3131;">
    <a class="navbar-brand ml-5" href="./index.php">
        <img src="./assets/images/logo.png" width="80" height="80" alt="Swiss Collection">
    </a>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>
    
    <div class="user-cart">  
        <?php           
        if(isset($_SESSION['admin_id'])) { // Changed from user_id to admin_id to match your login system
          ?>
          <a href="logout.php" onclick="logout()" style="text-decoration:none;">
  <i class="fa fa-sign-out mr-5" style="font-size:30px; color:#fff;" aria-hidden="true" title="Logout"></i>
</a>
          <?php
        } else {
            ?>
            <a href="./login.php" style="text-decoration:none;">
                <i class="fa fa-sign-in mr-5" style="font-size:30px; color:#fff;" aria-hidden="true" title="Login"></i>
            </a>
            <?php
        } ?>
    </div>  
</nav>