<?php
session_start();
$uid = $_SESSION['uid'];
#settype($uid, 'string');
// Start the session
if(isset($_GET["aid"]))
{
    $aid = $_GET['aid'];
    #settype($aid, 'string');
    $_SESSION["artistid"] = $aid;
}
else
{
    $aid = $_SESSION["artistid"];
}
if(isset($_GET["alid"]))
{
    $alid = $_GET['alid'];
   # settype($alid, 'string');
    $_SESSION["albumid"] = $alid;
}
else
{
    $alid = $_SESSION["albumid"];
   # settype($alid, 'string');
}
if(isset($_GET["pid"]))
{
    $pid = $_GET['pid'];
    $_SESSION["pname"] = $pid;
}
else
{
    $pid = $_SESSION["pname"];
    #settype($pid, 'string');
}

if(isset($_GET["tid"]))
{
    include "connection.php";
    $tid = $_GET['tid'];
    #settype($tid, 'string');
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
}
else
{
    $tid = $_SESSION["tid"];
   # settype($tid, 'string');
}
$alert = false;
$alertErr = false;
$added = false;
$addedErr = false;
?>

<?php
include "connection.php";

$sql = "select * from Artist where aid = '$aid';";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
// output data of each row
    while ($row = $result->fetch_assoc()) {
        $aname = $row["aname"];
        $ArtistDesc = $row["adesc"];
    }
}
$sql = "SELECT * from Album where alid = '$alid';";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
// output data of each row
    while ($row = $result->fetch_assoc()) {
        $alname = $row["alname"];
    }
}

$sql = "SELECT * from playlist where pid = '$pid';";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
// output data of each row
    while ($row = $result->fetch_assoc()) {
        $ptitle = $row["ptitle"];
    }
}

$sql = "select * from rate where uid = '$uid';";
$ratescore = array();
$result = $conn->query($sql);
if ($result->num_rows > 0) {
// output data of each row
    while ($row = $result->fetch_assoc()) {
        $ratescore[$row["tid"]] = $row["score"];
    }
}

#$sql = "SELECT * FROM restaurant where desription like '%Crab%'";
$sql = "SELECT distinct track.tid, track.tname, track.tduration, round(ifnull(avg(score),0),1) as avgscore
        from Track natural join Album left outer join rate on track.tid = rate.tid
        where alname = '$alname'
        group by track.tid;";
$result = $conn->query($sql);
$tracks = array();
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $tracks[] = array($row["tid"], $row["tname"], $row["tduration"], $row["avgscore"]);
    }
}

$sql = "SELECT distinct track.tid, track.tname, track.tduration, round(ifnull(avg(score),0),1) as avgscore
        from Track natural join playlist natural join playlistinclude left outer join rate on track.tid = rate.tid
        where ptitle = '$ptitle'
        group by track.tid;";
$result = $conn->query($sql);
$ptracks = array();
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $ptracks[] = array($row["tid"], $row["tname"], $row["tduration"], $row["avgscore"]);
    }
}
?>


<?php
function addplaylist($pid, $tid)
{
global $alert;
global $alertErr;
$alert = true; 
include "connection.php";
$sql = "INSERT INTO playlistinclude VALUES ('$pid', '$tid');";
if(!$conn->query($sql))
    $alertErr = true;
//echo $sql;
$conn->close();
}
function formatSeconds( $seconds )
{
  $hours = 0;
  $milliseconds = str_replace( "0.", '', $seconds - floor( $seconds ) );

  if ( $seconds > 3600 )
  {
    $hours = floor( $seconds / 3600 );
  }
  $seconds = $seconds % 3600;


  return str_pad( $hours, 2, '0', STR_PAD_LEFT )
       . gmdate( ':i:s', $seconds );
}

function findplaylist($uid)
{
include "connection.php";
$sql = "SELECT * FROM playlist Where uid = '$uid';";
$result = $conn->query($sql);
$playlist = array();
if ($result->num_rows > 0) {
// output data of each row
    while ($row = $result->fetch_assoc()) {
        $playlist[] = array($row["pid"], $row["ptitle"]);
    }
}
$conn->close();
return $playlist;
}


function rateforsong($uid, $tid, $score)
{
global $added;
global $addedErr;
$added = true; 
include "connection.php";
$sql = "delete from rate where uid = '$uid' and tid = '$tid';";
$conn->query($sql);
$sql = "INSERT INTO rate VALUES ('$uid', '$tid', now(),'$score');";
echo $sql;
if(!$conn->query($sql))
    $addedErr = true;
//echo $sql;
$conn->close();
header("Refresh:0");
}
?>

<?php 
if(isset($_POST["submit"]))
{
    addplaylist($_POST["Playlists"], $_POST["trackid"]);
}
?>

<?php 
if(isset($_POST["rate"]))
{
    rateforsong($uid, $_POST["traid"], $_POST["points"]);
}
?>
<nav class="navbar navbar-default navbar-default-top navbar-inverse" role="navigation">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="StartPage.php">Oliver &amp; Joe</a>
	</div>
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li>
				<a href="follow.php">Follow</a>
			</li>
			<li>
				<a href="like.php">Like</a>
			</li>
			<li>
				<a href="history.php">History</a>
			</li>
		</ul>
		<form class="navbar-form navbar-left" role="search" action="search.php" method="post">
			<div class="form-group">
				<input type="text" class="form-control" name = "key" required autocomplete="on">
			</div> <button type="submit" class="btn btn-default">Search</button>
		</form>
		<ul class="nav navbar-nav navbar-right">
			<li>
				<a href="profile.php"> Welcome! <?php echo $uid ?></a>
			</li>
			<form class="navbar-form navbar-left" role="search">
				<div class="form-group">
				</div> 
				<a href="logout.php">
					<button type='button' class='btn btn-info'>Log out</button>
				</a>
			</form>
		</ul>
	</div>
</nav>
 <div style = "position:fixed;z-index:10;bottom:0px;left:18em;">
    <?php echo " <iframe src='https://open.spotify.com/embed?uri=spotify%3Atrack%3A".$tid."' width='1200' height='80' frameborder='0' allowtransparency='true'></iframe>"
    ?>
	<div style = "position:fixed;z-index:11;bottom:51px;right:228px;">
	    <div class="btn-group dropup" >
	        <button class="btn btn-danger">Action</button> <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><span class="caret"></span></button>
	        <ul class="dropdown-menu">
	            <li>
	                 <a id="modal-361102" href="#AddSong" role="button" class="btn bcd" data-id="<?php echo $tid ?>" data-toggle="modal">Add to Playlist
	                 </a>
	            <li>
                    <a id="modal-361103" href="#Rate" role="button" class="btn abc" data-id="<?php echo $tid ?>" data-toggle="modal">
                        <?php
                            if(!array_key_exists($tid, $ratescore))
                                echo 'Rate for Song';
                            else
                                echo 're-Rate for Song';
                        ?>
                     </a>
                </li>
	        </ul>
	    </div>
	</div>
</div>
<div class="modal fade" id="AddSong" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel1">
                        Add to...
                    </h4>
                </div>
                <div class="modal-body">
                <form role="form" action="" method="post">
                    <input type="hidden" value="" name="trackid" id="trackids">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Choose a Playlist</label>
                        <select class="form-control" name="Playlists">
                            <?php
                            $playlists = findplaylist($uid); 
                            foreach($playlists as $pl)
                            {
                                echo '<option value="'.$pl[0].'">'.$pl[1].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Add</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Rate" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel2">
                        Rating
                    </h4>
                </div>
                <div class="modal-body">
                <form role="form" action="" method="post">
                    <input type="hidden" value="" name="traid" id="trid">
                    <div class="form-group">
                        <label for="exampleFormControlSelect2">What do you think?</label>
                        <select class="form-control" name="points">
                            <option value=1>1</option>
                            <option value=2>2</option>
                            <option value=3>3</option>
                            <option value=4>4</option>
                            <option value=5>5</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="rate">Rate</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    table{
        table-layout: fixed;
    }
</style>
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
