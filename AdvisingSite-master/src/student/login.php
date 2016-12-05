<!DOCTYPE HTML>
<html>
<head>
<style>
.error{color: #FF0000;}
</style>
</head>


<?php
  include('header.php');
  include '../CommonMethods.php';  

  //declare and define empty login_error
  $login_error = "";
  
  

  
if ($_POST) {
  $email = strtolower($_POST["email"]);
  $debug = true;
  $COMMON = new Common($debug);
  $fileName = "login.php";
  
  $login_val_query = "SELECT * FROM Student WHERE email = '$email'";
  $results = $COMMON->executequery($login_val_query, $fileName);
  
  
  //if email field is left empty or does not exist in table
  if(empty($email) || mysql_num_rows($results) == 0){
    $login_error = "Please enter a valid email.";
  }
  else{
    // Search is advisor email exists in student
    // Run raw sql query in attempt to create a new advisor
    $search_student = "SELECT * FROM Student WHERE email='$email'";
    $rs = $COMMON->executequery($search_student, $fileName);
    // Check whether or not there has been a successful adviser creation
    $num_rows = mysql_num_rows($rs);
    
    if ($num_rows == 1) {
      session_start();
      
      $studentDict = mysql_fetch_assoc($rs);
      
      $_SESSION["HAS_LOGGED_IN"] = true;
      $_SESSION["STUDENT_EMAIL"] = $studentDict["email"];
      $_SESSION["STUDENT_ID"] = $studentDict["StudentID"];
      $_SESSION["MAJOR"] = $studentDict["major"];
      
      //redirectedd to index.php
      header('Location: homePage.php');
      
      // Can only do function overloading in classes, why need to pass empty string
    }
  }
}
?>

<div class="sign-up">
<h1>Student Login Page</h1>
 <img src="https://pbs.twimg.com/profile_images/651861816683851776/zGSMy69H.jpg" class ="create"/>

 <div class ="login">
<div
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

  <label>E-mail </label><input type="text" name="email">
  <span class="error"> <?php echo $login_error;?></span>
  <br>
  <br>
  <label><input class="submit" type="submit" value="Submit"></label>

</form>

<h3><a href="index.php"><font size="3">Don't have an account? Register here.</a></h3>

</div>
</div>


