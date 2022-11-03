<?php
require_once "config_mysql.php";
session_start();

function validate_data($data_to_validate){
           global $connection;
           $data_to_validate = mysqli_real_escape_string($connection, $data_to_validate);
	   return $data_to_validate;
	}

if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $the_table_name = validate_data($_POST['rt_name']);
      $the_table_capacity = validate_data($_POST['rt_capacity']);
      $is_booked_table = $_POST['rt_is_booked'];
      $the_table_status = $_POST['rt_status'];
      
        if (empty($the_table_name)) {
	    header("location: add_table.php?error=Table name is required.");
	    exit();
	}
        else if (empty($the_table_capacity)){
            header("location: add_table.php?error=Table capacity is required.");
	    exit();
	}
        else {
                $the_session_restaurant_id = $_SESSION['user_restaurant_id'];
                $sql = "SELECT * FROM tbl_restaurant_tables WHERE rt_name='$the_table_name' AND rt_restaurant_id = '$the_session_restaurant_id'";
                $result = mysqli_query($connection, $sql);
                $count = mysqli_num_rows($result);
                
		if ($count > 0) {
			header("location: add_table.php?error=The table name is taken.");
	                exit();
		}
                else {
               
               $first_sql = "INSERT INTO tbl_restaurant_tables(rt_name, rt_capacity, rt_status, rt_is_booked, rt_restaurant_id) "
                       . "VALUES('$the_table_name', '$the_table_capacity', '$the_table_status', '$is_booked_table', '$the_session_restaurant_id')";
               $first_result = mysqli_query($connection, $first_sql);
   
               
                 if ($first_result) {
           	 header("location: add_table.php?success=The table has been created successfully.");
	         exit();
                 }
                 else {
	           	header("location: add_table.php?error=Error");
		        exit();
                   }
		}
}
}
else {
    header('location: tables.php');
    exit();
}

?>