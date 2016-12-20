<?php

session_start();
if ($_SESSION["HAS_LOGGED_IN"]) {
  include '../dbconfig.php';
  include 'header.php';

  $ID = $_SESSION["ADVISOR_ID"];
  $open_connection = connectToDB();
  $change = "UPDATE `Advisor` SET `closed`=1 WHERE `advisorID`=$ID";
  $open_connection->query($change);
  
  $open = array();
  $ifAllClosed = "SELECT * FROM Advisor WHERE closed=0";
  $row = $open_connection->query($ifAllClosed);
  while ($opened = $row->fetch_assoc()) {
    array_push($open, $opened);
  }
  if (!$open) {
    $all_meetings = array();
    $deleteEverything = "SELECT * FROM Meeting";
    $row = $open_connection->query($deleteEverything);
    while ($meeting = $row->fetch_assoc()) {
      array_push($all_meetings, $meeting);
    }
    foreach ($all_meetings as $meet) {
      $meetingID = $meet["meetingID"];
      echo $meetingID;
      $deleteFromAdvisorMeeting = "DELETE FROM AdvisorMeeting WHERE meetingID=$meetingID";
      $open_connection->query($deleteFromAdvisorMeeting);

      $deleteFromStudentMeeting = "DELETE FROM StudentMeeting WHERE MeetingID=$meetingID";
      $open_connection->query($deleteFromAdvisorMeeting);

      $deleteFromMeeting = "DELETE FROM Meeting WHERE meetingID=$meetingID";
      $open_connection->query($deleteFromMeeting);
    }
  }
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


