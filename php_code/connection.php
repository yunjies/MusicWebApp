<?php
/**
 * Created by PhpStorm.
 * User: Yunjie Shi
 * Date: 2017/11/11
 * Time: 14:35
 */
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "test";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . connect_error);
?>