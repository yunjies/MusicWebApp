<?php
// Start the session
session_start();
$uid = $_SESSION['uid'];
$otheruid = $_GET['uid'];
settype($otheruid, 'string');
include "connection.php";
		
		#$sql = "SELECT * FROM restaurant where desription like '%Crab%'";
		$sql = "select * from User where uid = '".$otheruid."'";

		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    // output data of each row
		  while($row = $result->fetch_assoc()) {
		        $uname = $row["uname"];
		       	$city = $row["city"];
		        $email = $row["email"];
		  }
		}
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
      <!-- HTML5 Shiv 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
      <!-- 注意： 如果通过 file://  引入 Respond.js 文件，则该文件无法起效果 -->
      <!--[if lt IE 9]>
         <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
         <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->
   </head>
     <body>
<div class="container">
	<div class="row clearfix">
		<?php include "title.html" ?>
	</div>
	<div class="row clearfix">
		<div class="col-md-12 column">
			<div class="row clearfix">
				<div class="col-md-4 column">
					<img alt="160x160" src="http://www.hewe1483.com/zb_users/upload/2017/03/201703161489660053784907.jpg" width=350>
					<dl>
						<dt>Name</dt>
						<dd><?php echo $uname ?></dd>
						<dt>Email</dt>
						<dd><?php echo $email ?></dd>
						<dt>City</dt>
						<dd><?php echo $city ?></dd>
					</dl>
				</div>
				<div class="col-md-8 column">
					<table class="table table-striped">
					  <caption><h1 class="text-center"> <?php echo $otheruid ?>'s Playlists</h1></caption>
					  <div   style = "text-align: right;">
				      <thead>
					 	<tr>
				    	  <th>Playlist</th>
				      	  <th>Create Date</th>
				    	</tr>
					  </thead>
					  	<tbody>
						<?php
						$sql= "select pid, ptitle, pdate, pstatus from Playlist where uid = '$otheruid' and pstatus = 1";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							    // output data of each row

						  	while($row = $result->fetch_assoc()) {
						        echo "
						        <tr>
						        <td><a href='playlist.php?pid=".$row["pid"]."'>".$row["ptitle"]."</a></td>
						        <td>".$row["pdate"]."</td>";
						        echo "</tr>";
							}
						}
						?>
					  </tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal-container-798561" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">
							Edit Information
						</h4>
					</div>
					<div class="modal-body">
						<form role="form" action="editInfo.php" method="post">
							<div class="form-group">
								<label>Email address</label>
								<input type="email" class="form-control" value = <?php echo "'".$email."'" ?> name="email" required>
							</div>
							<div class="form-group">
								<label>Full Name</label>
								<input type="text" class="form-control" value = <?php echo "'".$uname."'" ?>  name="uname" required>
							</div>
							<div class="form-group">
								<label>City</label>
								<input type="text" class="form-control" value = <?php echo "'".$city."'" ?>  name="city" required>
							</div>
							<button type="submit" class="btn btn-primary">Submit</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal-container-798563" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">
							New Playlist
						</h4>
					</div>
					<div class="modal-body">
						<form role="form" action="createPlaylist.php" method="post">
							<div class="form-group">
								<label>Playlist Name</label>
								<input type="text" class="form-control" name="ptitle" required>
							</div>
							<div class="form-group">
								<label for="exampleFormControlSelect1">Status</label>
								<select class="form-control" name="status">
									<option>Public</option>
								    <option>Private</option>
								</select>
							</div>
							<button type="submit" class="btn btn-primary">Submit</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal-container-798562" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">
							Change Password
						</h4>
					</div>
						<div class="modal-body">
							<form role="form" action="editInfo.php" method="post">
								<div class="form-group">
									 <label>Old Password</label>
									 <input type="password" class="form-control" name="email" required>
								</div>
								<div class="form-group">
									 <label>New Password</label>
									 <input type="password" class="form-control" name="email" required>
								</div>
								<div class="form-group">
									 <label>One more time</label>
									 <input type="password" class="form-control" name="email" required>
								</div>
								<button type="submit" class="btn btn-primary">Submit</button>
								 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal-container-798564" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">
							New Playlist
						</h4>
					</div>
					<div class="modal-body">
						<form role="form" action="createPlaylist.php" method="post">
							<div class="form-group">
								<label>Playlist Name</label>
								<input type="text" class="form-control" name="ptitle" required>
							</div>
							<div class="form-group">
								<label for="exampleFormControlSelect1">Status</label>
								<select class="form-control" name="status">
									<option>Public</option>
								    <option>Private</option>
								</select>
							</div>
							<button type="submit" class="btn btn-primary">Submit</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
      <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
  
   </body>
</html>