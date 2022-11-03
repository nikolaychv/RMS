<?php
require_once "config_mysql.php";
session_start();

function get_time()
{
    date_default_timezone_set("Europe/Sofia");
    return date("Y-m-d H:i:s",  STRTOTIME(date('h:i:sa')));
}

function validate_data($data_to_validate){
        /*
            $data_to_validate = trim($data_to_validate);
            $data_to_validate = stripslashes($data_to_validate);
            $data_to_validate = htmlspecialchars($data_to_validate);
            return $data_to_validate;
         */
        
           global $connection;
           $data_to_validate = mysqli_real_escape_string($connection, $data_to_validate);
	   return $data_to_validate;
	}

if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $the_username = validate_data($_POST['user_username']);
      $the_password = validate_data($_POST['user_password']); // we don't hash the password
      $the_password_check = validate_data($_POST['password_check']);
      /*
       * We can do:
       *  $the_password = md5(validate_data($_POST['user_password'])); 
       * $the_password_check = md5(validate_data($_POST['password_check']));
       */
      $the_user_full_name = validate_data($_POST['user_full_name']);
      $the_user_email = validate_data($_POST['user_email']);
      $the_time_creation = get_time();
      
      $the_restaurant_name = trim($_POST['restaurant_name']);
      $the_restaurant_telephone = trim($_POST['restaurant_telephone']);
      $the_restaurant_email = trim($_POST['restaurant_email']);
      $the_restaurant_address = trim($_POST['restaurant_address']);
      
      if (empty($the_username)) {
	    header("location: sign_up_page.php?error=Username is required.");
	    exit();
	}
        else if (empty($the_password)){
            header("location: sign_up_page.php?error=Password is required.");
	    exit();
	}
	else if(empty($the_password_check)){
            header("location: sign_up_page.php?error=Confirm the password.");
	    exit();
	}
        else if(empty($the_user_full_name)){
            header("location: sign_up_page.php?error=Full name is required.");
	    exit();
	}
        else if (empty($the_user_email)){
            header("location: sign_up_page.php?error=User e-mail is required.");
	    exit();
	}
	else if(empty($the_restaurant_name)){
            header("location: sign_up_page.php?error=Restaurant name is required.");
	    exit();
	}
        else if (empty($the_restaurant_telephone)){
            header("location: sign_up_page.php?error=Restaurant telephone is required.");
	    exit();
	}
	else if(empty($the_restaurant_email)){
            header("location: sign_up_page.php?error=Restaurant e-mail is required.");
	    exit();
	}
        else if(empty($the_restaurant_address)){
            header("location: sign_up_page.php?error=Restaurant address is required.");
	    exit();
	}
        else if($the_password !== $the_password_check){
            header("location: sign_up_page.php?error=The passwords do not match.");
	    exit();
	}
        
        if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["user_username"]))){
            header("location: sign_up_page.php?error=Username can only contain letters, numbers, and underscores.");
	    exit();
      }
        
      else{
                $sql = "SELECT * FROM tbl_user WHERE user_username='$the_username'";
                $result = mysqli_query($connection, $sql);
                $count = mysqli_num_rows($result);
                
		if ($count > 0) {
			header("location: sign_up_page.php?error=The username is taken from another user.");
	                exit();
		}
                else {                  
               $first_sql = "INSERT INTO tbl_restaurant(restaurant_name, restaurant_telephone, restaurant_email, restaurant_address)"
                       . "VALUES('$the_restaurant_name', '$the_restaurant_telephone', '$the_restaurant_email', '$the_restaurant_address')";
               $first_result = mysqli_query($connection, $first_sql);    
               
               $the_restaurant_id = mysqli_insert_id($connection);
               $second_sql = "INSERT INTO tbl_user(user_username, user_password, user_full_name, user_email, user_creation, user_restaurant_id) "
                       . "VALUES('$the_username', '$the_password', '$the_user_full_name', '$the_user_email', '$the_time_creation', '$the_restaurant_id')";
               $second_result = mysqli_query($connection, $second_sql);
               
                 if ($first_result && $second_result) {
           	 header("location: sign_up_page.php?success=Your account has been created successfully.");
	         exit();
                 }
                 else {
	           	header("location: sign_up_page.php?error=Error");
		        exit();
                   }
		}
	}
}
else{
	header("location: sign_up_page.php");
	exit();
}
?>