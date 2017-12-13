<?php
// Start the session
session_start();
$uid = $_SESSION['uid'];
$fuid = $_GET['fuid'];
include "connection.php";
settype($uid, 'string');
settype($fuid, 'string');
$sql = "DELETE FROM Follow WHERE uid = \"$uid\" and fuid = \"$fuid\"";

$result = $conn->query($sql);
if ($conn->query($sql) === TRUE){
}
else
{
    echo "Error deleting record: " . $conn->error;
}
header('Location:follow.php');
exit;

?>
<!--
INSERT INTO `Follow` (`uid`, `fuid`, `ftimestamp`) VALUES ('ys3251', 'sy1950', '2017-11-07 09:31:19');
-->