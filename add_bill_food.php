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
       
    if($_SERVER["REQUEST_METHOD"] == "POST") {
    
      $the_bill_order_id = $_GET['bill_id'];
      $the_bill_food_id = validate_data($_POST['bill_food_name']);
      $the_bill_food_quantity = validate_data($_POST['bill_food_quantity']);
      $the_bill_restaurant_id = $_SESSION['user_restaurant_id'];
      
      $query = 'SELECT * FROM tbl_foods WHERE foods_restaurant_id = '.$_SESSION['user_restaurant_id'].''
              . ' AND foods_id = '.$the_bill_food_id.'';
      $result = mysqli_query($connection, $query);
      $row = mysqli_fetch_assoc($result);
      $the_bill_food_rate = $row['foods_price'];
      $the_bill_food_name = $row['foods_name']; 
      
      $the_bill_food_amount = $the_bill_food_quantity * $the_bill_food_rate;
      
      $first_sql = "INSERT INTO tbl_bills(bill_order_id, bill_food_name, bill_food_quantity, bill_food_rate, bill_food_amount, bill_restaurant_id) "
                . "VALUES('$the_bill_order_id', '$the_bill_food_name', '$the_bill_food_quantity', '$the_bill_food_rate', ' $the_bill_food_amount', '$the_bill_restaurant_id')";
      $first_result = mysqli_query($connection, $first_sql);
               
      $the_bill_id = $_GET['bill_id'];
      if ($first_result) {
        header("location: bill.php?bill_id=$the_bill_id");
	exit();
      }
      else {
	header("location: bill.php?bill_id=$the_bill_id");
        exit();
      }
      
}      
       $first_query = 'SELECT * FROM tbl_foods WHERE foods_restaurant_id = '.$_SESSION['user_restaurant_id'].'';
       $first_result = mysqli_query($connection, $first_query);
?>
<h4>Add food in Bill No.<?php echo $_GET['bill_id'];?></h4>
<div class="add-content">
    <form method="post">
        <div id="bill-food-name">
        <label id="bill-food-label">Food name</label>
            <select id="bill-food-table" name="bill_food_name">;
            <?php while($first_row = mysqli_fetch_array($first_result)):;?>
            <option value="<?php echo $first_row['foods_id']; ?>"><?php echo $first_row['foods_name'];?></option>
            <?php endwhile;?>
            </select>
        </div>
        
        <label>Food quantity</label>
     	<input type="number" name="bill_food_quantity" placeholder="Enter food quantity..."><br>   
       
        <?php if (isset($_GET['error'])) { ?>
     		<p id="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
        <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>
        
               <div id="submit-area">
        <a href="bill.php?bill_id=<?php echo $_GET['bill_id']; ?>"><img id="go-back-image" src="images/go-back-image.png" alt="Go back"></a>
     	<button type="submit" id="submit-button">Add food</button>
               </div> 
     </form> 
    
</div>

<?php
       require_once 'partials/footer.php';
?>