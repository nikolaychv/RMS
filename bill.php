<?php
       require_once 'config_mysql.php';
       session_start();
       
       if(!isset($_SESSION['user_id'])) {
           header('location: index.php');
           exit();
       }
       
       require_once 'partials/header.php';
       
       
if(isset($_GET['delete_food'])) {
  
  $first_query = 'DELETE FROM tbl_bills
    WHERE bill_food_id = '.$_GET['delete_food'].'
    LIMIT 1';
  mysqli_query($connection, $first_query);
  
  header('location: bill.php?bill_id='.$_SESSION['deleted_id'].'');
  exit();
  
}
    
?>

<?php if (isset($_GET['bill_id'])) { ?>
<h4>Bill No.<?php echo $_GET['bill_id'];?></h4>
<?php } else { ?>
<h4>Bill No.<?php echo $_SESSION['bill_id'];?></h4>
<?php } ?>

<?php 

if (isset($_GET['list_pages'])) {
    $list_pages = $_GET['list_pages'];
}
else {
    $list_pages = 1;
}

if (!isset($_SESSION['bill_id'])) {
$query = 'SELECT * FROM tbl_bills WHERE bill_order_id = '.$_GET['bill_id'].' AND bill_restaurant_id = '.$_SESSION['user_restaurant_id'].'';
$result = mysqli_query($connection, $query);
$all_bill = mysqli_num_rows($result);
}
else {
$query = 'SELECT * FROM tbl_bills WHERE bill_order_id = '.$_SESSION['bill_id'].' AND bill_restaurant_id = '.$_SESSION['user_restaurant_id'].'';
$result = mysqli_query($connection, $query);
$all_bill = mysqli_num_rows($result);
}
$elements_table = 5;
$pages = ceil($all_bill/$elements_table);

$first_element_of_page = ($list_pages - 1) * $elements_table;

if (!isset($_SESSION['bill_id'])) {
$query = 'SELECT * FROM tbl_bills WHERE bill_order_id = '.$_GET['bill_id'].' AND bill_restaurant_id = '.$_SESSION['user_restaurant_id'].' '
        . 'LIMIT ' . $first_element_of_page . ',' .  $elements_table;
$result = mysqli_query($connection, $query);
}
else {
$query = 'SELECT * FROM tbl_bills WHERE bill_order_id = '.$_SESSION['bill_id'].' AND bill_restaurant_id = '.$_SESSION['user_restaurant_id'].' '
        . 'LIMIT ' . $first_element_of_page . ',' .  $elements_table;
$result = mysqli_query($connection, $query);
}
?>

<div class="crud-content">
    <table border="1">
        <thead>
        <tr>
            <th>Food ID</th>
            <th>Food name</th>
            <th>Food quantity</th>
            <th>Food rate</th>
            <th>Food amount</th>
            <th>Action</th> 
        </tr>
        </thead>
        
        <?php while($record = mysqli_fetch_assoc($result)): ?>
         <tbody>
        <tr>
            <td><?php echo $record['bill_food_id'];?></td>
            <td><?php echo $record['bill_food_name'];?></td>
            <td><?php echo $record['bill_food_quantity'];?></td>
            <td><?php echo $record['bill_food_rate'];?></td>
            <td><?php echo $record['bill_food_amount'];?></td>
            <td>              
            <a href="bill.php?delete_food=<?php echo $record['bill_food_id']; $_SESSION['deleted_id'] = $_GET['bill_id']; ?>" onclick="javascript:confirm('Are you sure you want to delete this food?');">
            <img id="delete-image" src="images/delete-image.png" alt="Delete"></a>
            </td>
        </tr>
         </tbody>
        <?php endwhile; ?>
    </table>
   
    <div class="sum-bill">
        <?php
        $res = mysqli_query($connection, 'SELECT SUM(bill_food_amount) AS the_values FROM tbl_bills WHERE bill_order_id = '.$_GET['bill_id'].' AND bill_restaurant_id = '.$_SESSION['user_restaurant_id'].' '); 
        $the_row = mysqli_fetch_assoc($res); 
        $the_sum = $the_row['the_values'];
        $_SESSION['net_amount'] = $the_sum;
        ?>
        <a href="billing.php?bill_id=<?php 
        if (isset($_GET['bill_id'])) {
            $_SESSION['bill_id'] = $_GET['bill_id'];
            echo $_GET['bill_id'];
        }
        else {
            echo $_SESSION['bill_id'];
        } ?>">
        <img id="go-back-billing" src="images/go-back-image.png" alt="Go back"></a>
        <span class="net-amount-sum"><?php echo "Net amount: " . $the_sum;?></span>
    </div>
    
    <div class="add-button-div">
     <a href="add_bill_food.php?bill_id=<?php 
     if (isset($_GET['bill_id'])) {
            $_SESSION['bill_id'] = $_GET['bill_id'];
            echo $_GET['bill_id'];
        }
        else {
            echo $_SESSION['bill_id'];
        }
      ?>">
     <span class="add-button">Add food</span></a>
     
     <?php if (isset($_GET['error'])) { ?>
            <p id="error"><?php echo $_GET['error']; ?></p>
     <?php } ?>
     <?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success']; ?></p>
     <?php } ?>
    </div>
    <div class="pagination-bar">
    <?php
    if ($pages > 1) {
        if (isset($_GET['bill_id'])) {
            $_SESSION['bill_id'] = $_GET['bill_id'];
        }
        for ($list_pages = 1; $list_pages <= $pages; $list_pages++) {
        echo '<a class="pagination-list" href="bill.php?list_pages=' . $list_pages . '">' . $list_pages . '</a> ';
        }
    }
    ?>
    </div>
    
</div> 

<?php
       require_once 'partials/footer.php';
?>