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
    header('location: profile.php?error=Failed to change the profile...');
    exit(); 
  }
  $record = mysqli_fetch_assoc($result);
} else {
    header('location: profile.php?error=Failed to change the profile...');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $the_username = validate_data($_POST['user_username']);
      $the_password = validate_data($_POST['user_password']); // we don't hash the password
      $the_password_check = validate_data($_POST['password_check']);
      $the_user_full_name = validate_data($_POST['user_full_name']);
      $the_user_email = validate_data($_POST['user_email']);
      $the_user_type = $_POST['user_type'];
      $the_user_status = $_POST['user_status'];
      $the_old_username = $_SESSION['user_username'];
      
      
        if (empty($the_username)) {
	    header("location: profile.php?error=Username is required.");
	    exit();
	}
        else if (empty($the_password)){
            header("location: profile.php?error=Password is required.");
	    exit();
	}
	else if(empty($the_password_check)){
            header("location: profile.php?error=Confirm the password.");
	    exit();
	}
        else if(empty($the_user_full_name)){
        header("location: profile.php?error=Full name is required.");
	    exit();
	}
        else if (empty($the_user_email)){
            header("location: profile.php?error=User e-mail is required.");
	    exit();
	}
        else if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["user_username"]))){
        header("location: profile.php?error=Username can only contain letters, numbers, and underscores.");
	    exit();
        }
        if($the_password !== $the_password_check){
            header("location: profile.php?error=The passwords do not match.");
	    exit();
	}
    
    if ($_POST['user_username'] != null && 
        $_POST['user_full_name'] != null && 
        $_POST['user_email'] != null && 
        $_POST['user_password'] != null && 
        $_POST['password_check'] != null) {
        
      $sql = "SELECT * FROM tbl_user WHERE user_username='$the_old_username' AND user_password='$the_password'";
      $result = mysqli_query($connection, $sql);
      $count = mysqli_num_rows($result);
      $row = mysqli_fetch_assoc($result);
      
        if ($count === 1) {
        $first_sql = 'UPDATE tbl_user SET user_username = "'.$the_username.'",
                                          user_full_name = "'.$the_user_full_name.'", user_email = "'.$the_user_email.'",
                                          user_type = "'.$the_user_type.'", user_status = "'.$the_user_status.'"
                                          WHERE user_id = '.$_SESSION['user_id'].' LIMIT 1';
                       
        $first_result = mysqli_query($connection, $first_sql);
        
        $_SESSION['user_username'] = $the_username;
        }
        else {
            header('location: profile.php?error=Wrong password...');
            exit();
        }
            if ($first_result) {
            header("location: profile.php?success=Your profile has been updated successfully.");
	    exit();
            }
            else {
	    header('location: profile.php?error=Failed to change the profile...');
            exit();
            }
    }
}
?>

<h4>Edit profile</h4>
<div class="edit-content">
    
    <form method="post">
        <div id="first-column">
        <label>User full name</label>
     	<input type="text" name="user_full_name" value="<?php echo $record['user_full_name']; ?>"><br>
        
        <label>Username</label>
     	<input type="text" name="user_username" value="<?php echo $record['user_username']; ?>"><br>
        
        <label>User e-mail</label>
     	<input type="email" name="user_email" value="<?php echo $record['user_email']; ?>"><br>
        </div>
        <div id="second-column">
            <div id="type-and-status">
        <label for="user_type" id="type-label">User type:</label>
  <?php
  $type_values = array( 'Manager', 'Waiter', 'Bartender' );
  
  echo '<select name="user_type">';
  foreach( $type_values as $key => $value )
  {
    echo '<option value="'.$value.'"';
    echo '>'.$value.'</option>';
  }
  echo '</select>';
  ?>  
  <br>
  
  <label for="user_status" id="status-label">User status:</label>
  <?php
  $status_values = array( 'Enable', 'Disable' );
  
  echo '<select name="user_status">';
  foreach( $status_values as $key => $value )
  {
    echo '<option value="'.$value.'"';
    echo '>'.$value.'</option>';
  }
  echo '</select>';
  ?>  
  <br>
  </div>
  <label>Password</label>
  <input type="password" name="user_password" placeholder="Enter password..."><br>
        
  <label>Confirm the password</label>
  <input type="password" name="password_check" placeholder="Confirm the password..."><br>
        </div>
        
        <?php if (isset($_GET['error'])) { ?>
     		<p id="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
        <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>
        
               <div id="submit-area">
        <span id="change-password"><a href="profile_password_change.php">Change password</a></span>
     	<button type="submit" id="submit-button">Edit profile</button>
               </div> 
     </form> 
    
</div>

<?php
       require_once 'partials/footer.php';
?>