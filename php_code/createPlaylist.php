<?php
// Start the session
session_start();
$uid = $_SESSION['uid'];
?>
<?php
include "connection.php";
$ptitle = $_POST['ptitle'];
$status = $_POST['status'];
$pstatus = False;
if($status == "Public"){
	$pstatus = True;
}
$date = date("Y-m-d H:i:s"); 
settype($ptitle, 'string');
settype($uid, 'string');
settype($data, 'date');
settype($pstatus, 'bool');
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
