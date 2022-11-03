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
  $query = 'SELECT * FROM tbl_category WHERE category_id = '.$_GET['edit_id'].' LIMIT 1';
  $result = mysqli_query($connection, $query);
  
  if(!mysqli_num_rows($result))
  {
    header('location: category.php?error=Failed to change the selected category...');
    exit(); 
  }
  $record = mysqli_fetch_assoc($result);
} else {
    header('location: category.php?error=Failed to change the selected category...');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if ($_POST['category_name'] != null) {
      
      $the_category_name = validate_data($_POST['category_name']);
      $is_vegetarian_category = $_POST['category_is_vegetarian'];
      $the_category_status = $_POST['category_status'];
               
        $first_sql = 'UPDATE tbl_category SET '
                . 'category_name = "'.$the_category_name.'", '
                . 'category_is_vegetarian = "'.$is_vegetarian_category.'", '
                . 'category_status = "'.$the_category_status.'"'
                . 'WHERE category_id = '.$_GET['edit_id'].' LIMIT 1';
                       
        $first_result = mysqli_query($connection, $first_sql);
               
            if ($first_result) {
            header("location: category.php?success=Your category has been updated successfully.");
	    exit();
            }
            else {
	    header('location: category.php?error=Failed to change the selected category...');
            exit();
            }
    }
}
?>

<h4>Edit category</h4>
<div class="edit-content">
    
    <form method="post">
        <div id="category-content">
        <label>Category name</label>
        <input type="text" name="category_name" value="<?php echo $record['category_name']; ?>"><br>
        
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
     	<button type="submit" id="submit-button">Edit category</button>
               </div> 
     </form> 
    
</div>

<?php
       require_once 'partials/footer.php';
?>