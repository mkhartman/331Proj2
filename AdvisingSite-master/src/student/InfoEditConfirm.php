<?php
include '../CommonMethods.php';
session_start();

// this file will access the database and change all the data for the specific Student ID

// please see 00ProjectGuide.txt for notes about $_SESSION
$_SESSION["FIRST_NAME"] = $_POST["tfNewFname"]; // first name of student "tf" stand for text field
$_SESSION["LAST_NAME"] = $_POST["tfNewLname"]; // last name of student 
$_SESSION["STUDENT_EMAIL"] = $_POST["tfNewEmail"]; // email of student
$_SESSION["MAJOR"] = $_POST["ddNewMajor"]; // Major of Student, "dd" stand for drop down

// using sql update query to change the information based on Student ID
$debug = false;
$COMMON = new Common($debug);
$sql = "update `Student` set 
`firstName` = '" . $_SESSION["FIRST_NAME"] . "', 
`lastName` = '" . $_SESSION["LAST_NAME"] . "',
`email` = '" . $_SESSION["STUDENT_EMAIL"] . "',
`major` = '" . $_SESSION["MAJOR"] . "'
where `email` = '" . $_SESSION["STUDENT_EMAIL"]. "'";

$filename = "InfoEditConfirm.php";
$rs = $COMMON->executeQuery($sql, $filename);

echo "Your information have been changed!";

echo '<form action="homePage.php">';
echo '<input type="submit" value ="Home">';
echo '</form>';
?>

