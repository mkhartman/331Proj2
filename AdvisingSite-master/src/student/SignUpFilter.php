<?php
include('../CommonMethods.php');
session_start();
$filename = "SignUpFilter.php";

// this page show all the meeting that match the student's filter

$Type = $_POST["ddApointment"];      // Type of appointment, single or group
$DateBefore = $_POST["dateBefore"];  // Range of day that is filtered, this is before of the two
$DateAfter = $_POST["dateAfter"];    // Range of day that is filtered, this is later of the two
$TimeBefore = $_POST["ddTimeBefore"];// The range of the time, this is the before of the two
$TimeAfter = $_POST["ddTimeAfter"];  // The range of the time, this is the later of the two

// changing the TimeBefore to the correct format
if (substr($TimeBefore, -2) == "am") 
  $TimeBefore = substr($TimeBefore, 0, 5) . ":00"; 
else  // if the time is pm, just add 12 to the hour
  $TimeBefore = ((int)substr($TimeBefore, 0, 2) + 12 . substr($TimeBefore, 2, 3) . ":00");

// changing the TimeAfter to the correct format
if (substr($TimeAfter, -2) == "am") 
  $TimeAfter = substr($TimeAfter, 0, 5) . ":00"; 
else  // if the time is pm, just add 12 to the hour
  $TimeAfter = ((int)substr($TimeAfter, 0, 2) + 12 . substr($TimeAfter, 2, 3) . ":00"); 

$maxNumStudents;
if ($Type == "Group") {
  $Type = 1;
  $maxNumStudents = 10;
}
else {
  $Type = 0;
  $maxNumStudents = 1;
}

$debug = false;
$COMMON = new Common($debug);	      
$sql = "select * from `Meeting` order by `Meeting`.`start` asc";
$rs = $COMMON->executeQuery($sql, $filename);

echo'<strong>Choose One Appointment</strong><br>';
echo'<form action= "SignUpConfirm.php" method="post" name="Confirm">';

$test = 0;
$numAppointmentMatch = 0; // number of appointment that match description
while ($row = mysql_fetch_assoc($rs)) {

  // since the time is stored as DateTime type in Meeting database, the format is
  // yyyy-dd-mm hh:mm:ss so we ahve to seperate the time
  $AppointmentDate = substr($row['start'], 0, 10);     // Date of appointment
  $AppointmentTime = substr($row['start'], 11);        // Time of appointment  

  
  // making sure if the current meeting is in range
  
  if ((($AppointmentDate >= $DateBefore) and ($AppointmentDate <= $DateAfter)) 
      and (($AppointmentTime >= $TimeBefore) and ($AppointmentTime <= $TimeAfter)) 
      and ($row['numStudents'] < $maxNumStudents) // make sure appoint still have room
      and ($Type == $row['meetingType']) // matching appointment type  
      ){
    
    // Appoints that have match the criterias
    echo("<table>");
    echo('<tr>');
    echo('<td><input type="checkbox" name="appointment" value="' . $row['meetingID'] . '"></td>');
    echo('</tr>');
    echo("<tr>");
    echo("<td>Advisor:</td>");
    echo("<td>");
    
    
    // getting advisor's name
    $sql = "select * from `AdvisorMeeting` where `meetingID` = '" . $row['meetingID'] . "'";
    $rs2 = $COMMON->executeQuery($sql, $filename);
    $row2 = mysql_fetch_assoc($rs2);
    
    $sql = "select * from `Advisor` where `advisorID` = '" . $row2['advisorID'] . "'";
    $rs3 = $COMMON->executeQuery($sql, $filename);
    $row3 = mysql_fetch_assoc($rs3);
    
    echo($row3['firstName'] . " " . $row3['lastName']);
    

    // write here
    echo("</td>");
    echo("</tr>");

    // printing start time
    $time = $row['start'];
    echo("<tr>");
    echo("<td>Time:</td>");
    echo("<td> ");
    
    date_default_timezone_set("America/New_York");
    $date = date_create_from_format ('Y-m-j H:i:s', $row['start']);
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
    $time = $row['end'];
    echo(" to ");
    
    $date = date_create_from_format ('Y-m-j H:i:s', $row['end']);
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
    echo("<td>" . $row['buildingName'] . " " . $row['roomNumber'] . "</td>");
    echo("</tr>");
    
    // printing type of meeting
    echo("<tr>");
    echo("<td>MeetingType:</td>");
    
    
    if ($Type == 1)
      echo("<td>Group</td>");
    else
      
      echo("<td>Individual</td>");

    echo("</tr>");
    echo("</table>");
 
    
    $numAppointmentMatch++;
        
    
  } 
  
}

if ($numAppointmentMatch == 0) {
  echo ("There were no matches.<br>");
  echo '</form>';
}

else { 
  echo '<button name="Confirm" type="submit">Confirm</button>';
  echo '</form>';
}
mysql_free_result($rs);

?>

<form action="chooseMeeting.php">
   <input type="submit" value = "Change Filter">
</form>

<form action="homePage.php">
   <input type="submit" value = "Go Home">
</form>
