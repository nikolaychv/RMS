<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Restaurant Management System - Login</title>
        <meta name="description" content="А restaurant management system that provides a variety of information about customers, bills, food and more..."/>
        <meta name="robots" content="index,follow"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="stylesheet" type="text/css" href="css/style_login_page.css">
    </head>
    <body>
        <form action="login.php" method="post">
     	<h2 id="form-title">Restaurant Management System</h2>
        <h2 id="login-title">Login</h2>
     	<label>Username</label>
     	<input type="text" name="user_username" placeholder="Enter username..."><br>

     	<label>Password</label>
     	<input type="password" name="user_password" placeholder="Enter password..."><br>
        
        <?php if (isset($_GET['error'])) { ?>
     		<p id="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
        <span id="sign-up-button"><a href="sign_up_page.php">Sign up</a></span>
     	<button type="submit">Log In</button>
     </form>   
    </body>
</html>
