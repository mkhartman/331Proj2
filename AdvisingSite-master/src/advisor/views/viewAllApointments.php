<?php
session_start();
?>

<html>
<head>
    <title>View all appointments</title>
</head>

<body>
<div class="container">
<h1>All Apointments</h1>
<h3>These are all the apointments for all the advisors</h3>
<a href="homepage.php" >Back to homepage</a>
<br><br>
<table style="width:100%">
  <tr>
    <th>Start Date and Time</th>
    <th>Campus ID</th>
    <th>Last Name</th>
    <th>First Name</th>
    <th>Major</th>
  </tr>
  <tr>
<?php
if ($_SESSION["HAS_LOGGED_IN"]) {
  include '../utils/dbconfig.php';
  include 'header.php';

  $open_connection = connectToDB();
  
  $all_meetings = array();
  
  $meetings = "SELECT * FROM Meeting WHERE numStudents > 0 ORDER BY start ASC";
  $row = $open_connection->query($meetings);

  $all_meetings = array();
  while ($meet = $row->fetch_assoc()) {
    array_push($all_meetings, $meet);
  }
  foreach ($all_meetings as $appointment) {
?>
<tr>
   <td align="center"><?php echo $appointment['start']; ?></td>
<?php
    $meetingID = $appointment['meetingID'];
    $findStudent = "SELECT * FROM StudentMeeting WHERE MeetingID=$meetingID";
    $row = $open_connection->query($findStudent);
    $students = array();
    while ($stud = $row->fetch_assoc()) {
      array_push($students, $stud);
    }
    foreach ($students as $student) {
      $ID = $student['StudentID'];
      $information = "SELECT * FROM Student WHERE StudentID=$ID";
      $row = $open_connection->query($information);
      $info = $row->fetch_assoc();
?>
      <td align="center"><?php echo $info['schoolID']; ?></td>
      <td align="center"><?php echo $info['lastName']; ?></td>
      <td align="center"><?php echo $info['firstName']; ?></td>
      <td align="center"><?php echo $info['major']; ?></td>
<?php
    }
?> <tr>
<?php
  }

}
?>
</div>
</body>
</html>
