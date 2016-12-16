<?php

include('../../CommonMethods.php');
$debug = true;
$COMMON = new Common($debug);
$fileName = "security.php";

$bestFri = $highSch = $firstPet = "";

$bestFri_error_message = $highSch_error_message = $firstPet_error_message = "";

if($_POST) {

  $bestFri = $_POST["bestFri"];
  $highSch = $_POST["highSch"];
  $firstPet = $_POST["firstPet"];

  $misc_error = false;

  if(empty($_POST["bestFri"])){
    $misc_error = true;
    $bestFri_error_message = "*Please enter name of your best friend.*";
  }

  if(empty($_POST["highSch"])){
    $misc_error = true;
    $highSch_error_message = "*Please enter a high school.*";
  }

  if(empty($_POST["firstPet"])){
    $misc_error = true;
    $firstPet_error_message = "*Please enter name of your first pet.*";

  }

  if($misc_error == false) {

    $sql = "INSERT INTO SecurityQuestion (bestFriend,highSchool,petName) VALUES ('$bestFri','$highSch','$firstPet')";

    $rs = $COMMON->executeQuery($sql,$fileName);
    header('Location:homepage.php');
  }
}
?>

<html>
<head>
<title>Question</title>
</head>

<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

  <h1>Set Security Questions</h1>

       <br>

  <ul>
  <br>
  <label>What is the name of your best friend </label><input type="text" name="bestFri">

  <span class="error"> <?php echo $bestFri_error_message;?></span>
  <br>

  <br>
  <label>What is the name of your high school</label><input type="text" name="highSch">

  <span class="error"> <?php echo $highSch_error_message;?></span>

  <br>

  <br>
  <label>What is your the name of your first pet </label><input type="text" name="firstPet">

  <span class ="error"> <?php echo $firstPet_error_message;?></span>
  <br>

  <input type="submit">

  </ul>
  </form>
  </body>
  </html>
