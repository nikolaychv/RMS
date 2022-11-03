<?php
define('DATABASE_SERVER', 'localhost');
define('DATABASE_USERNAME', 'root');
define('DATABASE_PASSWORD', '');
define('DATABASE_NAME', 'management_system');
 
$connection = mysqli_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
 
if($connection === false){
    exit("ERROR: " . mysqli_connect_error());
}
?>