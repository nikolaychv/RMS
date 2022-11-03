<?php
require_once "config_mysql.php";
session_start();

function get_time()
{
    date_default_timezone_set("Europe/Sofia");
    return date("Y-m-d H:i:s",  STRTOTIME(date('h:i:sa')));
}

function validate_data($data_to_validate){
           global $connection;
           $data_to_validate = mysqli_real_escape_string($connection, $data_to_validate);
	   return $data_to_validate;
	}

if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $the_username = validate_data($_POST['user_username']);
      $the_password = validate_data($_POST['user_password']); // we don't hash the password
      $the_password_check = validate_data($_POST['password_check']);
      $the_user_full_name = validate_data($_POST['user_full_name']);
      $the_user_email = validate_data($_POST['user_email']);
      $the_user_type = $_POST['user_type'];
      $the_user_status = $_POST['user_status'];
      $the_time_creation = get_time();
      $the_user_restaurant_id = $_SESSION['user_restaurant_id'];
      
        if (empty($the_username)) {
	    header("location: add_user.php?error=Username is required.");
	    exit();
	}
        else if (empty($the_password)){
            header("location: add_user.php?error=Password is required.");
	    exit();
	}
	else if(empty($the_password_check)){
            header("location: add_user.php?error=Confirm the password.");
	    exit();
	}
        else if(empty($the_user_full_name)){
        header("location: add_user.php?error=Full name is required.");
	    exit();
	}
        else if (empty($the_user_email)){
            header("location: add_user.php?error=User e-mail is required.");
	    exit();
	}
        else if($the_password !== $the_password_check){
        header("location: add_user.php?error=The passwords do not match.");
	    exit();
	}
        
        if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["user_username"]))){
        header("location: add_user.php?error=Username can only contain letters, numbers, and underscores.");
	    exit();
        }
        
      else{
                $sql = "SELECT * FROM tbl_user WHERE user_username='$the_username' AND user_restaurant_id = '$the_user_restaurant_id'";
                $result = mysqli_query($connection, $sql);
                $count = mysqli_num_rows($result);
                
		if ($count > 0) {
			header("location: add_user.php?error=The username is taken from another user.");
	                exit();
		}
                else {
               
               $first_sql = "INSERT INTO tbl_user(user_username, user_password, user_full_name, user_email, user_type, user_status, user_creation, user_restaurant_id) "
                       . "VALUES('$the_username', '$the_password', '$the_user_full_name', '$the_user_email', '$the_user_type', '$the_user_status', '$the_time_creation', '$the_user_restaurant_id')";
               $first_result = mysqli_query($connection, $first_sql);
   
               
                 if ($first_result) {
           	 header("location: add_user.php?success=Your account has been created successfully.");
	         exit();
                 }
                 else {
	           	header("location: add_user.php?error=Error!");
		        exit();
                   }
		}
}
}
else {
    header('location: users.php');
    exit();
}

?>