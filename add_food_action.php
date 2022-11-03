<?php
require_once "config_mysql.php";
session_start();

function validate_data($data_to_validate){
           global $connection;
           $data_to_validate = mysqli_real_escape_string($connection, $data_to_validate);
	   return $data_to_validate;
	}

if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $the_food_name = validate_data($_POST['foods_name']);
      $the_food_category = $_POST['foods_category'];
      $the_food_price = validate_data($_POST['foods_price']);
      $the_food_status = $_POST['foods_status'];
      $the_food_restaurant_id = $_SESSION['user_restaurant_id'];
      
        if (empty($the_food_name)) {
	    header("location: add_food.php?error=Food name is required.");
	    exit();
	}
        else if (empty($the_food_price)){
            header("location: add_food.php?error=Food price is required.");
	    exit();
	}
        else {
                $sql = "SELECT * FROM tbl_foods WHERE foods_name='$the_food_name' AND foods_restaurant_id = '$the_food_restaurant_id'";
                $result = mysqli_query($connection, $sql);
                $count = mysqli_num_rows($result);
                
		if ($count > 0) {
			header("location: add_food.php?error=The food name is taken.");
	                exit();
		}
                else {
               
               $first_sql = "INSERT INTO tbl_foods(foods_name, foods_category, foods_price, foods_status, foods_restaurant_id) "
                       . "VALUES('$the_food_name', '$the_food_category', '$the_food_price', '$the_food_status', '$the_food_restaurant_id')";
               $first_result = mysqli_query($connection, $first_sql);
   
               
                 if ($first_result) {
           	 header("location: add_food.php?success=The food has been created successfully.");
	         exit();
                 }
                 else {
	           	header("location: add_food.php?error=Error");
		        exit();
                   }
		}
}
}
else {
    header('location: foods.php');
    exit();
}

?>