<?php
       require_once 'config_mysql.php';
       session_start();
       
       if(!isset($_SESSION['user_id'])) {
           header('location: index.php');
           exit();
       }
       
       require_once 'partials/header.php';
       
       function validate_data($data_to_validate){
           global $connection;
           $data_to_validate = mysqli_real_escape_string($connection, $data_to_validate);
	   return $data_to_validate;
	}
       
if(isset($_SESSION['user_id']))
{
  $query = 'SELECT * FROM tbl_user WHERE user_id = '.$_SESSION['user_id'].' LIMIT 1';
  $result = mysqli_query($connection, $query);
  
  if(!mysqli_num_rows($result))
  {
    header('location: profile.php?error=Failed to change the password...');
    exit(); 
  }
  $record = mysqli_fetch_assoc($result);
} else {
    header('location: profile.php?error=Failed to change the password...');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
      $the_password = validate_data($_POST['user_password']); // we don't hash the password
      $the_new_password = validate_data($_POST['user_new_password']);
      $the_password_check = validate_data($_POST['password_check']);
      $the_username = $_SESSION['user_username'];
      
        if(empty($the_password)){
            header("location: profile_password_change.php?error=Password is required.");
	    exit();
	}
        else if(empty($the_new_password)){
            header("location: profile_password_change.php?error=New password is required.");
	    exit();
	}
        else if(empty($the_password_check)){
            header("location: profile_password_change.php?error=Please confirm the new password.");
	    exit();
	}
    
    if ($_POST['user_password'] != null && 
        $_POST['user_new_password'] != null && 
        $_POST['password_check'] != null) {
      
       if($the_new_password !== $the_password_check){
            header("location: profile_password_change.php?error=The passwords do not match.");
	    exit();
	}
      else {
            $sql = "SELECT * FROM tbl_user WHERE user_username='$the_username' AND user_password='$the_password'";
            $result = mysqli_query($connection, $sql);
            $count = mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);
            
            if ($count === 1) {
               
        $first_sql = 'UPDATE tbl_user SET user_password = "'.$the_new_password.'"
                                          WHERE user_id = '.$_SESSION['user_id'].' LIMIT 1';
                       
        $first_result = mysqli_query($connection, $first_sql);
        
            }
            else {
            header("location: profile_password_change.php?error=Wrong password.");
	    exit();
            }
            if ($first_result) {
            header("location: profile.php?success=Your password has been updated successfully.");
	    exit();
            }
            else {
	    header('location: profile_password_change.php?error=Failed to change the password...');
            exit();
            }
      }
    }
}
?>

<h4>Edit profile - change password</h4>
<div class="edit-content">
    
    <form method="post">  
  <label>Password</label>
  <input type="password" name="user_password" placeholder="Enter password..."><br>    
        
  <label>New password</label>
  <input type="password" name="user_new_password" placeholder="Enter new password..."><br>
        
  <label>Confirm the password</label>
  <input type="password" name="password_check" placeholder="Confirm the password..."><br>
        
        
        <?php if (isset($_GET['error'])) { ?>
     		<p id="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
        <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>
        
               <div id="submit-area">
        <a href="profile.php"><img id="go-back-image" src="images/go-back-image.png" alt="Go back"></a>
     	<button type="submit" id="submit-button">Edit profile</button>
               </div> 
     </form> 
    
</div>

<?php
       require_once 'partials/footer.php';
?>