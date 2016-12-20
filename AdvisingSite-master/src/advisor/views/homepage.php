<?php
include ('header.php');
session_start();

if (!isset($_SESSION["HAS_LOGGED_IN"])) {
    header('Location: index.php');
}
// IF THERE ARE LOGGED IN
if ($_SESSION["HAS_LOGGED_IN"]) {
    include '../utils/dbconfig.php';
}
?>

<html>
<head>
    <title>Advisor Homepage</title>
</head>
<body>
<div class="container">
<h1> Adviser Home </h1>
<table style="width:100%">
  <tr>
    <th>Start Date and Time</th>
    <th>End Date and Time</th>
    <th>Building Name</th>
    <th>Room Number</th>
    <th>Type of Meeting</th>
    <th>Number of students</th>
  </tr>

<?php if ($_SESSION["HAS_LOGGED_IN"]) { ?>
    <h3>
        Welcome <?php echo htmlspecialchars($_SESSION["ADVISOR_FNAME"]); ?>
    </h3>
   <?php
									   
  $ID = $_SESSION["ADVISOR_ID"];
  $open_connection = connectToDB();
  $result = "SELECT * FROM Advisor WHERE advisorID=$ID";
  $connect = $open_connection->query($result);
  $data = $connect->fetch_assoc();
  $status = $data['closed'];
  if ($status == "true") {
    echo "Not Open";
  }

  ?>
    <a href="seasonStatus.php">Season Status</a>               
       <a href="register.php">Create Advisor</a>
       <a href="createMeeting.php">Create Single Meeting</a>
       <a href="createMultipleMeeting.php">Create Multiple Meeting</a>
       <a href="viewAllApointments.php">View all appointments</a>
       <a href="logout.php">Log Out</a>
<br><br>
       <?php } 

$all_meetings = array();

$meetings = "SELECT * FROM Meeting ORDER BY start ASC";
$row = $open_connection->query($meetings);

$all_meetings = array();
while ($meet = $row->fetch_assoc()) {
  array_push($all_meetings, $meet);
}
foreach ($all_meetings as $appointment) {
  //finds the meetings that are for the logged in advisor
  $meetingID = $appointment['meetingID'];
        $findInAdvisorMeetings = "SELECT * FROM AdvisorMeeting WHERE
         meetingID=$meetingID";
        $row2 = $open_connection->query($findInAdvisorMeetings);
        $data = $row2->fetch_assoc();
	$currentAdvisor = $_SESSION["ADVISOR_ID"];
        $advisorID = $data['advisorID'];
        if ($currentAdvisor == $advisorID) {
?>
          <tr>
          <form action="viewEditMeeting.php" method="POST">
            <input name="meetingID" value="<?php echo $appointment['meetingID']; ?>" hidden/>
            <td align="center"><input type="submit" value="<?php echo $appointment['start'];?>"></td>
            <td align="center"><input type="submit" value="<?php echo $appointment['end'];?>"></td>
            <td align="center"><input type="submit" value="<?php echo $appointment['buildingName'];?>"></td>
            <td align="center"><input type="submit" value="<?php echo $appointment['roomNumber'];?>"></td>
            <td align="center"><input type="submit" value="<?php if ($appointment['meetingType'] == 0) {
            echo "Individual";
          }
          else {
            echo "Group";
          }?>"></td>
            </form>
            <form action="viewStudents.php" method="POST">
            <input name="meetingID" value="<?php echo $appointment['meetingID']; ?>" hidden/>
            <td align="center"><input type="submit" value="<?php if ($appointment['numStudents']<0) {
            echo "Empty";
            }
            else {
            echo $appointment['numStudents'];
            }?>"></td>
</form>
	    <?php }
}?>

</tabl>
</div>
</body>
</html>
