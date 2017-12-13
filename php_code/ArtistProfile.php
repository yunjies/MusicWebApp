<?php
session_start();
$uid = $_SESSION['uid'];
settype($uid, 'string');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Artist Information</title>
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
        <?php include "widget.php" ?>
        <div class="col-md-12 column">
            <div class="row clearfix">
                <div class="col-md-8 column">
                    <div class="page-header">
                        <h1 style ="font-size:50px;"> 
                            <?php echo $aname;?> <small><?php echo $ArtistDesc;?></small>
                        </h1>
                        <?php
                            $likeSql = "SELECT * FROM Favorite Where uid = '$uid' and aid = '$aid';";
                            $Likeresult = $conn->query($likeSql);
                             echo '<a href="to_like.php?aid='.$aid.'">';
                            if ($Likeresult->num_rows > 0) {
                                echo "<button type='button' class='btn btn-info'>Dislike</button>";
                            }
                            else{
                                echo "<button type='button' class='btn btn-info'>Like</button>";
                            }
                            ?>
                        </a>
                    </div>
                </div>
            <div class="row clearfix">
                <div class="col-md-12 column">
                    <div class="row clearfix">
                        <?php 
                        if($alert)
                        {
                            if(!$alertErr)
                            {
                                echo
                                '<div class="alert alert-success alert-dismissable">
                                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4>
                                        Added to Playlist Successfully!!
                                    </h4> 
                                </div>';
                            }
                            else
                            {
                                echo
                                '<div class="alert alert-danger alert-dismissable">
                                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4>
                                        Song Exists!
                                    </h4> 
                                </div>';
                            }
                        }
                        ?>
                    </div>
                        <div class="row clearfix">
                        <?php 
                        if($added)
                        {
                            if(!$addedErr)
                            {
                                echo
                                '<div class="alert alert-success alert-dismissable">
                                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4>
                                        Rate song successfully!
                                    </h4> 
                                </div>';
                            }
                            else
                            {
                                echo
                                '<div class="alert alert-danger alert-dismissable">
                                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4>
                                        You have already rated!
                                    </h4> 
                                </div>';
                            }
                        }
                        ?>
                    </div>
                </div>
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <div class="tabbable" id="tabs-977331">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                         <a href="#panel-123456" data-toggle="tab">Songs</a>
                                    </li>
                                    <li>
                                         <a href="#panel-323143" data-toggle="tab">Albums</a>
                                    </li>
                                </ul>
                             <div class="tab-content">
                                <div class="tab-pane active" id="panel-123456">
                                    <p>
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
                                                    Rating
                                                </th>
                                                <th>
                                                    Your Rating
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                for($x = 0; $x < count($tracks); $x++) {
                                                     $td = formatSeconds( $tracks[$x][2] / 1000);
                                                    echo '<tr><td>' . ($x + 1) . '</td>
                                                          <td><a href="ArtistProfile.php?tid='.$tracks[$x][0].'">'.$tracks[$x][1].'</a></td>
                                                          <td>' . $td . '</td>
                                                          <td>' . $tracks[$x][3] . '</td>
                                                          <td>';
                                                        if(array_key_exists($tracks[$x][0], $ratescore))
                                                            echo $ratescore[$tracks[$x][0]];
                                                        else
                                                            echo 0;
                                                    echo'</td>
                                                          </tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                                <div class="tab-pane" id="panel-323143">
                                    <p>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                <th>
                                                    #
                                                </th>
                                                <th>
                                                    Album Name
                                                </th>
                                                <th>
                                                   Created
                                                </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                include "connection.php";
                                                $sql = "SELECT * FROM artist natural join album natural join Track where aid = '$aid' group by alname;";
                                                $result = $conn->query($sql);
                                                $playlist = array();
                                                if ($result->num_rows > 0) {
                                                // output data of each row
                                                $x = 1; 
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<tr><td>' . $x . '</td>
                                                          <td><a href="AlbumProfile.php?alid='.$row["alid"].'">'.$row["alname"].'</a></td>
                                                          <td>' . $row["altime"] . '</td>
                                                          </tr>';
                                                    $x++;
                                                    if($x > 50)
                                                        break;
                                                }
                                                $conn->close();
                                                }
                                                ?>   
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                             </div>
                        </div>
                    </div>
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

