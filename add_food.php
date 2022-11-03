<?php
       require_once 'config_mysql.php';
       session_start();
       
       if(!isset($_SESSION['user_id'])) {
           header('location: index.php');
           exit();
       }
       
       require_once 'partials/header.php';
       
$first_query = 'SELECT * FROM tbl_category WHERE category_restaurant_id = '.$_SESSION['user_restaurant_id'].'';
$first_result = mysqli_query($connection, $first_query);
?>
<h4>Add foods</h4>
<div class="add-content">
    <form action="add_food_action.php" method="post">
        <div id="foods-content">
        <label>Food name</label>
     	<input type="text" name="foods_name" placeholder="Enter food name..."><br>
        
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
     	<input type="number" step="0.01" min="0" name="foods_price" placeholder="Enter food price..."><br>      
        
        </div>
     
        <?php if (isset($_GET['error'])) { ?>
     		<p id="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
        <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>
        
               <div id="submit-area">
        <a href="foods.php"><img id="go-back-image" src="images/go-back-image.png" alt="Go back"></a>
     	<button type="submit" id="submit-button">Add food</button>
               </div> 
     </form> 
    
</div>

<?php
       require_once 'partials/footer.php';
?>