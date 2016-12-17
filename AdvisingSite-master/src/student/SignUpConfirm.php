<?php
include('../CommonMethods.php');
session_start();


$id = $_POST['appointment'];

$debug = false;
$COMMON = new Common($debug);
// getting the number of students in that particular meeting
$sql = "select * from `Meeting` where meetingID = '" . $id . "'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$row = mysql_fetch_assoc($rs);

// new number of students for that particular meeting
$newNumStudents = $row['numStudents'];
$newNumStudents++;

// increase number of student in the meeting by 1
$sql = "update `Meeting` set `numStudents` = '$newNumStudents' where meetingID = '" . $id . "' ";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

// set the meeting of the student to 0
$create_meeting = "INSERT INTO StudentMeeting(StudentID,MeetingID)
VALUES(" . $_SESSION["STUDENT_ID"] . ",$id)";
$rs=$COMMON->executequery($create_meeting, $_SERVER["SCRIPT_NAME"]);
  

echo "Your appointment has been added!<br>";
echo "Would you like to leave a Comment to your Advisor?\n" 
?>
<br>
<form action="addComment.php" method="post" name="addComment">
<textarea name="comment" rows="5" cols="40">Enter your comments here</textarea>
<br>
<button name="Confirm" type="submit">Add Comment</button>
</form>

<form action="homePage.php">
   <input type="submit" value = "Go Home">
</form>
