<?php
session_start();
include'../../CommonMethods.php';
include 'header.php';
$email_error_message = $login_error = $bestFri_error_message = $highSch_error_message = $petName_error_message = "";



if(isset ($_POST["email"])){

  $advisorEmail = $_POST["email"];
  //  echo $advisorEmail;

  if ($_POST) {
    $email = strtolower($_POST["email"]);

    $debug = true;
    $COMMON = new Common($debug);
    $fileName = "forgotPassEmail.php";

    //get advisorID from the email
    $search_email = "SELECT * FROM Advisor WHERE email = '$email'";
    $result_email = $COMMON->executequery($search_email, $fileName);
    $row = mysql_fetch_array($result_email);
    $advisorID = $row["advisorID"];

    //get row from the SecurityQuestion table that matches ID
    $security_sql = "Select * FROM SecurityQuestion Where advisorID = '$advisorID'";
    $rs = $COMMON->executequery($security_sql,$fileName);
    if(mysql_num_rows($rs) == 0){
      $_SESSION["emailErrorMessage"] = "*Did not set security questions*";
      header('Location: forgotPassEmail.php');
    }


    
    //if email field is left empty or does not exist in table                                                                                 
    if(empty($_POST["email"]) || mysql_num_rows($result_email) == 0){
      $_SESSION["emailErrorMessage"] = "*Please enter a valid email*";
      //$email_error_message = "*Please enter a valid email*";
      header('Location: forgotPassEmail.php');
    }

  }
  
}

if(isset ($_POST["bestFri"])) {
  
 
    
  $bestFri = $_POST["bestFri"];
  $highSch = $_POST["highSch"];
  $petName = $_POST["petName"];
  
  $debug = true;
  $COMMON = new Common($debug);
  $fileName = "forgotPass.php";

  
  $row = "Select * FROM Advisor Where Advisor.email= '$advisorEmail'";
  $rs = $COMMON->executequery($row,$fileName);
  $numRows = mysql_fetch_array($rs);
  $advisorID = $numRows['advisorID'];
  
  
  $question = "Select * FROM SecurityQuestion Where SecurityQuestion.advisorID = $advisorID";
  $ex = $COMMON->executequery($question,$fileName);
  $securityRow = mysql_fetch_array($ex);


  
    $numOfErrors = 0;

    if(empty($_POST["bestFri"])) { 
      $numOfErrors += 1;
      $bestFri_error_message = "*Please enter name of your best friend.*";
    }
    else {
      if($bestFri != $securityRow["bestFriend"]){
	$numOfErrors += 1;
	$bestFri_error_message = "*Wrong answer*";	
      }
    }
    
    if(empty($_POST["highSch"])) { 
      $numOfErrors += 1;
      $highSch_error_message = "*Please enter a high school.*";
    }
    else{
      if($highSch != $securityRow["highSchool"]){
	$numOfErrors += 1;
	$highSch_error_message = "*Wrong answer*";
      }
    }

    if(empty($_POST["petName"])) {
      $numOfErrors += 1;
      $petName_error_message = "*Please enter name of your first pet.*";      
    }
    else{
      if($petName != $securityRow["petName"]){
	$numOfErrors += 1;
	$petName_error_message = "*Wrong answer*";
      }
    }
    
    if ($numOfErrors == 0){
      header('Location: forgotPassConfirm.php');
    }
    
}    

?>

<html>
<head>
<title>Forgot Password</title>
</head>

   <body>
<div class="container">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  
  <h1> Forgot your password? </h1>
  
   <br>

  <h3> Please answer the following questions.. <h3>
  <ul>
  <br>
   <label>What is the name of your best friend </label><input type="text" name="bestFri">
  
  <span class="error"> <?php echo $bestFri_error_message;?> </span>
  <br>
  
  <br>
  <label>What is the name of your high school </label><input type="text" name="highSch">
  
  <span class="error"> <?php echo $highSch_error_message;?></span>
  
  <br>
  
  <br>
  <label>What is the name of your first pet </label><input type="text" name="petName">
  
  <span class ="error"> <?php echo $petName_error_message;?></span>
  <br>

  <input type="hidden" name="email" value= <?php echo htmlspecialchars($advisorEmail)?>>
  <input class="submit" type="submit">
  
  <a href="forgotPassEmail.php">Back </a>

  </ul>
  </form>
  </div>
  </body>
  </html>