<?php
// Start the session
session_start();
$uid = $_SESSION['uid'];
settype($uid, 'string');
?>

<!DOCTYPE html>
<html>
   <head>
      <title>Personal Homepage</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
   	

      <!-- 引入 Bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 引入 Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://code.jquery.com/jquery.js"></script>
      <!-- 包括所有已编译的插件 -->
  <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   </head>
   <body>
<div class="container">
	<div class="row clearfix">
			<?php
			include "widget.php";
			?>
	</div>
	<div class="row clearfix"> <!--style="background-color:#FFFFFF;opacity:0.8"> -->
			<table class="table table-striped">
				<caption><h1 class="text-center">Following Users</h1></caption>
				<thead>
					<tr>
				    	<th>Username</th>
				      	<th>Followed Date</th>
				    </tr>
				</thead>
				<tbody>
				<?php

					#$sql = "SELECT * FROM restaurant where desription like '%Crab%'";
				$sql = "select uname, fuid, ftimestamp from Follow join User on Follow.fuid = User.uid where Follow.uid = '".$uid."'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					    // output data of each row
				  	while($row = $result->fetch_assoc()) {
				        echo "
				        <tr>
				        <td><a href='UserProfile.php?uid=".$row["fuid"]."'>".$row["fuid"]."</a></td>
				        <td>".$row["ftimestamp"]."</td>
				        <td><a href='unfollow.php?fuid=".$row["fuid"]."'><button type='button' class='btn btn-info'>Unfollow</button></a ></td>
					        </tr>";
					}
				}
				?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
      <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>