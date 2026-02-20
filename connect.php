<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "project_db";
 
$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Db connection failed: " . mysqli_connect_error());
}
?>