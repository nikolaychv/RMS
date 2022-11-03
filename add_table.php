<?php
       require_once 'config_mysql.php';
       session_start();
       
       if(!isset($_SESSION['user_id'])) {
           header('location: index.php');
           exit();
       }
       
       require_once 'partials/header.php';
?>
<h4>Add table</h4>
<div class="add-content">
    <form action="add_table_action.php" method="post">
        <div id="table-content">
        <label>Table name</label>
     	<input type="text" name="rt_name" placeholder="Enter table name..."><br>
        
        <label>Table capacity</label>
     	<input type="number" name="rt_capacity" placeholder="Enter table capacity..."><br>
        
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
     	<button type="submit" id="submit-button">Add table</button>
               </div> 
     </form> 
    
</div>

<?php
       require_once 'partials/footer.php';
?>