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
  if (empty($email)) {
    $login_error = "Please enter an email";
  }
  else if(!preg_match('^[a-zA-Z]?@umbc.edu$^', $_POST['email'])) {
    $login_error = "Please enter a valid email";
  }
  else if( mysql_num_rows($results) == 0 ){
    $login_error = "Your email isn't registered";
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
    }
  }
}
?>

<div class="container">
<h1>Welcome to the CMNS advising site</h1>
 <img src="https://pbs.twimg.com/profile_images/651861816683851776/zGSMy69H.jpg" class ="create"/>

 <div class ="login">
<h1>Student Sign In </h1>
   
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

  <label></label><input type="text" placeholder="E-mail" name="email"  value="<?php if(isset($_POST['email'])) {echo $_POST['email']; }?>">
   <span class="error"> <?php echo "<br>"; echo $login_error;?></span>
  
  <br>
  <label><input class="submit" type="submit" value="Log In"></label>
</form>
<br>
<h3><a href="index.php"><font size="3">Don't have an account? Register here.</a></h3>

</div>
</div>


