<?php
  // update the comment in both $_SESSION and in the database, then redirect to home page
include('../CommonMethods.php');
session_start();

$comment = $_POST['comment'];

// updating $_SESSION variable and database
$_SESSION["COMMENT"] = $comment;
$debug = false;
$COMMON = new Common($debug);
$sql = "update `Student` set `comment` = '$comment' where email = '" . $_SESSION["STUDENT_EMAIL"] . "' ";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

// redirecting to home page
header('Location: homePage.php');

?>