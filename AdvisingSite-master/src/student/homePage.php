<?php
session_start();

if($_SESSION["HAS_LOGGED_IN"]){
  include '../CommonMethods.php';
  include 'header.php';
  
  $studentID = $_SESSION["STUDENT_ID"];
    
  //connect to database
  $debug = true;
  $COMMON = new Common($debug);
  $filename = "index.php";
  
  //declaring variable equal to session variable used for query
  $studentID = $_SESSION["STUDENT_ID"];
  
  //search for scheduled appointment
  $scheduledAppt = "SELECT MeetingID FROM StudentMeeting WHERE StudentID = '$studentID'";
  
  $currentAppt = $COMMON->executequery($scheduledAppt, $filename);
    
  
  // Grab appointment info
  $debug = false;
  $COMMON = new Common($debug);
  $filename = "index.php";
  $selectMeetingID = "SELECT MeetingID FROM StudentMeeting WHERE StudentID = $studentID";
  $selectResults = $COMMON->executequery($selectMeetingID, $_SERVER["SCRIPT_NAME"]);
  if(mysql_num_rows($selectResults) == 0){
    $noMeetMsg = "You do not have any scheduled appointments";
    $hasMeet = false;
  }
  else{
    // Grab the meeting ID
    $hasMeet = true;
    $resultsRow = mysql_fetch_array($selectResults);
    $currApptIDVal = $resultsRow[0];
    
    // Grab the rest of the info
    $selectMeetingData = "SELECT * FROM Meeting WHERE meetingID = $currApptIDVal";
    $rs = $COMMON->executequery($selectMeetingData, $filename);
    
    $meetingDict = mysql_fetch_assoc($rs);
    $_SESSION["CURRENT_MEETING_ID"] = $meetingDict["meetingID"];
    $_SESSION["CURRENT_START_TIME"] = $meetingDict["start"];
    $_SESSION["CURRENT_END_TIME"] = $meetingDict["end"];
    $_SESSION["CURRENT_APPT_BUILDING"] = $meetingDict["buildingName"];
    $_SESSION["CURRENT_APPT_ROOM"] = $meetingDict["roomNumber"];



  }
  
}


?>
<html>
<head>
<title>Student Homepage</title>
</head>


<body>

<div class="container">

  <?php if($_SESSION["HAS_LOGGED_IN"]){ ?>
     <h3>
     Welcome <?php echo htmlspecialchars($_SESSION["STUDENT_EMAIL"]); ?>
     </h3>
					<?php } ?>
					
					
  <div class="leftPanel">
   <br><br><br>
   <a href="chooseMeeting.php">Schedule an Appointment</a>
   <br><br><br>
   <a href="cancelMeeting.php">Cancel Appointment</a>
   <br><br><br>
   <a href="logout.php">Logout</a>
   <br>
  <div class="rightPanel">
  <?php if($hasMeet){ ?>
   <br><br><br>
   <table>
   <tr>
   <td>Advisor:</td>
   <td>

  <?php
  // Get advisor name
  $sql = "select * from `AdvisorMeeting` where `meetingID` = '" . $_SESSION["CURRENT_MEETING_ID"] . "'";
  $rs = $COMMON->executeQuery($sql, $filename);
  $row2 = mysql_fetch_assoc($rs);
    
  $sql = "select * from `Advisor` where `advisorID` = '" . $row2['advisorID'] . "'";
  $rs = $COMMON->executeQuery($sql, $filename);
  $row3 = mysql_fetch_assoc($rs);
    
  echo($row3['firstName'] . " " . $row3['lastName']);
?>

  </td>
  </tr>

  <?php 
  
  $time = $_SESSION["CURRENT_START_TIME"];
  echo("<tr>");
  echo("<td>Time:</td>");
  echo("<td> ");
    
  date_default_timezone_set("America/New_York");
  $date = date_create_from_format ('Y-m-j H:i:s', $_SESSION["CURRENT_START_TIME"]);
  $newdate = date_format($date, 'l - F d, Y @ H:i');
  echo($newdate);

 
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

  ?>

  </div>
  
</div>  

<!--
<html>
<head>
     <title>Student Homepage</title>
</head>
<body>
<div class="container">
      <h1>Student Home</h1>

<?php if ($_SESSION["HAS_LOGGED_IN"]) { ?>

    <h3>
     Welcome <?php echo htmlspecialchars($_SESSION["STUDENT_EMAIL"]); ?>
    </h3>
<?php } ?>

</body>
</html>

<html>

<br>
<a href="viewMeeting.php">View Scheduled Appointment</a>
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
</html> -->