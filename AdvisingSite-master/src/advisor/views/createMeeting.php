<?php
include ('header.php');
session_start();

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
<h1>
    Create A Single Meeting
</h1>

    <form action="../utils/forms/createMeeting.php" method="POST">
        <ul>
            <li>
                <label>
                    Meeting Start Date
                    <input type="datetime-local" name="meetingStartTime">
                </label>
                <?php
       if (isset($_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"])) {
	 echo $_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"];
	 unset($_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"]);
       }
                ?>
            </li>

                        <li>
                <label>
                    Meeting End Date
                    <input type="datetime-local" name="meetingEndTime">
                </label>
                <?php
       if (isset($_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"])) {
	 echo $_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"];
	 unset($_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"]);
       }
                ?>
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
       <?php foreach ($advisorRows as $aRow) { ?>
					       <option value=<?php htmlspecialchars($aRow["advisorID"]) ?>><?php echo htmlspecialchars($aRow["firstName"]);
					       echo htmlspecialchars($aRow["lastName"]); ?></option>
					       <?php } ?>
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