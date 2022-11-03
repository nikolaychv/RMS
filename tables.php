<?php
       require_once 'config_mysql.php';
       session_start();
       
       if(!isset($_SESSION['user_id'])) {
           header('location: index.php');
           exit();
       }
       
       require_once 'partials/header.php';
       
if(isset($_GET['delete'])) {
  
  $query = 'DELETE FROM tbl_restaurant_tables
    WHERE rt_id = '.$_GET['delete'].'
    LIMIT 1';
  mysqli_query($connection, $query);
  
  header('location: tables.php');
  exit();
  
}
?>

<h4>Tables</h4>

<?php 

if (isset($_GET['list_pages'])) {
    $list_pages = $_GET['list_pages'];
}
else {
    $list_pages = 1;
}

$query = 'SELECT * FROM tbl_restaurant_tables WHERE rt_restaurant_id = '.$_SESSION['user_restaurant_id'].' ORDER BY rt_name, rt_id';
$result = mysqli_query($connection, $query);
$all_tables = mysqli_num_rows($result);

$elements_table = 5;
$pages = ceil($all_tables/$elements_table);

$first_element_of_page = ($list_pages - 1) * $elements_table;

$query = 'SELECT * FROM tbl_restaurant_tables WHERE rt_restaurant_id = '.$_SESSION['user_restaurant_id'].' LIMIT ' . $first_element_of_page . ',' .  $elements_table;
$result = mysqli_query($connection, $query);

?>

<div class="crud-content">
    <table border="1">
        <thead>
        <tr>
            <th>Table name</th>
            <th>Table capacity</th>
            <th>Table status</th>
            <th>Is booked?</th>
            <th>Action</th> 
        </tr>
        </thead>
        
        <?php while($record = mysqli_fetch_assoc($result)): ?>
         <tbody>
        <tr>
            <td><?php echo $record['rt_name'];?></td>
            <td><?php echo $record['rt_capacity'];?></td>
            <td><?php echo $record['rt_status'];?></td>
            <td><?php echo $record['rt_is_booked'];?></td>
            <td>
            <a href="edit_table.php?edit_id=<?php echo $record['rt_id']; ?>">
            <img id="edit-image" src="images/edit-image.png" alt="Edit"></a>
                
        <?php if($record['rt_status'] != 'Disable'): ?>
          <a href="tables.php?delete=<?php echo $record['rt_id']; ?>" onclick="javascript:confirm('Are you sure you want to delete this table?');">
          <img id="delete-image" src="images/delete-image.png" alt="Delete"></a>
        <?php endif; ?>
            </td>
        </tr>
         </tbody>
        <?php endwhile; ?>
    </table>
    <div class="add-button-div">
     <button class="add-button" onclick="window.location.href='add_table.php';">Add table</button>
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
        echo '<a class="pagination-list" href="tables.php?list_pages=' . $list_pages . '">' . $list_pages . '</a> ';
        }
    }
    ?>
    </div>
    
</div> 

<?php
       require_once 'partials/footer.php';
?>