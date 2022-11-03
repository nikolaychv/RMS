<?php
       require_once 'config_mysql.php';
       session_start();
       
       if(!isset($_SESSION['user_id'])) {
           header('location: index.php');
           exit();
       }
       
       require_once 'partials/header.php';
       
if(isset($_GET['delete_food'])) {
  
  $query = 'DELETE FROM tbl_foods
    WHERE foods_id = '.$_GET['delete_food'].'
    LIMIT 1';
  mysqli_query($connection, $query);
  
  header('location: foods.php');
  exit();
  
}
?>

<h4>Foods</h4>

<?php 

if (isset($_GET['list_pages'])) {
    $list_pages = $_GET['list_pages'];
}
else {
    $list_pages = 1;
}

$query = 'SELECT * FROM tbl_foods WHERE foods_restaurant_id = '.$_SESSION['user_restaurant_id'].' ORDER BY foods_name, foods_id';
$result = mysqli_query($connection, $query);
$all_foods = mysqli_num_rows($result);

$elements_table = 5;
$pages = ceil($all_foods/$elements_table);

$first_element_of_page = ($list_pages - 1) * $elements_table;

$query = 'SELECT * FROM tbl_foods WHERE foods_restaurant_id = '.$_SESSION['user_restaurant_id'].' LIMIT ' . $first_element_of_page . ',' .  $elements_table;
$result = mysqli_query($connection, $query);

?>

<div class="crud-content">
    <table border="1">
        <thead>
        <tr>
            <th>Food name</th>
            <th>Food category</th>
            <th>Food price</th>
            <th>Food status</th>
            <th>Action</th> 
        </tr>
        </thead>
        
        <?php while($record = mysqli_fetch_assoc($result)): ?>
         <tbody>
        <tr>
            <td><?php echo $record['foods_name'];?></td>
            <td><?php echo $record['foods_category'];?></td>
            <td><?php echo $record['foods_price'];?></td>
            <td><?php echo $record['foods_status'];?></td>
            <td>
            <a href="edit_food.php?edit_id=<?php echo $record['foods_id']; ?>">
            <img id="edit-image" src="images/edit-image.png" alt="Edit"></a>
                
            <a href="foods.php?delete_food=<?php echo $record['foods_id']; ?>" onclick="javascript:confirm('Are you sure you want to delete this food?');">
            <img id="delete-image" src="images/delete-image.png" alt="Delete"></a>
            </td>
        </tr>
         </tbody>
        <?php endwhile; ?>
    </table>
    <div class="add-button-div">
     <button class="add-button" onclick="window.location.href='add_food.php';">Add food</button>
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
        echo '<a class="pagination-list" href="foods.php?list_pages=' . $list_pages . '">' . $list_pages . '</a> ';
        }
    }
    ?>
    </div>
    
</div> 

<?php
       require_once 'partials/footer.php';
?>