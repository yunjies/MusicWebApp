<?php
// Start the session
session_start();
$uid = $_SESSION['uid'];
$tid = $_GET['tid'];
$pid = $_GET['pid'];
settype($uid, 'string');
settype($tid, 'string');
settype($pid, 'int');

include "connection.php";
$sql = "DELETE FROM PlayListInclude WHERE tid = \"$tid\" and pid = \"$pid\"";

$result = $conn->query($sql);
if ($conn->query($sql) === TRUE){
}
else
{
    echo "Error deleting record: " . $conn->error;
}
header("Location:playlist.php?pid=$pid");
exit;

?>
<!--
INSERT INTO `Follow` (`uid`, `fuid`, `ftimestamp`) VALUES ('ys3251', 'sy1950', '2017-11-07 09:31:19');
-->