<?php
// Start the session
session_start();
$uid = $_SESSION['uid'];
$aid = $_GET['aid'];
?>
<?php
        include "connect.php";

		#$sql = "SELECT * FROM restaurant where desription like '%Crab%'";
		$sql = "select * from User where uid = '".$uid."'";

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
 
      <!-- HTML5 Shiv 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
      <!-- 注意： 如果通过 file://  引入 Respond.js 文件，则该文件无法起效果 -->
      <!--[if lt IE 9]>
         <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
         <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->
   </head>
     <body background = "https://static.pexels.com/photos/63703/pexels-photo-63703.jpeg">
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<nav class="navbar navbar-default navbar-static-top navbar-inverse" role="navigation">
				<div class="navbar-header">
					 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="person.php">Spotify</a>
				</div>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="active">
							 <a href="follow.php">Follow</a>
						</li>
						<li>
							 <a href="#">Like</a>
						</li>
						<li>
							 <a href="history.php">History</a>
						</li>
					</ul>
					<form class="navbar-form navbar-left" role="search" action="search.php" method="post">
						<div class="form-group">
							<input type="text" class="form-control" name = "key"/>
						</div> <button type="submit" class="btn btn-default">Search</button>
					</form>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="profile.php"> Welcome! <?php echo $uid ?></a>
						</li>
					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
						</div> 
						<a href="index.php">
							<button type='button' class='btn btn-info'>Log out</button>
						</a>
					</form>
					</ul>
				</div>
				
			</nav>
		</div>
		<div class="col-md-12 column">
			<div class="jumbotron well">
				<h1>
					
				</h1>
				<p>
					This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.
				</p>
				<p>
					 <a class="btn btn-primary btn-large" href="#">Learn more</a>
				</p>
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