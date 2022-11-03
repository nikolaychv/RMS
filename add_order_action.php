<?php
require_once "config_mysql.php";
session_start();

date_default_timezone_set("Europe/Sofia");

function get_time()
{
    return date('H:i:s');
}

function get_date()
{
    return date("Y-m-d");
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $the_order_table = $_POST['order_table'];
      $the_order_time = get_time();
      $the_order_date = get_date();
      $the_order_serving = $_SESSION['user_full_name'];
      $the_order_status = 'In process';
      $the_order_net_amount = 0.0;
      $the_order_restaurant_id = $_SESSION['user_restaurant_id'];
      
      $first_sql = "INSERT INTO tbl_orders(order_table, order_time, order_date, order_serving, order_status, order_net_amount, order_restaurant_id) "
                . "VALUES('$the_order_table', '$the_order_time', '$the_order_date', '$the_order_serving', '$the_order_status', '$the_order_net_amount', '$the_order_restaurant_id')";
      $first_result = mysqli_query($connection, $first_sql);
               
      if ($first_result) {
        header("location: add_order.php?success=Your order has been created successfully.");
	exit();
      }
      else {
	header("location: add_order.php?error=Error");
        exit();
      }
      
}
else {
    header('location: billing.php');
    exit();
}

?>