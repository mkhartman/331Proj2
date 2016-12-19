<?php
include '../../CommonMethods.php';

//declare and define empty login_error                                        
$login_error = "";
$email_error_message = "";



if ($_POST) {
  $email = strtolower($_POST["email"]);

  $debug = true;
  $COMMON = new Common($debug);
  $fileName = "forgotPassEmail.php";

  $search_email = "SELECT * FROM Advisor WHERE email = '$email'";
  $result_email = $COMMON->executequery($search_email, $fileName);

  //if email field is left empty or does not exist in table                     
  if(empty($_POST["email"]) || mysql_num_rows($result_email) == 0){
    $email_error_message = "*Please enter a valid email*";
  }

  else{
      header('Location: forgotPass.php');
  }
}

?>     


<html>
<head>
    <title>Forgot Password</title>
</head>


   <body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<h1>
    Forgot your password?
</h1>

   <br>
  <h3> Please enter your email.. <h3>

<ul>
<br>

    <label>E-mail: </label><input type="text" name="email">
  <span class="error"> <?php echo $email_error_message;?> </span>
  <br>
   <label>
        <input type="submit">
    </label>
<a href="index.php">
  <button type="button">Back</button>
  </a>

  
</form>
</body>
</html>