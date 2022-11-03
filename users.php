<?php
       require_once 'config_mysql.php';
       session_start();
       
       if(!isset($_SESSION['user_id'])) {
           header('location: index.php');
           exit();
       }
       
       require_once 'partials/header.php';
       
if(isset($_GET['delete_id'])) {
  
  $query = 'DELETE FROM tbl_user
    WHERE user_id = '.$_GET['delete_id'].'
    LIMIT 1';
  mysqli_query($connection, $query);
  
  header('location: users.php');
  exit();
  
}
?>

<h4>Users</h4>

<?php 

if (isset($_GET['list_pages'])) {
    $list_pages = $_GET['list_pages'];
}
else {
    $list_pages = 1;
}

$query = 'SELECT * FROM tbl_user WHERE user_restaurant_id = '.$_SESSION['user_restaurant_id'].' ORDER BY user_full_name, user_id';
$result = mysqli_query($connection, $query);
$all_users = mysqli_num_rows($result);

$elements_table = 5;
$pages = ceil($all_users/$elements_table);

$first_element_of_page = ($list_pages - 1) * $elements_table;

$query = 'SELECT * FROM tbl_user WHERE user_restaurant_id = '.$_SESSION['user_restaurant_id'].' '
        . 'LIMIT ' . $first_element_of_page . ',' .  $elements_table;
$result = mysqli_query($connection, $query);

?>

<div class="crud-content">
    <table border="1">
        <thead>
        <tr>
            <th>User full name</th>
            <th>Username</th>
            <th>User email</th>
            <th>User type</th>
            <th>User status</th>
            <th>User creation</th>
            <th>Action</th> 
        </tr>
        </thead>
        
        <?php while($record = mysqli_fetch_assoc($result)): ?>
         <tbody>
        <tr>
            <td><?php echo $record['user_full_name'];?></td>
            <td><?php echo $record['user_username'];?></td>
            <td><?php echo $record['user_email'];?></td>
            <td><?php echo $record['user_type'];?></td>
            <td><?php echo $record['user_status'];?></td>
            <td><?php echo $record['user_creation'];?></td>
            <td>
            <a href="edit_user.php?edit_id=<?php echo $record['user_id']; ?>">
            <img id="edit-image" src="images/edit-image.png" alt="Edit"></a>
                
        <?php if($_SESSION['user_id'] != $record['user_id']): ?>
          <a href="users.php?delete_id=<?php echo $record['user_id']; ?>" onclick="javascript:confirm('Are you sure you want to delete this user?');">
          <img id="delete-image" src="images/delete-image.png" alt="Delete"></a>
        <?php endif; ?>
            </td>
        </tr>
         </tbody>
        <?php endwhile; ?>
    </table>
    <div class="add-button-div">
     <button class="add-button" onclick="window.location.href='add_user.php';">Add user</button>
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
        echo '<a class="pagination-list" href="users.php?list_pages=' . $list_pages . '">' . $list_pages . '</a> ';
        }
    }
    ?>
    </div>
    
</div> 

<?php
       require_once 'partials/footer.php';
?>