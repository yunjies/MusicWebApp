<?php
// Start the session
session_start();
$uid = $_SESSION['uid']
?>
<?php
include "connection.php";
$uname = $_POST['uname'];
$city = $_POST['city'];
$email = $_POST['email'];
$sql = "UPDATE user
    SET uname = '$uname',
        city = '$city',
        email = '$email'
    WHERE uid = '$uid'";
  # echo $sql;
if($conn->query($sql) === True){
	header("Location:profile.php");
	exit;
}
?>