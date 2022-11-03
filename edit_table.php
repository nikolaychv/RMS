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
  $query = 'SELECT * FROM tbl_restaurant_tables WHERE rt_id = '.$_GET['edit_id'].' LIMIT 1';
  $result = mysqli_query($connection, $query);
  
  if(!mysqli_num_rows($result))
  {
    header('location: tables.php?error=Failed to change the selected table...');
    exit(); 
  }
  $record = mysqli_fetch_assoc($result);
} else {
    header('location: tables.php?error=Failed to change the selected table...');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if ($_POST['rt_name'] != null && $_POST['rt_capacity'] != null) {
      
      $the_table_name = validate_data($_POST['rt_name']);
      $the_table_capacity = validate_data($_POST['rt_capacity']);
      $is_booked_table = $_POST['rt_is_booked'];
      $the_table_status = $_POST['rt_status'];
               
        $first_sql = 'UPDATE tbl_restaurant_tables SET '
                . 'rt_name = "'.$the_table_name.'", '
                . 'rt_capacity = "'.$the_table_capacity.'",'
                . 'rt_is_booked = "'.$is_booked_table.'", '
                . 'rt_status = "'.$the_table_status.'"'
                . 'WHERE rt_id = '.$_GET['edit_id'].' LIMIT 1';
                       
        $first_result = mysqli_query($connection, $first_sql);
               
            if ($first_result) {
            header("location: tables.php?success=Your table has been updated successfully.");
	    exit();
            }
            else {
	    header('location: tables.php?error=Failed to change the selected table...');
            exit();
            }
    }
}
?>

<h4>Edit table</h4>
<div class="edit-content">
    
    <form method="post">
        <div id="table-content">
        <label>Table name</label>
        <input type="text" name="rt_name" value="<?php echo $record['rt_name']; ?>"><br>
        
        <label>Table capacity</label>
        <input type="number" name="rt_capacity" value="<?php echo $record['rt_capacity']; ?>"><br>
        
        <div id="is-booked-and-status">
        <div id="first-column">
        <label for="rt_is_booked" id="is-booked-label">Is booked:</label>
  <?php
  $is_booked_values = array( 'Yes', 'No' );
  
  echo '<select name="rt_is_booked">';
  foreach( $is_booked_values as $key => $value )
  {
    echo '<option value="'.$value.'"';
    echo '>'.$value.'</option>';
  }
  echo '</select>';
  ?>  
  <br>
        </div>  
        <div id="second-column">
  <label for="rt_status" id="table-status-label">Table status:</label>
  <?php
  $status_values = array( 'Enable', 'Disable' );
  
  echo '<select name="rt_status">';
  foreach( $status_values as $key => $value )
  {
    echo '<option value="'.$value.'"';
    echo '>'.$value.'</option>';
  }
  echo '</select>';
  ?>  
  <br>
  </div>
        </div>
        </div>
     
        <?php if (isset($_GET['error'])) { ?>
     		<p id="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
        <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>
        
               <div id="submit-area">
        <a href="tables.php"><img id="go-back-image" src="images/go-back-image.png" alt="Go back"></a>
     	<button type="submit" id="submit-button">Edit table</button>
               </div> 
     </form> 
    
</div>

<?php
       require_once 'partials/footer.php';
?>