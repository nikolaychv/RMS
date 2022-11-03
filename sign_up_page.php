<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Restaurant Management System - Sign up</title>
        <meta name="description" content="А restaurant management system that provides a variety of information about customers, bills, food and more..."/>
        <meta name="robots" content="index,follow"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="stylesheet" type="text/css" href="css/style_login_page.css">
    </head>
    <body>
        <form action="sign_up.php" method="post">
     	<h2 id="form-title">Restaurant Management System</h2>
        <h2 id="sign-up-title">Sign up</h2>
     	<label>Restaurant name</label>
     	<input type="text" name="restaurant_name" placeholder="Enter username..."><br>
        
        <label>Restaurant telephone</label>
     	<input type="tel" name="restaurant_telephone" placeholder="Enter telephone..."><br>

     	<label>Restaurant email</label>
     	<input type="email" name="restaurant_email" placeholder="Enter email..."><br>
        
        <label>Restaurant address</label>
     	<input type="text" name="restaurant_address" placeholder="Enter address..."><br>
        
        <label>User full name</label>
     	<input type="text" name="user_full_name" placeholder="Enter full name..."><br>
        
        <label>Username</label>
     	<input type="text" name="user_username" placeholder="Enter username..."><br>
        
        <label>User e-mail</label>
     	<input type="email" name="user_email" placeholder="Enter email..."><br>

     	<label>Password</label>
     	<input type="password" name="user_password" placeholder="Enter password..."><br>
        
        <label>Confirm the password</label>
     	<input type="password" name="password_check" placeholder="Confirm the password..."><br>
        
        <?php if (isset($_GET['error'])) { ?>
     		<p id="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
        <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>
        
               <div class="sign-up-options">
        <span id="log-in-button"><a href="index.php">Login</a></span>
     	<button type="submit">Sign up</button>
               </div>
               <span id="version">Version 1.0.0.</span>
     </form> 
     <footer>
            <div class="footer-content">
                    Copyright &copy; Nikolay Vaklev <?php echo date("Y"); ?>
            </div>
</footer>
    </body>
</html>