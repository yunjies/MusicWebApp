<?php
// Start the session
session_start();
$uid = $_SESSION['uid'];
settype($uid, 'string');
?>
<?php
include "connection.php";
$ptitle = $_POST['ptitle'];
$status = $_POST['status'];
settype($ptitle, 'string');
settype($status, 'bool');
$pstatus = False;
if($status == "Public"){
	$pstatus = True;
}
$date = date("Y-m-d H:i:s"); 
$sql = "INSERT INTO `PlayList` (uid, ptitle, pdate, pstatus) VALUES ('$uid', '$ptitle', '$date', '$pstatus')";
if ($conn->query($sql) === TRUE){
	header("Location:profile.php");
	exit;
}
#$query = "INSERT INTO `booking` (cid, rid, btime, quantity) VALUES ((select cid from customer where cname = \"".$cname."\"), ".$rid.", \"".$time."\", ".$quantity.")";  # echo $sql;
/*if($conn->query($sql) === True){
	header("Location:profile.php");
	exit;
	*/
?>
