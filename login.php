<?php
include("config_mysql.php");
session_start();

function validate_data($data_to_validate){
           global $connection;
           $data_to_validate = mysqli_real_escape_string($connection, $data_to_validate);
	   return $data_to_validate;
	}

if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $the_username = validate_data($_POST['user_username']);
      $the_password = validate_data($_POST['user_password']);
      
      if (empty($the_username)) {
	    header("location: index.php?error=Username is required.");
	    exit();
	}
      else if (empty($the_password)){
            header("location: index.php?error=Password is required.");
	    exit();
	}
      else{
            $sql = "SELECT * FROM tbl_user WHERE user_username='$the_username' AND user_password='$the_password'";
            $result = mysqli_query($connection, $sql);
            $count = mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);
            
            if ($count === 1) {
                if ($row['user_username'] === $the_username && $row['user_password'] === $the_password) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_full_name'] = $row['user_full_name'];
            	$_SESSION['user_username'] = $row['user_username'];
                $_SESSION['user_restaurant_id'] = $row['user_restaurant_id'];
                $_SESSION['user_type'] = $row['user_type'];
            	header("location: tables.php");
		exit();
            }
            }
            else{
	            header("Location: index.php?error=Incorrect username or password");
		    exit();
		}
	}
}
else{
	header("location: index.php");
	exit();
}
?>