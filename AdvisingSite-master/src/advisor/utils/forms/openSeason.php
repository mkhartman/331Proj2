
<?php

session_start();
if ($_SESSION["HAS_LOGGED_IN"]) {
  include '../dbconfig.php';
  include 'header.php';

  $ID = $_SESSION["ADVISOR_ID"];
  $open_connection = connectToDB();
  $change = "UPDATE `Advisor` SET `closed`=0 WHERE `advisorID`=$ID";
  $open_connection->query($change);
}

?>
<div class="container">
<html>
<head>
    <title>Advisor Homepage</title>
</head>
<body>
<div class="container">
<h1>
    Opening Season
</h1>
<h3>
Your advising season has been opened. Students can sign up for
appointments.
</h3>
<br>
<a href="../../views/seasonStatus.php">Back</a>

<a href="../../views/homepage.php">Back To Homepage</a>

</div>
</body>
</html>

