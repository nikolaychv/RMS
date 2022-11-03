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
       
if(isset($_SESSION['user_restaurant_id']))
{
  $query = 'SELECT * FROM tbl_restaurant WHERE restaurant_id = '.$_SESSION['user_restaurant_id'].' LIMIT 1';
  $result = mysqli_query($connection, $query);
  
  if(!mysqli_num_rows($result))
  {
    header('location: restaurant_info.php?error=Failed to change restaurant information...');
    exit(); 
  }
  $record = mysqli_fetch_assoc($result);
} else {
    header('location: restaurant_info.php?error=Failed to change restaurant information...');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if ($_POST['restaurant_name'] != null && 
        $_POST['restaurant_telephone'] != null && 
        $_POST['restaurant_address'] != null && 
        $_POST['restaurant_email'] != null) {
      
      $the_restaurant_name = validate_data($_POST['restaurant_name']);
      $the_restaurant_telephone = validate_data($_POST['restaurant_telephone']);
      $the_restaurant_address = validate_data($_POST['restaurant_address']);
      $the_restaurant_email = validate_data($_POST['restaurant_email']);
               
        $first_sql = 'UPDATE tbl_restaurant SET '
                . 'restaurant_name = "'.$the_restaurant_name.'", '
                . 'restaurant_telephone = "'.$the_restaurant_telephone.'",'
                . 'restaurant_address = "'.$the_restaurant_address.'", '
                . 'restaurant_email = "'.$the_restaurant_email.'"'
                . 'WHERE restaurant_id = '.$_SESSION['user_restaurant_id'].' LIMIT 1';
                       
        $first_result = mysqli_query($connection, $first_sql);
               
            if ($first_result) {
            header("location: restaurant_info.php?success=The restaurant has been updated successfully.");
	    exit();
            }
            else {
	    header('location: restaurant_info.php?error=Failed to change restaurant information...');
            exit();
            }
    }
}
?>

<h4>Edit restaurant</h4>
<div class="edit-content">
    
    <form id="restaurant-form" method="post">
        <div id="restaurant-content">
        <label>Restaurant name</label>
     	<input type="text" name="restaurant_name" value="<?php echo htmlentities( $record['restaurant_name'] ); ?>"><br>
        
        <label>Restaurant telephone</label>
     	<input type="text" name="restaurant_telephone" value="<?php echo htmlentities( $record['restaurant_telephone'] ); ?>"><br>
        
        <label>Restaurant address</label>
     	<input type="text" name="restaurant_address" value="<?php echo htmlentities( $record['restaurant_address'] ); ?>"><br>
        
        <label>Restaurant e-mail</label>
     	<input type="email" name="restaurant_email" value="<?php echo htmlentities( $record['restaurant_email'] ); ?>"><br>
        </div>
        
        <?php if (isset($_GET['error'])) { ?>
     		<p id="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
        <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>
        
               <div id="submit-area">
     	<button type="submit" id="submit-button">Edit restaurant</button>
               </div> 
     </form> 
    
</div>

<?php
       require_once 'partials/footer.php';
?>