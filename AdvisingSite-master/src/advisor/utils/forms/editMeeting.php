<?php
session_start();
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

<h3> This appointment has been changed<h3>

<?php
    if ($_SESSION["HAS_LOGGED_IN"] and $_POST) {

      include '../dbconfig.php';
      include 'header.php';
      $open_connection = connectToDB();
      // Advisor ID
      // Use assigned variable stored in session
      
      //deletes students
      if(!empty($_POST['student'])) {
	foreach($_POST['student'] as $stud) {
	  $findID = "SELECT * FROM Student WHERE schoolID='$stud'";
	  $row = $open_connection->query($findID);
	  $delete = $row->fetch_assoc();
	  $studentID = $delete['StudentID'];
	  //deletes from student meeting.
	  $deleteStudent = "DELETE FROM StudentMeeting WHERE StudentID=$studentID";	
	  $open_connection->query($deleteStudent);
	  //updates meeting size;
	  $ID = $_POST["ID"];
	  $deleteFromAdvisor = "UPDATE Meeting SET numStudents = (numStudents-1) WHERE meetingID=$ID";
	  $open_connection->query($deleteFromAdvisor);
	}
      }
      
      //makes changes to the meeting information
      //takes all the variables inputted.
      $advisorID = $_SESSION["ADVISOR_ID"];
      $meetingID = $_POST["ID"];
      $newBuild = $_POST["building"];
      $newRoom = $_POST["room"];
      if ($_POST["type"] == "Individual") {
	$newType = 0;
      }
      else {
	$newType = 1;
      }
      //updates the tables
      $edit = "UPDATE `Meeting` SET buildingName='$newBuild', roomNumber=$newRoom, meetingType=$newType WHERE meetingID=$meetingID";
      $open_connection->query($edit);

    }
?>

<a href="../../views/homepage.php">Back to homepage</a>
</div>
</body>
</htmls>