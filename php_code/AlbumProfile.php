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
             <?php include "widget.php" ?>
            <div class="col-md-12 column">
                <div class="row clearfix">
                    <div class="col-md-12 column">
                        <h1 style ="font-size:50px;">
                            <?php echo $alname;?>
                        </h1>
                    </div>
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
                                        Failed to rate!
                                    </h4> 
                                </div>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-12 column">
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
                                          <td><a href="AlbumProfile.php?tid='.$tracks[$x][0].'&alid='.$alid.'">'.$tracks[$x][1].'</a></td>
                                          <td>' . $td . '</td>
                                          <td>' . $tracks[$x][3] . '</td><td>';
                                        if(array_key_exists($tracks[$x][0], $ratescore))
                                            echo $ratescore[$tracks[$x][0]];
                                        else
                                            echo 0;
                                        echo '</td></tr>';
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
<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
<script src="https://code.jquery.com/jquery.js"></script>
<!-- 包括所有已编译的插件 -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>