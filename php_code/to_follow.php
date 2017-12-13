<?php
// Start the session
session_start();
$uid = $_SESSION['uid'];
$fuid = $_GET['fuid'];
include "connection.php";
$time = date("Y-m-d H:i:s");
$sql = "INSERT INTO `Follow` VALUES ('$uid', '$fuid', '$time');";
if ($conn->query($sql) === TRUE){
}
else
{
    echo "Error deleting record: " . $conn->error;
}
header('Location:search.php');
exit;
?>