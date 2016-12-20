<?php
include ('header.php');
session_start();

if ($_SESSION["HAS_LOGGED_IN"]) {
  include '../utils/dbconfig.php';
 $open_connection = connectToDB();
    $searchAdvisors = "
      SELECT 
        `firstName`,
	`lastName`,
	`advisorID`
      FROM
        Advisor
      WHERE
        1
    ";
    $advisorSearchResults = $open_connection->query($searchAdvisors);

    $advisorNames = array();
    while ($advisorRow = $advisorSearchResults->fetch_assoc()) {
        array_push($advisorNames, $advisorRow);
    }
	$open_connection->close();
}

?>
<html>
<head>
    <title>Advisor Homepage</title>
</head>
<body>
<div class="container">
<h1>
    Create Multiple Meeting
</h1>

    <form action="../utils/forms/createMultipleMeeting.php" method="POST">

        <ul>
			
			<li> 
				<label>
					Meeting Start Date
					<input type="date" name="meetingStartDate">
				<?php
                if (isset($_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"])) {
                    echo $_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"];
                    unset($_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"]);
                }
                ?>
				</label>
			</li>
			
			<li>
				<label>
					Repeat meetings every day for <input type="number" name="meetingRepeatDays" /> days 
				</label>
			</li>
				
		
            <li>
                <label>
                    Meeting Start Time
                    <input type="time" name="meetingStartTime">
                </label>
            </li>

			<li>
                <label>
                    Meeting Length (Minutes)
                    <input type="number" name="meetingLength">
                </label>
			<label>
				Repeat every <input type="number" name="meetingRepeatTime"> minutes until <input type="time" name="meetingRepeat">
			</label>
            </li>
			
            <li>
                <label>
                    Building Name
                    <input type="text" name="buildingName">
                </label>
                <?php
                if (isset($_SESSION["ERROR_ADVISOR_MEETING_BUILDING"])) {
                    echo $_SESSION["ERROR_ADVISOR_MEETING_BUILDING"];
                    unset($_SESSION["ERROR_ADVISOR_MEETING_BUILDING"]);
                }
                ?>
			</li>

            <li>
                <label>
                    Room Number
                    <input type="text" name="roomNumber">
                </label>
                <?php
                if (isset($_SESSION["ERROR_ADVISOR_MEETING_ROOM"])) {
                    echo $_SESSION["ERROR_ADVISOR_MEETING_ROOM"];
                    unset($_SESSION["ERROR_ADVISOR_MEETING_ROOM"]);
                }
                ?>
			</li>

            <li>
                <label>
                    Type of Meeting:
                    <select name="meetingType">
                        <option value="group">Group</option>
                        <option value="individual">Individual</option>
                    </select>
                </label>
            </li>
			
			<li>
				<label>
					Meeting Advisor:
					<select name="advisor">
		                               <?php foreach ($advisorNames as $bRow) { ?>
											<option value="<?php echo htmlspecialchars($bRow["advisorID"]) ?>"> <?php echo(htmlspecialchars($bRow["firstName"] . ' ' .htmlspecialchars($bRow["lastName"]); ?> </option>
					       <?php } ?>
		                        </select>
				</label>
			</li>
			
<label>
                <input type="submit">
            </label>
        </ul>

    </form>
 <a href="homepage.php">Back to Homepage</a>
</div>
</body>
</html>
