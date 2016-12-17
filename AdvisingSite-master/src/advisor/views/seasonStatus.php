<?php
session_start();

if($_SESSION["HAS_LOGGED_IN"]) {
  include '../utils/dbconfig.php';
}


?>

<div class="container">
<html>
<head>
     <title> Advising Season Status </title>
</head>
<body>
<h1>
    Advising Season Status
</h1>

  <?php if($_SESSION["HAS_LOGGED_IN"]) { ?>
  <h3> You can open or close the advising season here </h3>

<?php
   $ID = $_SESSION["ADVISOR_ID"];
   $open_connection = connectToDB();
   $result = "SELECT * From Advisor WHERE Advisor.advisorID=$ID";
   $connect = $open_connection->query($result);
   $data = $connect->fetch_assoc();
   $name = $data['closed'];
   echo "The advising season is currently: ";
   if($name == True) {
   echo 'CLOSED';
   }
   if($name == False) {
   echo 'OPEN';
   }

?>


<br>
<br>
  <a href="../utils/forms/openSeason.php">Open Season</a>

  <a href="closeConfirm.php">Close Season</a>

<br>
<br>

  <a href="homepage.php">Back to hompage</a>

					 <?php     } ?>
</div>

</body>
</html>

