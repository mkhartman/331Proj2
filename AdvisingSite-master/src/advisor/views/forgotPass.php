<?php
include'../../CommonMethods.php';
$bestFri_error = $highSch_error = $petName_error = "";

$bestFri_error_message = $highSch_error_message = $petName_error_message = "";


if ($_POST) {
  $bestFri = $_POST["bestFri"];
  $highSch = $_POST["highSch"];
  $petName = $_POST["petName"];
  
  $debug = true;
  $COMMON = new Common($debug);
  $fileName = "forgotPass.php";
  
  
  
  $search_bestFri = "SELECT * FROM SecurityQuestion WHERE bestFriend='$bestFri'";
  $search_highSch = "SELECT * FROM SecurityQuestion WHERE highSchool='$highSch'";
  $search_petName = "SELECT * FROM SecurityQuestion WHERE petName='$petName'";
  
    $result_bestFri = $COMMON->executequery($search_bestFri, $fileName);
    $result_highSch = $COMMON->executequery($search_highSch, $fileName);
    $result_petName = $COMMON->executequery($search_petName, $fileName);
    $numOfErrors = 0;

    if(empty($_POST["bestFri"]) || mysql_num_rows($result_bestFri) == 0){
      $numOfErrors += 1;
      $bestFri_error_message = "*Please enter name of your best friend.*";
    }

    if(empty($_POST["highSch"]) || mysql_num_rows($result_highSch) == 0){
      $numOfErrors += 1;
      $highSch_error_message = "*Please enter a high school.*";
    }

    if(empty($_POST["petName"]) || mysql_num_rows($result_petName) == 0){
      $numOfErrors += 1;
      $petName_error_message = "*Please enter name of your first pet.*";

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
  <label>What is the name of your high school</label><input type="text" name="highSch">
  
  <span class="error"> <?php echo $highSch_error_message;?></span>
  
  <br>
  
  <br>
  <label>What is the name of your first pet </label><input type="text" name="petName">
  
  <span class ="error"> <?php echo $petName_error_message;?></span>
  <br>


  <input type="submit">

  <a href="index.php">
  <button type="button">Back</button>
  </a>

  </ul>
  </form>
  </body>
  </html>