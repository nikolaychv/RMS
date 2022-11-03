<?php
       require_once 'config_mysql.php';
       session_start();
       
       if(!isset($_SESSION['user_id'])) {
           header('location: index.php');
           exit();
       }
       
       require_once 'partials/header.php';
?>
<h4>Add user</h4>
<div class="add-content">
    <form action="add_user_action.php" method="post">
        <div id="first-column">
        <label>User full name</label>
     	<input type="text" name="user_full_name" placeholder="Enter full name..."><br>
        
        <label>Username</label>
     	<input type="text" name="user_username" placeholder="Enter username..."><br>
        
        <label>User e-mail</label>
     	<input type="email" name="user_email" placeholder="Enter email..."><br>
        </div>
        <div id="second-column">
            <div id="type-and-status">
        <label for="user_type" id="type-label">User type:</label>
  <?php
  $type_values = array( 'Manager', 'Waiter', 'Bartender' );
  
  echo '<select name="user_type">';
  foreach( $type_values as $key => $value )
  {
    echo '<option value="'.$value.'"';
    echo '>'.$value.'</option>';
  }
  echo '</select>';
  ?>  
  <br>
  
  <label for="user_status" id="status-label">User status:</label>
  <?php
  $status_values = array( 'Enable', 'Disable' );
  
  echo '<select name="user_status">';
  foreach( $status_values as $key => $value )
  {
    echo '<option value="'.$value.'"';
    echo '>'.$value.'</option>';
  }
  echo '</select>';
  ?>  
  <br>
  </div>
  <label>Password</label>
  <input type="password" name="user_password" placeholder="Enter password..."><br>
        
  <label>Confirm the password</label>
  <input type="password" name="password_check" placeholder="Confirm the password..."><br>
        </div>
        <?php if (isset($_GET['error'])) { ?>
     		<p id="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
        <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>
        
               <div id="submit-area">
        <a href="users.php"><img id="go-back-image" src="images/go-back-image.png" alt="Go back"></a>
     	<button type="submit" id="submit-button">Add user</button>
               </div> 
     </form> 
    
</div>

<?php
       require_once 'partials/footer.php';
?>