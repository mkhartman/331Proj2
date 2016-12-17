<?php
include('../CommonMethods.php');
session_start();

$comment = $_POST['comment'];

$_SESSION["COMMENT"] = $comment;
$debug = false;
$COMMON = new Common($debug);
$sql = "update `Student` set `comment` = '$comment' where email = '" . $_SESSION["STUDENT_EMAIL"] . "' ";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

header('Location: homePage.php');

?>