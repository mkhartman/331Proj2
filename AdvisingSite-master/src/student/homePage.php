<?php
session_start();

if($_SESSION["HAS_LOGGED_IN"]){
  include '../CommonMethods.php';
  include 'header.php';
  if($_POST){
    $studentID = $_SESSION["STUDENT_ID"];
    
    //connect to database
    $debug = true;
    $COMMON = new Common($debug);
    $filename = "index.php";
    
    //declaring variable equal to session variable used for query
    $studentID = $_SESSION["STUDENT_ID"];
    
    //search for scheduled appointment
    $scheduledAppt = "SELECT MeetingID FROM StudentMeeting WHERE StudentID = 'studentID'";
    
    $currentAppt = $COMMON->executequery($scheduledAppt, $filename);
     
  }
  
}
?>

<html>
<head>
     <title>Student Homepage</title>
</head>
<body>
<div class="container">
      <h1>Student Home</h1>

<?php 
if ($_SESSION["HAS_LOGGED_IN"]) { 
  
  $debug = false;
  $COMMON = new Common($debug);
  $filename = "index.php";
  $sql = "select * from Student where email = " . "'{$_SESSION["STUDENT_EMAIL"]}'";
  $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
  $row = mysql_fetch_assoc($rs);
  
  
  echo '<h3>';
  echo 'Welcome ' . $row['firstName'];
  echo '</h3>';
  
  
  $filename = "viewMeeting.php";
  
  $studentID = $_SESSION["STUDENT_ID"];
  
  //query to obtain meeting id corresponding to student from student meeting table
  $select_Meeting_ID  = "SELECT MeetingID FROM StudentMeeting WHERE StudentID = $studentID";

  //defining valuable == to meeting id returned by query
  $select_results = $COMMON->executequery($select_Meeting_ID, $filename);
 
  if(mysql_num_rows($select_results) == 0){
    echo "<br>You have not scheduled any appointments.<br>";
  }
  else{
    //fetching value from query result
    $results_row = mysql_fetch_array($select_results);
    
    //defining variable as array variable
    $currentApptIDVal = $results_row[0];
    
    $selectMeetingData = "SELECT * FROM Meeting WHERE meetingID = $currentApptIDVal";
    
    $rs = $COMMON->executequery($selectMeetingData, $filename);
    
    $meetingDict = mysql_fetch_assoc($rs);
    
    $_SESSION["CURRENT_MEETING_ID"] = $meetingDict["meetingID"];
    $_SESSION["CURRENT_START_TIME"] = $meetingDict["start"];
    $_SESSION["CURRENT_END_TIME"] = $meetingDict["end"];
    $_SESSION["CURRENT_APPT_BUILDING"] = $meetingDict["buildingName"];
    $_SESSION["CURRENT_APPT_ROOM"] = $meetingDict["roomNumber"];
    
    
    echo("Your current meeting:");
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
    
    // printing end time
    $time = $_SESSION["CURRENT_END_TIME"];
    echo(" to ");
    
    $date = date_create_from_format ('Y-m-j H:i:s', $_SESSION["CURRENT_END_TIME"]);
    $newdate = date_format($date, 'H:i');
    echo($newdate);
    
    // printing the time am or pm
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
    
    echo("</tr>");
    echo("</table>");
    
  }
  
}
  
?>
  
</body>
</html>

<br>
<br>
<br>
<a href="changeInfo.php">Edit My Info</a>
<br>
<br>
<br>
<a href="chooseMeeting.php">Schedule Advising Appointment</a>
<br>
<br>
<br>
<a href="cancelMeeting.php">Cancel Advising Appointment</a>
<br>
<br>
<br>
<a href="logout.php">Log out</a>
<br>
<br>
</div>
</html>
