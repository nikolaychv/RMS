<?php
require_once "config_mysql.php";
session_start();

function validate_data($data_to_validate){
           global $connection;
           $data_to_validate = mysqli_real_escape_string($connection, $data_to_validate);
	   return $data_to_validate;
	}

if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $the_category_name = validate_data($_POST['category_name']);
      $is_vegetarian_category = $_POST['category_is_vegetarian'];
      $the_category_status = $_POST['category_status'];
      $the_category_restaurant_id = $_SESSION['user_restaurant_id'];
      
        if (empty($the_category_name)) {
	    header("location: add_category.php?error=Category name is required.");
	    exit();
	}
        else {
                $sql = "SELECT * FROM tbl_category WHERE category_name='$the_category_name' AND category_restaurant_id = '$the_category_restaurant_id'";
                $result = mysqli_query($connection, $sql);
                $count = mysqli_num_rows($result);
                
		if ($count > 0) {
			header("location: add_category.php?error=The category name is taken.");
	                exit();
		}
                else {
               
               $first_sql = "INSERT INTO tbl_category(category_name, category_is_vegetarian, category_status, category_restaurant_id) "
                       . "VALUES('$the_category_name', '$is_vegetarian_category', '$the_category_status', $the_category_restaurant_id)";
               $first_result = mysqli_query($connection, $first_sql);
   
               
                 if ($first_result) {
           	 header("location: add_category.php?success=The category has been created successfully.");
	         exit();
                 }
                 else {
	           	header("location: add_category.php?error=Error");
		        exit();
                   }
		}
}
}
else {
    header('location: category.php');
    exit();
}

?>