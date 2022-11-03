<?php
       require_once 'config_mysql.php';
       session_start();
       
       if(!isset($_SESSION['user_id'])) {
           header('location: index.php');
           exit();
       }
       
       require_once 'partials/header.php';
?>
<h4>Add category</h4>
<div class="add-content">
    <form action="add_category_action.php" method="post">
        <div id="category-content">
        <label>Category name</label>
     	<input type="text" name="category_name" placeholder="Enter category name..."><br>
        
        <div id="is-vegetarian-and-status">
        <div id="first-column">
        <label for="category_is_vegetarian" id="is-vegetarian-label">Is vegetarian:</label>
  <?php
  $is_vegetarian_values = array( 'Yes', 'No' );
  
  echo '<select name="category_is_vegetarian">';
  foreach( $is_vegetarian_values as $key => $value )
  {
    echo '<option value="'.$value.'"';
    echo '>'.$value.'</option>';
  }
  echo '</select>';
  ?>  
  <br>
        </div>  
        <div id="second-column">
  <label for="category_status" id="table-status-label">Category status:</label>
  <?php
  $status_values = array( 'Enable', 'Disable' );
  
  echo '<select name="category_status">';
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
        <a href="category.php"><img id="go-back-image" src="images/go-back-image.png" alt="Go back"></a>
     	<button type="submit" id="submit-button">Add category</button>
               </div> 
     </form> 
    
</div>

<?php
       require_once 'partials/footer.php';
?>