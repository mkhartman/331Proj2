
<?php

session_start();
if ($_SESSION["HAS_LOGGED_IN"]) {
  include '../dbconfig.php';
  include 'header.php';

  $ID = $_SESSION["ADVISOR_ID"];
  $open_connection = connectToDB();
  $change = "UPDATE `Advisor` SET `closed`=1 WHERE `advisorID`=$ID";
  $open_connection->query($change);
}

?>

<html>
<head>
    <title>Advisor Homepage</title>
</head>
<body>
<div class="container">
<h1>
    Closing Season
</h1>
<h3>
Your advising season has been closed. No students can sign up for any
appointments.
</h3>
<br>
<a href="../../views/seasonStatus.php">Back</a>
<a href="../../views/homepage.php">Back To Homepage</a>
<br><br><br>
<a href="../../views/logout.php">Log Out</a>
<br>
</div>
</body>
</html>


