<?php
session_start();
?>

<html>
<head>
    <title>Edit Meetings</title>
</head>

<body>
<div class="container">
<h1>Edit Meetings</h1>
<br><br>

<table style="width:100%" >
 <tr>
    <th></th>
    <th>Campus ID</th>
    <th>Last Name</th>
    <th>First Name</th>
    <th>Major</th>
    <th>Career Goals</th>
    <th>Questions and Concerns</th>
  </tr>
  <tr>

<?php
    if ($_SESSION["HAS_LOGGED_IN"] and $_POST) {

      include '../utils/dbconfig.php';
      include 'header.php';

      // ID That needs to be deleted
      // Advisor ID
      // Use assigned variable stored in session
      $selectedMeetingID = $_POST["meetingID"];
      $open_connection = connectToDB();

      $findMeeting = "SELECT * FROM Meeting WHERE meetingID=$selectedMeetingID";
      $row = $open_connection->query($findMeeting);
      $data = $row->fetch_assoc();
      $building = $data['buildingName'];
      $room = $data['roomNumber'];
      $type = $data['meetingType'];


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
      <form action="../utils/forms/editMeeting.php" method="POST">
	<td align="center"><input type="checkbox" name="student[]" value="<?php echo $info['schoolID'];?>">
	<td align="center"><?php echo $info['schoolID'];?></td>
	<td align="center"><?php echo $info['lastName']; ?></td>
        <td align="center"><?php echo $info['firstName']; ?></td>
        <td align="center"><?php echo $info['major']; ?></td>
        <td align="center"><?php echo $info['career']; ?></td>
        <td align="center"><?php echo $info['comment']; ?></td>
	</tr>
<?php
      }
?>
</table><br>
      <input name="ID" value="<?php echo $selectedMeetingID ?>" hidden>
      <input type="text" name="building" placeholder="Building Name" value="<?php echo $building ?>">
      <input type="text" name="room" placeholder="Room Number" value="<?php echo $room ?>">
      <select name="type">
      <option hidden="hidden">
      <?php if ($type == 0) {
	echo "Individual";}
      else {
	echo "Group";
      }?>
      <option value="Individual">Individual</option>
      <option value="Group">Group</option>
      </select>
      
      <input class="submit" type="submit" value="Make Changes">
      <br><br>
      </form>
      <form action="../utils/forms/deleteMeeting.php" method="POST">
	<input type="hidden" value="<?php echo $selectedMeetingID; ?>" name="meetingID">
      <input class="submit" type="submit" value="Delete Meeting">
	</form>

<a href="homepage.php" >Back to homepage</a>
<?php

    }

?>
</div>
</body>
</html>
