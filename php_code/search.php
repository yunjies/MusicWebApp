<?php
// Start the session
session_start();
$uid = $_SESSION['uid'];
include "connection.php";

if(isset($_POST['key'])){
	$_SESSION['key'] = $_POST['key'];
}
$key = $_SESSION['key'];
settype($uid, 'string');
settype($key, 'string');

?>
<!DOCTYPE html>
<html>
   <head>
      <title>Personal Homepage</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- 引入 Bootstrap -->
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
	</div>
	<div class="row clearfix">
		<div class="col-md-12 column">
			<div class="tabbable" id="tabs-336529">
				<ul class="nav nav-tabs">
					<li class="active">
						 <a href="#panel-437241" data-toggle="tab">Users</a>
					</li>
					<li>
						 <a href="#panel-973194" data-toggle="tab">Artists</a>
					</li>
					<li>
						 <a href="#panel-973192" data-toggle="tab">Tracks</a>
					</li>
					<li>
						 <a href="#panel-973191" data-toggle="tab">Playlists &amp; Albums</a>
					</li>
				</ul>
				<div class="tab-content">
				  <div class="tab-pane active" id="panel-437241">
			        <table class="table table-striped">
				      <thead>
					 	<tr>
				    	  <th>Username</th>
				    	  <th>City</th>
				      	  <th>Status</th>
				    	</tr>
					  </thead>
					  <tbody>
						<?php

							#$sql = "SELECT * FROM restaurant where desription like '%Crab%'";
					#	$sql = "select uid, uname from User where uid like \"%$key%\" or uname like \"%$key%\"";
						$sql = "select fuid, uname, city, uid from (select uid as fuid, uname, city from User where (uid like \"%$key%\" or uname like \"%$key%\") and uid <> \"$uid\") as A NATURAL left join (select fuid, uid from Follow where uid = \"$uid\") as B";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							    // output data of each row
						  	while($row = $result->fetch_assoc()) {
						        echo "
						        <tr>
						        <td><a href='UserProfile.php?uid=".$row["fuid"]."'>".$row["fuid"]."</a></td>
						        <td>".$row["city"]."</td>";
						        if($row["uid"] === NULL && strcmp($row["fuid"], $uid) !== 0){
						        	echo "<td><a href='to_follow.php?fuid=".$row["fuid"]."'><button type='button' class='btn btn-info'>Follow</button></a ></td>
						       
							        </td>";
						        }
						        else{
						        	echo "<td>Followed</td>";
						        }
								echo "</tr>";
							}
						}
						?>
					  </tbody>
					</table>
				  </div>


				  <div class="tab-pane" id="panel-973194">
					<table class="table table-striped">
				      <thead>
					 	<tr>
				    	  <th>Artist</th>
				      	  <th>Description</th>
				    	</tr>
					  </thead>
					  	<tbody>
						<?php
						$sql = "select aid, aname, adesc from Artist where aname like \"%$key%\" or adesc like \"%$key%\"";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							    // output data of each row

						  	while($row = $result->fetch_assoc()) {
						        echo "
						        <tr>
						        <td><a href='ArtistProfile.php?aid=".$row["aid"]."'>".$row["aname"]."</a></td>
						        <td>".$row["adesc"]."</td>
						        </tr>";
							}
						}
						?>
					  </tbody>
					</table>
				  </div>
				  <div class="tab-pane" id="panel-973192">
					<table class="table table-striped">
				      <thead>
					 	<tr>
				    	  <th>Track Name</th>
				    	  <th>Duration</th>
				      	  <th>Artist</th>
				      	  <th>Album</th>
				    	</tr>
					  </thead>
					  <tbody>
						<?php

							#$sql = "SELECT * FROM restaurant where desription like '%Crab%'";
					#	$sql = "select uid, uname from User where uid like \"%$key%\" or uname like \"%$key%\"";
						$sql = "select * from track natural left join album natural left join artist where tname like \"%$key%\"";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							    // output data of each row
						  	while($row = $result->fetch_assoc()) {
						  		$seconds = $row["tduration"] / 1000;
						  		$td = formatSeconds($seconds);
						        echo "
						        <tr>
						        <td><a href='search.php?tid=".$row["tid"]."'>".$row["tname"]."</a></td>
						        <td>".$td."</td>
						        <td><a href='ArtistProfile.php?aid=".$row["aid"]."'>".$row["aname"]."</a></td>
						        <td><a href='AlbumProfile.php?alid=".$row["alid"]."'>".$row["alname"]."</a ></td>";
								echo "</tr>";
							}
						}
						?>
					  </tbody>
					</table>
					</div>
					<div class="tab-pane" id="panel-973191">
						<div class="row clearfix">
				<div class="col-md-6 column">
					<table class="table">
						<caption><h1 class="text-center">Playlists</h1></caption>
						<thead>
							<tr>
								<th>
									Name
								</th>
								<th>
									Created Date
								</th>
								<th>
									Created By
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
						$sql = "select * from playlist natural join user where ptitle like \"%$key%\" and pstatus = 1";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							    // output data of each row
						  	while($row = $result->fetch_assoc()) {
						        echo "
						        <tr>
						        <td><a href='playlist.php?pid=".$row["pid"]."'>".$row["ptitle"]."</a></td>
						        <td>".$row["pdate"]."</td>
						        <td><a href='UserProfile.php?uid=".$row["uid"]."'>".$row["uname"]."</a></td>";
								echo "</tr>";
							}
						}
						?>
						</tbody>
					</table>
				</div>
				<div class="col-md-6 column">
					<table class="table">
				      <caption><h1 class="text-center">Album</h1></caption>
				      <thead>
				       <tr>
				        <th>
				         Name
				        </th>
				         <th>
				       	 Released Date
				        </th>
				       </tr>
				      </thead>
				      <tbody>
				       <?php

				       #$sql = "SELECT * FROM restaurant where desription like '%Crab%'";
				     # $sql = "select uid, uname from User where uid like \"%$key%\" or uname like \"%$key%\"";
				      $sql = "select * from Album where alname like \"%$key%\"";
				      $result = $conn->query($sql);
				      if ($result->num_rows > 0) {
				           // output data of each row
				         while($row = $result->fetch_assoc()) {
				              echo "
				              <tr>
				              <td><a href='AlbumProfile.php?alid=".$row["alid"]."'>".$row["alname"]."</a ></td>
				              <td>".$row["altime"]."</td>";
				        echo "</tr>";
				       }
				      }
				      ?>
				      </tbody>
				     </table>
				</div>
			</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
   </body>
</html>