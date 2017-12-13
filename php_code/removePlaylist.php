<?php
// Start the session
session_start();
$uid = $_SESSION['uid'];
settype($uid, 'string');
include "connection.php";
$pid = $_GET['pid'];
$sql = "DELETE FROM PlaylistInclude WHERE pid = \"pid\"";
$conn->query($sql);
$sql = "DELETE FROM Playlist WHERE pid = \"$pid\"";
$result = $conn->query($sql);
if ($conn->query($sql) === False){
    echo "Error deleting record: " . $conn->error;
}
header('Location:profile.php');
exit;
?>