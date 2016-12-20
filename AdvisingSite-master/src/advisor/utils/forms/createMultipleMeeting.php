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
        
    $startDateLoop = $startDate;
    $startS = $startDateLoop . ' ' . $startTime;

    $daysRepeated = 0;

    while($daysRepeated < $repeatDays)
      {
	$start = new DateTime($startS);
	$end = new DateTime($startS);

	date_add($start, date_interval_create_from_date_string($daysRepeated . ' days'));
	date_add($end, date_interval_create_from_date_string($daysRepeated . ' days'));

	$repeatTimeLoop = $repeatTime;
	$startTimeLoop = $startTime;
	
	$startTimeFrom = strtotime($startTimeLoop);
	$startTimeTo = strtotime($repeat);
	date_add($end, date_interval_create_from_date_string($length . ' minutes'));
	                                                  
	while($startTimeFrom < $startTimeTo)
	  {
	    $formattedStartDate = $start->format('Y-m-d H:i:s');
	    //date_add($end, date_interval_create_from_date_string($length . ' minutes'));
	    $formattedEndDate = $end->format('Y-m-d H:i:s');
	    
	    //open DB Connection, create meeting SQL Query, and insert into DB
	    $open_connection = connectToDB();
	    $insertIntoMeetings = "
                          INSERT INTO Meeting(start,end,buildingName,roomNumber,meetingType,numStudents)
                          VALUES (
                              '$formattedStartDate','$formattedEndDate','$buildingName','$roomNumber','$isGroup', 0
                          )";
	    $resultOfMeetingInsert = $open_connection->query($insertIntoMeetings);
	    
	    //Create SQL query to find latest meeting ID and parse the data to find the int
	    $findTheMeetingID = "
                          SELECT MAX(Meeting.MeetingID)
                          FROM Meeting
                      ";
	    $meetingID = $open_connection->query($findTheMeetingID);
	    $fetchMeetingArray = $meetingID->fetch_array();
	    
	    //Create SQL query to insert the meeting to advisor meeting
	    $insertIntoAdvisingMeeting = "
                          INSERT INTO AdvisorMeeting(advisorID, meetingID)
                          VALUES ('$advisorID', '$fetchMeetingArray[0]')
                      ";
	    $open_connection->query($insertIntoAdvisingMeeting);
	    
	    error_log($open_connection->error);
	    
	    // Update the time before relooping
	    $timeToRepeat = date_interval_create_from_date_string( ($repeatTime . ' minutes') );
	    date_add($start, $timeToRepeat);
	    $startTimeFrom = $startTimeFrom + ($repeatTime * 60); // number of minutes to repeat * number of seconds per minute
	    date_add($end, $timeToRepeat);
	    
	  }
	// Update the day before relooping
	date_add($start, date_interval_create_from_date_string('1 day'));
	date_add($end, date_interval_create_from_date_string('1 day'));
	$daysRepeated = $daysRepeated + 1;
      }
    


    header('Location: ../../views/homepage.php');
}
