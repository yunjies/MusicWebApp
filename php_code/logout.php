<?php
// Start the session
session_destroy();
session_unset();
setcookie("uid","1",time()-1);
header("Location:index.php");
exit;

?>