<?php
       require_once 'config_mysql.php';
       session_start();
       
       if(!isset($_SESSION['user_id'])) {
           header('location: index.php');
           exit();
       }
       
       require_once 'partials/header.php';
       
if(isset($_GET['delete_order'])) {
  
  $first_query = 'DELETE FROM tbl_orders
    WHERE order_id = '.$_GET['delete_order'].'
    LIMIT 1';
  mysqli_query($connection, $first_query);
  
  $second_query = 'DELETE FROM tbl_bills
    WHERE bill_order_id = '.$_GET['delete_order'].'';
  mysqli_query($connection, $second_query);
  
  header('location: billing.php');
  exit();
  
}

if(isset($_SESSION['net_amount']) && isset($_GET['bill_id'])) {
$the_net_amount = $_SESSION['net_amount'];
$first_sql = 'UPDATE tbl_orders SET order_net_amount = "'.$the_net_amount.'"
              WHERE order_id = '.$_GET['bill_id'].' LIMIT 1';
$first_result = mysqli_query($connection, $first_sql);

$_SESSION['net_amount'] = null;
$_GET['bill_id'] = null;
}

$_SESSION['bill_id'] = null;
?>

<h4>Billing</h4>

<?php 

if (isset($_GET['list_pages'])) {
    $list_pages = $_GET['list_pages'];
}
else {
    $list_pages = 1;
}

$query = 'SELECT * FROM tbl_orders WHERE order_restaurant_id = '.$_SESSION['user_restaurant_id'].'';
$result = mysqli_query($connection, $query);
$all_orders = mysqli_num_rows($result);

$elements_table = 5;
$pages = ceil($all_orders/$elements_table);

$first_element_of_page = ($list_pages - 1) * $elements_table;

$query = 'SELECT * FROM tbl_orders WHERE order_restaurant_id = '.$_SESSION['user_restaurant_id'].' '
        . 'LIMIT ' . $first_element_of_page . ',' .  $elements_table;
$result = mysqli_query($connection, $query);

?>

<div class="crud-content">
    <table border="1">
        <thead>
        <tr>
            <th>Order ID</th>
            <th>Order table</th>
            <th>Order time</th>
            <th>Order date</th>
            <th>Order serving</th>
            <th>Order status</th>
            <th>Order net amount</th>
            <th>Action</th> 
        </tr>
        </thead>
        
        <?php while($record = mysqli_fetch_assoc($result)): ?>
         <tbody>
        <tr>
            <td><?php echo $record['order_id'];?></td>
            <td><?php echo $record['order_table'];?></td>
            <td><?php echo $record['order_time'];?></td>
            <td><?php echo $record['order_date'];?></td>
            <td><?php echo $record['order_serving'];?></td>
            <td><?php echo $record['order_status'];?></td>
            <td><?php echo $record['order_net_amount'];?></td>
            <td>
            <a href="bill.php?bill_id=<?php echo $record['order_id']; ?>">
            <img id="bill-image" src="images/bill-image.png" alt="Bill"></a>
            
            <a href="edit_billing.php?edit_id=<?php echo $record['order_id']; ?>">
            <img id="edit-image" src="images/edit-image.png" alt="Edit"></a>
                
            <a href="billing.php?delete_order=<?php echo $record['order_id']; ?>" onclick="javascript:confirm('Are you sure you want to delete this order?');">
            <img id="delete-image" src="images/delete-image.png" alt="Delete"></a>
            </td>
        </tr>
         </tbody>
        <?php endwhile; ?>
    </table>
    <div class="add-button-div">
     <button class="add-button" onclick="window.location.href='add_order.php';">Add order</button>
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
        for ($list_pages = 1; $list_pages <= $pages; $list_pages++) {
        echo '<a class="pagination-list" href="billing.php?list_pages=' . $list_pages . '">' . $list_pages . '</a> ';
        }
    }
    ?>
    </div>
    
</div> 

<?php
       require_once 'partials/footer.php';
?>