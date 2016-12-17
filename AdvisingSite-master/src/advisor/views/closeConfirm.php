<?php
session_start();

if($_SESSION["HAS_LOGGED_IN"]) {
  include '../utils/dbconfig.php';
  include 'header.php';
}


?>
<div class="container">
<html>
<head>
     <title> Closing Advising Season </title>
</head>
<body>
<h1>
    Closing Advisor Season
</h1>

  <?php if($_SESSION["HAS_LOGGED_IN"]) { ?>
  <h3> You have requested to close the season </h3>
     Are you sure you want to close the season?


<br>
<br>
  <a href="../utils/forms/closeSeason.php">Yes</a>

  <a href="seasonStatus.php">No</a>

<br>
<br>
<div class="bottom" align="left">
  <a href="seasonStatus.php">Back</a>

  <a href="homepage.php">Back to homepage</a>
</div>
 <?php     } ?>
					 
</div>
</body>
</html>
