<?php
    function is_manager()
    {
        if(!isset($_SESSION['user_type'])) {
            return false;
        }
        else {
            return ($_SESSION["user_type"] == 'Manager') ? true : false;
        }
    }
    
    function is_waiter()
    {
        if(!isset($_SESSION['user_type'])) {
            return false;
        }
        else {
            return ($_SESSION["user_type"] == 'Waiter') ? true : false;
        }
    }
    
    function is_bartender()
    {
        if(!isset($_SESSION['user_type'])) {
            return false;
        }
        else {
            return ($_SESSION["user_type"] == 'Bartender') ? true : false;
        }
    }
    ?>

<!DOCTYPE html>
<html lang="en">
    
<head>
	<meta charset="UTF-8">
	<title>Restaurant Management System</title>
	<meta name="description" content="А restaurant management system that provides a variety of information about customers, bills, food and more..."/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/style_management_system.css">
</head>
<body>

<div class="container">
    <div class="bar">
        <h2><a href="tables.php">Restaurant Management System</a></h2>
        <ul>
            <a href="tables.php"><li><i class="tables-bar"></i>Tables</li></a>
            <a href="billing.php"><li><i class="billing-bar"></i>Billing</li></a>
            <?php
            if(is_manager())
            {
            ?>
            <a href="foods.php"><li><i class="foods-bar"></i>Foods</li></a>
            <a href="category.php"><li><i class="category-bar"></i>Category</li></a>
            <a href="users.php"><li><i class="users-bar"></i>Users</li></a>
            <a href="restaurant_info.php"><li><i class="restaurant-info-bar"></i>Restaurant info</li></a>
            <?php
            }
            ?>
            <a href="profile.php"><li><i class="profile-bar"></i>Profile</li></a>
            <a href="logout.php"><li><i class="logout-bar"></i>Logout</li></a>
        </ul> 
    </div>
    <div class="content"> 