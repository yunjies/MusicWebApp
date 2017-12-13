<?php
// Start the session
session_start();
$uid = $_SESSION['uid'];
$aid = $_GET['aid'];
include "connection.php";
$Search_sql = "SELECT * FROM favorite where uid = '$uid' and aid = '$aid'";
$result = $conn->query($Search_sql);
if ($result->num_rows > 0){
	$sql = "DELETE FROM Favorite WHERE uid = '$uid' and aid = '$aid'";
}
else{
	$time = date("Y-m-d H:i:s");
	$sql = "INSERT INTO `Favorite` VALUES ('$uid', '$aid', '$time');";
}
if($conn->query($sql) === TRUE){
	header("Location:ArtistProfile.php?aid=$aid");
	exit;
}


?>