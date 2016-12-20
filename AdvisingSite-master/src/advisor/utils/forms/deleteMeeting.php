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

<h3> This appointment has been deleted <h3>

<?php
if ($_SESSION["HAS_LOGGED_IN"] and $_POST) {

    include '../dbconfig.php';
    include 'header.php';

    // ID That needs to be deleted
    // Advisor ID
    // Use assigned variable stored in session
    $advisorID = $_SESSION["ADVISOR_ID"];
    $selectedMeetingID = $_POST["meetingID"];

    $open_connection = connectToDB();

    // Delete from AdvisorMeeting
    $deleteFromAdvisorMeeting = "
      DELETE FROM AdvisorMeeting
      WHERE meetingID = '$selectedMeetingID'
    ";
    $open_connection->query($deleteFromAdvisorMeeting);

    // Delete from Meeting
    $deleteFromMeeting = "
      DELETE FROM Meeting
      WHERE meetingID = '$selectedMeetingID'
    ";
    $open_connection->query($deleteFromMeeting);

    $findStudents = "
      SELECT * FROM StudentMeeting 
      WHERE MeetingID=$selectedMeetingID";
    
    $row = $open_connection->query($findStudents);

    $students = array();
    while ($stud = $row->fetch_assoc()) {
      array_push($students, $stud);
    }
    foreach ($students as $student) {
      $id=$student['StudentID'];
      $information = "SELECT * FROM Student 
      WHERE StudentID=$id"; 
      $row = $open_connection->query($information);
      $info = $row->fetch_assoc();
      echo $info['firstName']." ". $info['lastName']." - ".
	$info['email']."<br>";
    }
    echo "<br><b>Please notify these students at their email. There is a button on the button right that will open a new tab with gmail.";

    $deleteFromStudentMeeting= "
      DELETE FROM StudentMeeting 
      WHERE MeetingID= $selectedMeetingID";

    $open_connection->query($deleteFromStudentMeeting);

    $open_connection->close();
}

?>
<br><br>
<a target='_blank' href="https://www.gmail.com/" style="float:right;">Email</a>
<a href="../../views/homepage.php">Back to Homepage</a>
</div>
</body>
</html>

