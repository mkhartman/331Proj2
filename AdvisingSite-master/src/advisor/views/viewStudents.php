<?php
session_start();
?>

<html>
<head>
    <title>View all appointments</title>
</head>

<body>
<div class="container">
<h1>The students in this appointment</h1>
<a href="homepage.php" >Back to homepage</a>
<br><br>
<table style="width:100%">
  <tr>
    <th>Start Date and Time</th>
    <th>End Data and Time</th>
    <th>Campus ID</th>
    <th>Last Name</th>
    <th>First Name</th>
    <th>Major</th>
    <th>Career Goals</th>
    <th>Questions and Concerns</th>
  </tr>
  <tr>
<?php
    if ($_SESSION["HAS_LOGGED_IN"]) {
      include '../utils/dbconfig.php';
      include 'header.php';

      $open_connection = connectToDB();

      $selectedMeetingID = $_POST["meetingID"];
      
      $meeting = "SELECT * FROM Meeting WHERE meetingID=$selectedMeetingID";
      $line = $open_connection->query($meeting);
      $data = $line->fetch_assoc();
      $all_students = array();

      $students = "SELECT * FROM StudentMeeting WHERE MeetingID=$selectedMeetingID";
      $row = $open_connection->query($students);
   
      while ($stud = $row->fetch_assoc()) {
        array_push($all_students, $stud);
      }
      foreach ($all_students as $oneStudent) {
        //finds the meetings that are for the logged in advisor
        $studentID = $oneStudent['StudentID'];
        $findStudent = "SELECT * FROM Student WHERE
         StudentID=$studentID";
        $row2 = $open_connection->query($findStudent);
        $info = $row2->fetch_assoc();	
?>
      <td align="center"><?php echo $data['start'];?></td>    
      <td align="center"><?php echo $data['end'];?></td>    

	<td align="center"><?php echo $info['schoolID']; ?></td>
	<td align="center"><?php echo $info['lastName']; ?></td>
	<td align="center"><?php echo $info['firstName']; ?></td>
	<td align="center"><?php echo $info['major']; ?></td>
	<td align="center"><?php echo $info['career']; ?></td>
	<td align="center"><?php echo $info['comment']; ?></td>
<tr>	
<?php
      }

    }
?>
</div>
</body>
</html>

