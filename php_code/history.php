<?php
session_start();
$uid = $_SESSION['uid'];
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Personal Homepage</title>
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
		<?php include "widget.php"; ?>
	</div>
	<div class="row clearfix">
		<table class="table table-striped">
		 	<caption><h1 class="text-center">Your Play History</h1></caption>
		  <thead>
		    <tr>
		      <th>Track Name</th>
		      <th>Artist</th>
		      <th>Play Date</th>
		      <th>Belongs to</th>
		    </tr>
		  </thead>
		  <tbody>
		<?php
		#$sql = "SELECT * FROM restaurant where desription like '%Crab%'";
		$sql = "select history.tid, htimestamp, tname, artist.aid, artist.aname, history.alid, history.pid
				from history join track on history.tid = track.tid join artist on artist.aname = track.aname
				where history.uid = '$uid'
				order by htimestamp desc;";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    // output data of each row
		  while($row = $result->fetch_assoc()) {
		        echo '
		        <tr>
		        <td><a href="history.php?tid='.$row["tid"].'">'.$row["tname"].'</a></td>
		        <td><a href="ArtistProfile.php?aid='.$row["aid"].'">'.$row["aname"].'</a></td>
		        <td>'.$row["htimestamp"].'</td>
		        <td>';
		        if($row["alid"])
		        {
		        	$subsql = "SELECT alname from album where alid = '".$row["alid"]."';";
		        	$subres = $conn->query($subsql);
		        	$subrow = $subres->fetch_assoc();
		        	echo '<a href="AlbumProfile.php?tid='.$row["alid"].'">'.$subrow["alname"].'</a>';
		        }
		        else if($row["pid"])
		        {
		        	$subsql = "SELECT ptitle from playlist where pid = '".$row["pid"]."';";
		        	$subres = $conn->query($subsql);
		        	$subrow = $subres->fetch_assoc();
		        	echo '<a href="playlist.php?pid='.$row["pid"].'">'.$subrow["ptitle"].'</a>';
		        }
		        else
		        {
		        	echo ' ';
		        }
		        echo 
		        '</td>
		        </tr>';
		  }
		}
		?>
		  </tbody>
		</table>
	</div>
</div>
      <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>