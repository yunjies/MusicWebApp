<?php
// Start the session
session_start();
$uid = $_SESSION['uid'];
$aid = $_GET['aid'];
include "connection.php";
$sql = "DELETE FROM Favorite WHERE uid = '$uid' and aid = '$aid'";
if($conn->query($sql) === TRUE){
	header("Location:like.php");
	exit;
}


?>