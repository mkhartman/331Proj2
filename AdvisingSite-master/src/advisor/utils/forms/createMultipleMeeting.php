
<?php

session_start();
date_default_timezone_set("EST");

if ($_SESSION["HAS_LOGGED_IN"] and $_POST) {
    include '../dbconfig.php';

    // Parse through variables from form
	$startDate = $_POST["meetingStartDate"]; //date
	$repeatDays = $_POST["meetingRepeatDays"]; //number
	$repeatD = $_POST["meetingRepeatD"]; //date
	$startTime = $_POST["meetingStartTime"]; //time
	$length = $_POST["meetingLength"]; //number
	$repeatTime = $_POST["meetingRepeatTime"]; //number
	$repeat = $_POST["meetingRepeat"]; //time
	$buildingName = $_POST["buildingName"]; //text
	$roomNumber = $_POST["roomNumber"]; //text
	$meetingType = $_POST["meetingType"]; //select "group" or "individual"
	$isGroup = false;
	if($meetingType == "group") {
		$isGroup = true;
	}
	$advisorID = $_POST["advisor"]; //select based on advisorID

	echo $startDate;
	echo $repeatDays;
	echo $startTime;
	echo $buildingName;
		
	
    $numOfErrors = 0;

    if ($start == "") {
        $_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"] = "Error: You should probably enter in a date.";
        $numOfErrors += 1;
    }

    if ($bName == "") {
        $numOfErrors += 1;
        $_SESSION["ERROR_ADVISOR_MEETING_BUILDING"] = "Error: You haven't enetered a building name.";
    }

    if ($rNumber == "") {
        $numOfErrors += 1;
        $_SESSION["ERROR_ADVISOR_MEETING_ROOM"] = "Error: You must enter in a room number.";
    }
	
    $numOfErrors = 0;
    if ($numOfErrors == 0) {

		while($repeatDays > 0)
		{
			
			$repeatDays = $repeatDays - 1;
		}
		$start = $startDate . '' . $startTime;
		$start = strtotime($start);

        // Storing dates into string format for MySQL
        $formattedStartDate = $startDate->format('Y-m-d H:i:s');
        $formattedEndDate = $endDate->format('Y-m-d H:i:s');

        // Open DB Connection
        $open_connection = connectToDB();

        // Create meeting SQL query and insert into DB
        $insertIntoMeetings = "
          INSERT INTO Meeting(start,end,buildingName,roomNumber, meetingType, numStudents)
          VALUES (
            '$formattedStartDate','$formattedEndDate','$bName', '$rNumber', '$isGroup', 0
          )
        ";

        $resultOfMeetingInsert = $open_connection->query($insertIntoMeetings);

        // Create SQL query to find latest meeting ID and parse the data to find the int
        $findTheMeetingID = "
          SELECT MAX(Meeting.MeetingID)
          FROM Meeting
        ";

        $meetingId = $open_connection->query($findTheMeetingID);
        $fetchMeetingArray = $meetingId->fetch_array();

        // Create sql query to insert the meeting to advisor meeting
        $insertIntoAdvisingMeeting = "
          INSERT INTO
          AdvisorMeeting(advisorID,meetingID)
          VALUES('$advisorID', '$fetchMeetingArray[0]')
        ";
        $open_connection->query($insertIntoAdvisingMeeting);

        error_log($open_connection->error);
    }
    header('Location: ../../views/homepage.php');
}