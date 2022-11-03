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
       
if(isset($_GET['edit_id']))
{
  $query = 'SELECT * FROM tbl_orders WHERE order_id = '.$_GET['edit_id'].' LIMIT 1';
  $result = mysqli_query($connection, $query);
  
  if(!mysqli_num_rows($result))
  {
    header('location: billing.php?error=Failed to change the selected order...');
    exit(); 
  }
  $record = mysqli_fetch_assoc($result);
} else {
    header('location: billing.php?error=Failed to change the selected order...');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if ($_POST['order_net_amount'] != null) {
      
      $the_order_net_amount = validate_data($_POST['order_net_amount']);
      $the_order_table_name = $_POST['order_table'];
      $the_order_serving_name = $_POST['order_serving'];
      $the_order_status = $_POST['order_status'];
               
        $the_sql = 'UPDATE tbl_orders SET order_net_amount = "'.$the_order_net_amount.'", 
                                          order_table = "'.$the_order_table_name.'", 
                                          order_serving = "'.$the_order_serving_name.'", order_status = "'.$the_order_status.'"
                                          WHERE order_id = '.$_GET['edit_id'].' LIMIT 1';
                       
        $the_result = mysqli_query($connection, $the_sql);
               
            if ($the_result) {
            header("location: billing.php?success=The order has been updated successfully.");
	    exit();
            }
            else {
	    header('location: billing.php?error=Failed to change the selected order...');
            exit();
            }
    }
}
$first_query = 'SELECT * FROM tbl_restaurant_tables WHERE rt_restaurant_id = '.$_SESSION['user_restaurant_id'].'';
$first_result = mysqli_query($connection, $first_query);

$second_query = 'SELECT * FROM tbl_user WHERE user_restaurant_id = '.$_SESSION['user_restaurant_id'].'';
$second_result = mysqli_query($connection, $second_query);
?>

<h4>Edit order</h4>
<div class="edit-content">
    
    <form method="post">
        <div id="order-table-name">
        <label id="order-table-label">Table name</label>
            <select id="bill-food-table" name="order_table">;
            <?php while($first_row = mysqli_fetch_array($first_result)):;?>
            <option value="<?php echo $first_row['rt_name']; $_SESSION['table_name_to_add'] = $first_row['rt_name'];?>"><?php echo $first_row['rt_name'];?></option>
            <?php endwhile;?>
            </select>
        </div>
        
        <div id="order-serving-name">
        <label id="order-serving-label">Serving name</label>
            <select id="bill-serving-name" name="order_serving">;
            <?php while($second_row = mysqli_fetch_array($second_result)):;?>
            <option value="<?php echo $second_row['user_full_name']; $_SESSION['user_name_to_add'] = $second_row['user_full_name'];?>"><?php echo $second_row['user_full_name'];?></option>
            <?php endwhile;?>
            </select>
        </div>
        
   <label for="order_status" id="order-status-label">Order status:</label>
  <?php
  $order_values = array( 'In process', 'Completed' );
  
  echo '<select name="order_status">';
  foreach( $order_values as $key => $value )
  {
    echo '<option value="'.$value.'"';
    echo '>'.$value.'</option>';
  }
  echo '</select>';
  ?>  
  <br>
  
  <label>Order net amount</label>
  <input type="number" step="0.01" min="0" name="order_net_amount" value="<?php echo $record['order_net_amount']; ?>"><br>
        
        
        
        <?php if (isset($_GET['error'])) { ?>
     		<p id="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
        <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>
        
               <div id="submit-area">
        <a href="billing.php"><img id="go-back-image" src="images/go-back-image.png" alt="Go back"></a>
     	<button type="submit" id="submit-button">Edit order</button>
               </div> 
     </form> 
    
</div>

<?php
       require_once 'partials/footer.php';
?>