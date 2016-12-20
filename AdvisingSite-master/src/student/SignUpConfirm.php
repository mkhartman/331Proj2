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
  

echo "Your appointment has been added. Your new meeting is: <br><br>";

$studentID = $_SESSION["STUDENT_ID"];
$filename = "SignUpConfirm.php";


//query to obtain meeting id corresponding to student from student meeting table
$select_Meeting_ID  = "SELECT MeetingID FROM StudentMeeting WHERE StudentID = $studentID";
$select_results = $COMMON->executequery($select_Meeting_ID, $filename);
$results_row = mysql_fetch_array($select_results);
$currentApptIDVal = $results_row[0];
$selectMeetingData = "SELECT * FROM Meeting WHERE meetingID = $currentApptIDVal";

$rs = $COMMON->executequery($selectMeetingData, $filename);
$meetingDict = mysql_fetch_assoc($rs);

$_SESSION["CURRENT_MEETING_ID"] = $meetingDict["meetingID"];
$_SESSION["CURRENT_START_TIME"] = $meetingDict["start"];
$_SESSION["CURRENT_END_TIME"] = $meetingDict["end"];
$_SESSION["CURRENT_APPT_BUILDING"] = $meetingDict["buildingName"];
$_SESSION["CURRENT_APPT_ROOM"] = $meetingDict["roomNumber"];


echo("<table>");

// printing advisor
echo("<tr>");
echo("<td>Advisor:</td>");
echo("<td>");

// getting advisor's name
$sql = "select * from `AdvisorMeeting` where `meetingID` = '" . $_SESSION["CURRENT_MEETING_ID"] . "'";
$rs = $COMMON->executeQuery($sql, $filename);
$row2 = mysql_fetch_assoc($rs);

$sql = "select * from `Advisor` where `advisorID` = '" . $row2['advisorID'] . "'";
$rs = $COMMON->executeQuery($sql, $filename);
$row3 = mysql_fetch_assoc($rs);

echo($row3['firstName'] . " " . $row3['lastName']);
// write here
echo("</td>");
echo("</tr>");

// printing start time
$time = $_SESSION["CURRENT_START_TIME"];
echo("<tr>");
echo("<td>Time:</td>");
echo("<td> ");

date_default_timezone_set("America/New_York");
$date = date_create_from_format ('Y-m-j H:i:s', $_SESSION["CURRENT_START_TIME"]);
$newdate = date_format($date, 'l - F d, Y @ H:i');
echo($newdate);

// printing am or pm
if ((int)substr($time, 11, 2) == 24)
  echo("am");
else if ((int)substr($time, 11, 2) >= 12)
  echo("pm");
    else
      echo("am");
echo("</td>");
echo("</tr>");

// printing location
echo("<tr>");
echo("<td>Location:</td>");
echo("<td>" . $_SESSION["CURRENT_APPT_BUILDING"] . " " . $_SESSION["CURRENT_APPT_ROOM"] . "</td>");
echo("</tr>");

// printing type of meeting
echo("<tr>");
echo("<td>MeetingType:</td>");

if ($meetingDict['meetingType'] == 0) 
  echo("<td>Single</td>");
else
  echo("<td>Group</td>");
echo("</table><br>");

echo "Would you like to leave a comment/question to your Advisor?\n" 
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
