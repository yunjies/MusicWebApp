<?php
// Start the session
session_start();
$uid = $_SESSION['uid'];
if(isset($_GET["aid"]))
{
    $aid = $_GET['aid'];
    $_SESSION["artistid"] = $aid;
}
else
{
    $aid = $_SESSION["artistid"];
}
if(isset($_GET["alid"]))
{
    $alid = $_GET['alid'];
    $_SESSION["albumid"] = $alid;
}
else
{
    $alid = $_SESSION["albumid"];
}
if(isset($_GET["pid"]))
{
    $pid = $_GET['pid'];
    $_SESSION["pname"] = $pid;
}
else
{
    $pid = $_SESSION["pname"];
}

if(isset($_GET["tid"]))
{
    include "connection.php";
    $tid = $_GET['tid'];
        
    if(isset($_GET["pid"]))
    {
        $sql = "INSERT INTO history VALUES ('$uid', '$tid', now(), '$pid', NULL);";
    }
    else if(isset($_GET["alid"]))
    {
         $sql = "INSERT INTO history VALUES ('$uid', '$tid', now(), NULL, '$alid');";
    }
    else
    {
         $sql = "INSERT INTO history VALUES ('$uid', '$tid', now(), NULL, NULL);";
    }
    $conn->query($sql);
    $conn->close();
    $_SESSION["tid"] = $tid;
    settype($tid, 'string');
}
else
{
    $tid = $_SESSION["tid"];
    settype($tid, 'string');

}
$alert = false;
$alertErr = false;
$added = false;
$addedErr = false;
?>

<?php
include "connection.php";
// find news from artist
$currtime = "'".date('Y-m-d')."'";
$lasttime = "'".date('Y-m-d',time() - (15 * 24 * 60 * 60))."'";

$sql = "SELECT aname, alname, tname, tduration, tid, alid
        FROM favorite natural join artist natural join track natural join album
        where uid = '$uid' and TIMESTAMPDIFF(DAY,now(), altime) <= 35
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
        $newLike[$row["aname"]][] = array($row["tid"], $row["tname"], $row["tduration"], $row["alname"],$row["alid"]);
    }
}


// find news from follower
// find news from artist
$currtime = "'".date('Y-m-d')."'";
$lasttime = "'".date('Y-m-d',time() - (15 * 24 * 60 * 60))."'";

$sql = "SELECT fuid, aname, ptitle, tname, tduration, tid
        FROM follow, artist natural join track natural join playlistinclude natural join playlist
        where follow.uid = '.$uid.' and follow.fuid = playlist.uid and TIMESTAMPDIFF(DAY,now(), pdate) <= 35
        ORDER BY `aname` DESC; ";
$result = $conn->query($sql);
$newfollow = array();
$newuser = array();
if ($result->num_rows > 0) {
// output data of each row
    while ($row = $result->fetch_assoc()) {
        if(end($newuser) != $row["fuid"]) {
            $newuser[] = $row["fuid"];
        }
        $newfollow[$row["fuid"]][] = array($row["tid"], $row["tname"], $row["aname"], $row["tduration"], $row["ptittle"]);
    }
}

// find new
$sql = "SELECT *
        From album
        ORDER BY `altime` DESC;";

$result = $conn->query($sql);
$newalbum = array();
if ($result->num_rows > 0) {
// output data of each row
    $x = 0;
    while ($row = $result->fetch_assoc()) {
        if($x > 4)
            break;
        $newalbum[] = array($row["alid"], $row["alname"]);
        $x++;
    }
}

?>

<?php
function findtrack($albumname)
{
include "connection.php";
$sql = "SELECT tname, tduration, tid
        FROM track natural join album
        where album.alname = '$albumname'
        ORDER BY `tname` DESC;";
$result = $conn->query($sql);
$tracklist = array();
if ($result->num_rows > 0) {
// output data of each row
    while ($row = $result->fetch_assoc()) {
        $tracklist[] = array($row["tid"], $row["tname"], $row["tduration"]);
    }
}
$conn->close();
return $tracklist;
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
        <?php include "widget.php" ?>
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
                         <a href="#panel-123456" data-toggle="tab">What's New</a>
                    </li>
                    <li>
                         <a href="#panel-323143" data-toggle="tab">What You Like</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="panel-123456">
                        <p>
                            <?php
                            for($x = 0; $x < count($newalbum) && $x < 4; $x++) 
                            {
                                echo
                                '<div class="row clearfix">
                                    <div class="col-md-6 column">
                                        <table class="table">
                                            <caption>'.$newalbum[$x][1].'</caption>
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
                                                </tr>
                                            </thead>
                                        <tbody>';
                                    $tracklist = findtrack($newalbum[$x][1]);
                                    for($y = 0; $y < count($tracklist) && $y < 4; $y++)
                                    {
                                        $td = formatSeconds( $tracklist[$y][2] / 1000);
                                        echo '<tr><td>' . ($y + 1) . '</td>
                                                <td><a href="StartPage.php?tid='.$tracklist[$y][0].'">'.$tracklist[$y][1].'</a></td>
                                                <td>' .$td . '</td>
                                              </tr>';                                        
                                    }
                                    $x++;
                                    echo '<tr><td>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="AlbumProfile.php?alid='.$newalbum[$x][0].'">More...</a>
                                        </td>
                                        <td>  
                                        </td></tr>  
                                    </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6 column">
                                        <table class="table">
                                            <caption>'.$newalbum[$x][1].'</caption>
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
                                                </tr>
                                            </thead>
                                        <tbody>';
                                    $tracklist = findtrack($newalbum[$x][1]);
                                    for($y = 0; $y < count($tracklist) && $y < 4; $y++)
                                    {
                                        $td = formatSeconds( $tracklist[$y][2] / 1000);
                                        echo '<tr><td>' . ($y + 1) . '</td>
                                                <td><a href="StartPage.php?tid='.$tracklist[$y][0].'">'.$tracklist[$y][1].'</a></td>
                                                <td>' . $td . '</td>
                                              </tr>';                                        
                                    }
                                    echo '<tr><td>
                                        </td>
                                        <td><a 
                                            <a class="btn btn-primary" href="AlbumProfile.php?alid='.$newalbum[$x][0].'">More...</a>
                                        </td>
                                        <td>  
                                        </td></tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>';
                            }
                            ?>
                        </p>
                    </div>
                    <div class="tab-pane" id="panel-323143">
                        <p>
                            <?php
                            echo
                                '<div class="row clearfix">
                                    <div class="col-md-12 column">';
                            if(count($newLike) == 0)
                                echo "<div align='center'>
                                        <h1>You Haven't Like Any Artists Yet!!</h1>
                                        <a href='#panel-123456_wrapper'>Find more here...</a>
                                    </div>";
                            else
                            {
                                foreach($newartist as $artist) {
                                echo
                                    '<div class="panel-group" id="panel-447226">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <a class="panel-title" data-toggle="collapse" data-parent="#'.$artist.'" href="#'.$artist.'">' . $artist . '</a>
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
                                                        </tr>
                                                        </thead>
                                                        <tbody>';
                                                        for ($x = 0; $x < count($newLike[$artist]); $x++) {
                                                            $td = formatSeconds($newLike[$artist][$x][2] / 1000);
                                                            echo '<tr><td>' . ($x + 1) . '</td>
                                                                  <td><a href="StartPage.php?tid='.$newLike[$artist][$x][0].'">'.$newLike[$artist][$x][1].'</a></td>
                                                                  <td>' . $td . '</td>
                                                                   <td><a href="AlbumProfile.php?alid='.$newLike[$artist][$x][4].'">'.$newLike[$artist][$x][3].'</a></td>
                                                                  </tr>';
                                                        }
                                                        echo '</tbody>
                                                    </table>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>';
                                }
                            }
                            
                            echo
                                '</div>
                                    </div>';
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.bcd').click(function(){
        $('#trackids').val($(this).attr('data-id'));
    });
</script>

<script>
    $('.abc').click(function(){
        $('#trid').val($(this).attr('data-id'));
    });
</script>
<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
<script src="https://code.jquery.com/jquery.js"></script>
<!-- 包括所有已编译的插件 -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>