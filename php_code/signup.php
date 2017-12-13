<?php
session_start();
$uname = $_POST['uname'];
$name = $_POST['name'];
$email = $_POST['email'];
$city = $_POST['city'];
$pwd = $_POST['pwd'];
settype($uname, 'string');
settype($name, 'string');
settype($pwd, 'string');
settype($email, 'email');
$_SESSION['uid']=$uname;
include "connection.php";
$sql = "INSERT INTO `User` (`uid`, `uname`, `email`, `city`, `password`) VALUES ( '".$uname."', '".$name."', '".$email."', '".$city."', '".$pwd."')";
if($conn->query($sql) === TRUE){
  setcookie("uid",$uname,time() + 60 * 5);
  header("Location:StartPage.php");
  exit;

} else {
?>
<!-- html part -->
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
 <div class="container">
  <div class="jumbotron">
    <h2 align:center>The Username has been registered.</h2>
    <h2>Please choose another one or log in directly.</h2> 
  </div>
</div>
  <div class="form">
      
      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Sign Up</a></li>
        <li class="tab"><a href="#login">Log In</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="signup">   
          <h1>Sign Up for Free</h1>
          
          <form action="signup.php" method="post">
          
            <div class="field-wrap">
              <label>
                User Name<span class="req">*</span>
              </label>
              <input type="text" name="uname" required autocomplete="on" />
            </div>
        
            <div class="field-wrap">
              <label>
                Full Name<span class="req">*</span>
              </label>
              <input type="text" name="name" required autocomplete="on"/>
            </div>

          <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email" name="email" required autocomplete="on"/>
          </div>
          <div class="field-wrap">
            <label>
              City<span class="req">*</span>
            </label>
            <input type="text" name="city" required autocomplete="on"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Set A Password<span class="req">*</span>
            </label>
            <input type="password" name="pwd" required autocomplete="on"/>
          </div>
          
          <button type="submit" class="button button-block"/>Get Started</button>
          
          </form>

        </div>
        
        <div id="login">   
          <h1>Welcome Back!</h1>
          
          <form action="login.php" method="post">
          
            <div class="field-wrap">
            <label>
              Username<span class="req">*</span>
            </label>
            <input type="text" name="uid" required autocomplete="on"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password" name ="pwd" required autocomplete="on"/>
          </div>

          <button class="button button-block"/>Log In</button>
          
          </form>

        </div>
        
      </div><!-- tab-content -->
      
</div> <!-- /form -->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script  src="js/index.js"></script>
	</body>
</html>
<!-- html part ends -->
<?php
}
exit;
?>
