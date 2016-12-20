<?php
include('../CommonMethods.php');
session_start();
include'header.php';

$COMMON = new Common(false);
$fileName = "chooseIndividualMeeting.php";
//checks if season is closed
$checkSeason = "SELECT * FROM `Advisor` WHERE `closed`=False";
$result = $COMMON->executequery($checkSeason, $fileName);
$allRows = mysql_num_rows($result);
?>
<div class="container">
<?php
if($allRows) { 
  //check if the student has a meeting
  $checkForMeeting = "Select * FROM StudentMeeting Where StudentMeeting.StudentID =". $_SESSION['STUDENT_ID'];
  $rs = $COMMON->executequery($checkForMeeting,$fileName);
  $numRows = mysql_fetch_array($rs);

  if($numRows>0){
    header('Location:meetingChosen.php');
  }
  else {
    echo"<table>";
    echo'<strong><font size="6">Filter</strong></font>';
    echo'<form action="SignUpFilter.php" method="post" name="SignUpConfirm">';
    
    // choosing which type of appointment
    echo'<tr><td>Choose your type of appointment: </td><td> <select name="ddApointment">';
    echo'<option>Group</option>';
    echo'<option>Individual</option>';
    echo'</select></td></tr><br><br>';
    
    // choosing date range
    echo'<tr><td>Date Range: <input type="date" name="dateBefore"> </td><td> To <input type="date" name="dateAfter"></td></tr><br>';
    
    // choosing time range
    echo'<tr><td>Time Range: <select name="ddTimeBefore">';
    echo'<option>08:00 am</option>';
    echo'<option>08:30 am</option>';
    echo'<option>09:00 am</option>';
    echo'<option>09:30 am</option>';
    echo'<option>10:00 am</option>';
    echo'<option>10:30 am</option>';
    echo'<option>11:00 am</option>';
    echo'<option>11:30 am</option>';
    echo'<option>12:00 am</option>';
    echo'<option>12:30 am</option>';
    echo'<option>01:00 pm</option>';
    echo'<option>01:30 pm</option>';
    echo'<option>02:00 pm</option>';
    echo'<option>02:30 pm</option>';
    echo'<option>03:00 pm</option>';
    echo'<option>03:30 pm</option>';
    echo'<option>04:00 pm</option>';
    echo'<option>04:30 pm</option>';
    echo'</select>';
    
    echo'</td><td> To ';
    
    echo'<select name="ddTimeAfter">';
    echo'<option>08:00 am</option>';
    echo'<option>08:30 am</option>';
    echo'<option>09:00 am</option>';
    echo'<option>09:30 am</option>';
    echo'<option>10:00 am</option>';
    echo'<option>10:30 am</option>';
    echo'<option>11:00 am</option>';
    echo'<option>11:30 am</option>';
    echo'<option>12:00 am</option>';
    echo'<option>12:30 am</option>';
    echo'<option>01:00 pm</option>';
    echo'<option>01:30 pm</option>';
    echo'<option>02:00 pm</option>';
    echo'<option>02:30 pm</option>';
    echo'<option>03:00 pm</option>';
    echo'<option>03:30 pm</option>';
    echo'<option>04:00 pm</option>';
    echo'<option>04:30 pm</option>';
    echo'</td></tr></select><br>';
    
    // print each of the counselor in AdvisorInfo database
  
/*    echo'<br><br><tr><td>';
    echo'<tr><td>Choose your advisor: </td><td> 
     <select name="ddAdvisor">';
    echo'<option>Ms. Michelle Bulger</option>';
    echo'<option>Mrs. Julie Crosby</option>';
    echo'<option>Ms. Christine Powers</option>';
    echo'<option>CNMS Advisors</option>';
*/
    echo'</table>';
    echo'<input class="submit" name="Confirm" type="submit">';
    echo'</form>';
  }
}
else {
  header('Location:closed.php');
}    
echo '<form action="homePage.php">';
echo '<input class="submit" type="submit" value ="Home">';
echo '</form>';

?>
</div>
</body>
</html>
