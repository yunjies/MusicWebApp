<?php 
$pid = $_POST["pid"];
$tid = $_POST["tid"];
include "connect.php";
$sql = "INSERT INTO playlistinclude VALUES ('$pid', '$tid');";
$result = $conn->query($sql);
//echo $sql;
$conn->close();
header("Location:ArtistProfile.php");
exit;
?>