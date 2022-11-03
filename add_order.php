<?php
       require_once 'config_mysql.php';
       session_start();
       
       if(!isset($_SESSION['user_id'])) {
           header('location: index.php');
           exit();
       }
       
       require_once 'partials/header.php';
       
       $first_query = 'SELECT * FROM tbl_restaurant_tables WHERE rt_restaurant_id = '.$_SESSION['user_restaurant_id'].'';
       $first_result = mysqli_query($connection, $first_query);
?>
<h4>Add order</h4>
<div class="add-content">
    <form action="add_order_action.php" method="post">
        <div id="order-content">
            <label id="order-label">Order table</label>
            <select id="order-table" name="order_table">;
            <?php while($first_row = mysqli_fetch_array($first_result)):;?>
            <option value="<?php echo $first_row['rt_name'];?>"><?php echo $first_row['rt_name'];?></option>
            <?php endwhile;?>
             </select>
        </div>
        
        <?php if (isset($_GET['error'])) { ?>
     		<p id="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
        <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>
        
               <div id="submit-area">
        <a href="billing.php"><img id="go-back-image" src="images/go-back-image.png" alt="Go back"></a>
     	<button type="submit" id="submit-button">Add order</button>
               </div> 
     </form> 
    
</div>

<?php
       require_once 'partials/footer.php';
?>