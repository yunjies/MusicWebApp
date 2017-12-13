<?php
// Start the session
session_start();
$uid = $_SESSION['uid'];
include "connect.php";
?>

<?php

// find news from artist
$currtime = "'".date('Y-m-d')."'";
$lasttime = "'".date('Y-m-d',time() - (15 * 24 * 60 * 60))."'";

$sql = "SELECT aname, altitle, ttitle, duration
        FROM favorite natural join artist natural join track natural join albuminclude natural join album
        where uid = '$uid' and TIMESTAMPDIFF(DAY,now(), aldate) <= 35
        ORDER BY `aname` DESC; ";
$result = $conn->query($sql);
$newLike = array();
$newartist = array();
if ($result->num_rows > 0) {
// output data of each row
    while ($row = $result->fetch_assoc()) {
        if(end($newartist) != $row["aname"]) {
            $newartist[] = $row["aname"];
        }
        $newLike[$row["aname"]][] = array($row["ttitle"], $row["duration"], $row["altitle"]);
    }
}


// find news from follower
// find news from artist
$currtime = "'".date('Y-m-d')."'";
$lasttime = "'".date('Y-m-d',time() - (15 * 24 * 60 * 60))."'";

$sql = "SELECT uid, aname, ptitle, ttitle, duration
        FROM favorite natural join artist natural join track natural join playlistinclude natural join playlist
        where uid = '$uid' and TIMESTAMPDIFF(DAY,now(), pdate) <= 35
        ORDER BY `aname` DESC; ";
$result = $conn->query($sql);
$newfollow = array();
$newuser = array();
if ($result->num_rows > 0) {
// output data of each row
    while ($row = $result->fetch_assoc()) {
        if(end($newuser) != $row["uid"]) {
            $newuser[] = $row["uid"];
        }
        $newfollow[$row["uid"]][] = array($row["ttitle"], $row["aname"], $row["duration"], $row["ptitle"]);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome Back!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 引入 Bootstrap -->
    <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- HTML5 Shiv 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
    <!-- 注意： 如果通过 file://  引入 Respond.js 文件，则该文件无法起效果 -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <style>
        td{
            width:30%;
            height:50px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row clearfix">
        <div class="col-md-12 column">
        	<?php include "widget.html" ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div class="text-center">
                <h2>
                    You Don't Want Miss This
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<div class="tabbable" id="tabs-977331">
				<ul class="nav nav-tabs">
					<li class="active">
						 <a href="#panel-323143" data-toggle="tab">What Youe Like</a>
					</li>
					<li>
						 <a href="#panel-222801" data-toggle="tab">What You Follow</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="panel-323143">
						<p>
							<?php
							echo
								'<div class="row clearfix">
									<div class="col-md-12 column">';
						    foreach($newartist as $artist) {
						        echo
						            '<div class="panel-group" id="panel-447226">
						                <div class="panel panel-default">
						                    <div class="panel-heading">
						                        <a class="panel-title" data-toggle="collapse" data-parent="#panel-447226" href="#'.$artist.'">' . $artist . '</a>
						                    </div>
						                    <div id="'.$artist.'" class="panel-collapse in">
						                        <div class="panel-body">
						                            <table class="table">
						                                <thead>
						                                <tr>
						                                    <th>
						                                        #
						                                    </th>
						                                    <th>
						                                        Track Name
						                                    </th>
						                                    <th>
						                                        Duration
						                                    </th>
						                                    <th>
						                                        Album
						                                    </th>
						                                    <th>

						                                    </th>
						                                </tr>
						                                </thead>
						                                <tbody>';
						                                for ($x = 0; $x < count($newLike[$artist]); $x++) {
						                                    echo '<tr><td>' . ($x + 1) . '</td>
						                                          <td>' . $newLike[$artist][$x][0] . '</td>
						                                          <td>' . $newLike[$artist][$x][1] . '</td>
						                                          <td>' . $newLike[$artist][$x][2] . '</td>
						                                          <td> </td>
						                                          </tr>';
						                                }
						                                echo '</tbody>
						                            </table>
						                        </div>    
						                    </div>
						                </div>
						            </div>';
						    }
						    echo
						        '</div>
						            </div>';
							?>
						</p>
					</div>
					<div class="tab-pane" id="panel-222801">
						<p>
							<div class="row clearfix">
								<div class="col-md-12 column">
									<div class="carousel slide" id="carousel-910623">
										<ol class="carousel-indicators">
											<?php
											for($x = 0; $x < count($newuser); $x++) 
											{
												if($x == 0)
													echo '<li class="active" data-slide-to="0" data-target="#carousel-910623">
													</li>';
												else
													echo
														'<li data-slide-to="'.$x.'" data-target="#carousel-910623">
														</li>';
											}
											?>
										</ol>
											<div class="carousel-inner">
												<?php
												for($x = 0; $x < count($newuser); $x++) 
												{
													if($x == 0)
													{
														echo '<div class="item active">';
													}
													else
													{
														echo '<div class="item">';
													}
														echo
															'<table class="table">
																<tbody>';
																	for ($y = 0; $y < count($newfollow[$newuser[$x]]); $y++) {
																		echo '<tr><td>' . ($y + 1) . '</td>
																				<td>' . $newfollow[$newuser[$x]][$y][0] . '</td>
																				<td>' . $newfollow[$newuser[$x]][$y][1] . '</td>
																				<td>' . $newfollow[$newuser[$x]][$y][2] . '</td>
																				<td>' . $newfollow[$newuser[$x]][$y][3] . '</td>
																				<td> </td>
																				</tr>';
																	 }
															echo '</tbody>
															</table>
														</div>';
												}
												?>			
											</div>
										</div> <a class="left carousel-control" href="#carousel-910623" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#carousel-910623" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
									</div>
								</div>
							</div>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


</body>
</html>

