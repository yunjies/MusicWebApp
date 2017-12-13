<?php
// Start the session
session_start();
$uid = $_SESSION['uid'];
include "connection.php";
?>

<!DOCTYPE html>
<html>
   <head>
      <title>Personal Homepage</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 引入 Bootstrap -->
    <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   </head>
   <body>
<div class="container">
	<div class="row clearfix">
		<?php include "widget.php" ?>
		<div class="col-md-12 column">
			<div class="row clearfix"> <!--style="background-color:#FFFFFF;opacity:0.8"> -->
				<table class="table table-striped">
					<caption><h1 class="text-center">Favoriate Artists</h1></caption>
					<thead>
						<tr>
					    	<th>Artist</th>
					      	<th>Follow Date</th>
					    </tr>
					</thead>
					<tbody>
					<?php
						#$sql = "SELECT * FROM restaurant where desription like '%Crab%'";
					$sql = "select aid, aname, ltimestamp from favorite natural join Artist where uid = '$uid';";
					#echo $sql;
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						    // output data of each row
					  	while($row = $result->fetch_assoc()) {
					         echo "
							        <tr>
							        <td><a href='ArtistProfile.php?aid=".$row["aid"]."'>".$row["aname"]."</a></td>
							        <td>".$row["ltimestamp"]."</td>
									<td><a href='dislike.php?aid=".$row["aid"]."'><button type='button' class='btn btn-info'>Dislike</button></a>
									</td>
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
</body>
</html>