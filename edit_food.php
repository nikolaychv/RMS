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
  $query = 'SELECT * FROM tbl_foods WHERE foods_id = '.$_GET['edit_id'].' LIMIT 1';
  $result = mysqli_query($connection, $query);
  
  if(!mysqli_num_rows($result))
  {
    header('location: foods.php?error=Failed to change the selected food...');
    exit(); 
  }
  $record = mysqli_fetch_assoc($result);
} else {
    header('location: foods.php?error=Failed to change the selected food...');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if ($_POST['foods_name'] != null && $_POST['foods_category'] != null && $_POST['foods_price'] != null) {
      
      $the_food_name = validate_data($_POST['foods_name']);
      $the_food_category = $_POST['foods_category'];
      $the_food_price = validate_data($_POST['foods_price']);
      $the_food_status = $_POST['foods_status'];
               
        $first_sql = 'UPDATE tbl_foods SET '
                . 'foods_name = "'.$the_food_name.'", '
                . 'foods_category = "'.$the_food_category.'",'
                . 'foods_price = "'.$the_food_price.'", '
                . 'foods_status = "'.$the_food_status.'"'
                . 'WHERE foods_id = '.$_GET['edit_id'].' LIMIT 1';
                       
        $first_result = mysqli_query($connection, $first_sql);
               
            if ($first_result) {
            header("location: foods.php?success=The food has been updated successfully.");
	    exit();
            }
            else {
	    header('location: foods.php?error=Failed to change the selected food...');
            exit();
            }
    }
}

$first_query = 'SELECT * FROM tbl_category WHERE category_restaurant_id = '.$_SESSION['user_restaurant_id'].'';
$first_result = mysqli_query($connection, $first_query);
?>

<h4>Edit foods</h4>
<div class="edit-content">
    
    <form method="post">
        <div id="foods-content">
        <label>Food name</label>
        <input type="text" name="foods_name" value="<?php echo $record['foods_name'] ; ?>"><br>
        
        <div id="food-table-category">
        <label id="food-category-label">Food category</label>
            <select id="food-category-table" name="foods_category">;
            <?php while($first_row = mysqli_fetch_array($first_result)):;?>
            <option value="<?php echo $first_row['category_name']; $_SESSION['category_name_to_add'] = $first_row['category_name'];?>"><?php echo $first_row['category_name'];?></option>
            <?php endwhile;?>
            </select>
        
  <label for="foods_status" id="food-status-label">Food status:</label>
  <?php
  $status_values = array( 'Enable', 'Disable' );
  
  echo '<select name="foods_status">';
  foreach( $status_values as $key => $value )
  {
    echo '<option value="'.$value.'"';
    echo '>'.$value.'</option>';
  }
  echo '</select>';
  ?>  
  <br>
        </div>
        
        <label id="food-price-label">Food price</label>
        <input type="number" step="0.01" min="0" name="foods_price" value="<?php echo $record['foods_price']; ?>"><br>
        
        </div>
     
        <?php if (isset($_GET['error'])) { ?>
     		<p id="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
        <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>
        
               <div id="submit-area">
        <a href="foods.php"><img id="go-back-image" src="images/go-back-image.png" alt="Go back"></a>
     	<button type="submit" id="submit-button">Edit food</button>
               </div> 
     </form> 
    
</div>

<?php
       require_once 'partials/footer.php';
?>