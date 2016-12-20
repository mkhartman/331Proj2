<?php
include '../../CommonMethods.php';
include 'header.php';
session_start();
//declare and define empty login_error                                        
$login_error = "";
$email_error_message = "";



?>     


<html>
<head>
    <title>Forgot Password</title>
</head>


   <body>
<div class="container">
 <!-- <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> -->

<h1>
    Forgot your password?
</h1>

   <br>
  <h3> Please enter your email.. <h3>


<br>

  <form action="forgotPass.php" method="POST" name="pass">
    <label>E-mail: </label><input type="text" name="email">
  <span class="error"> 
  <?php if(isset($_SESSION["emailErrorMessage"])) 
{
  echo htmlspecialchars($_SESSION["emailErrorMessage"]);
  unset($_SESSION["emailErrorMessage"]);
} ?> </span>
  <br>
        <input class="submit" type="submit">
  <br>
  </form>
<br>
<a href="index.php">Back </a>

  
</form>
</div>
</body>
</html>