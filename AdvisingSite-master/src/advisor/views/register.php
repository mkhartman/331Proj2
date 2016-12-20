<?php
session_start();
include'header.php';
?>
<html>
<head>
    <title>
        Adviser Registration
    </title>
</head>

<body>
<div class="container">

<h1> Welcome to the CNMS Advising Site</h1>
 <img src="https://pbs.twimg.com/profile_images/651861816683851776/zGSMy69H.jpg" class ="create"/>

 <div class ="sign-up">
<h2>Advisor Registration Form</h2>

<!-- Use the htmlspecial chars to protect from XSS and CSSR -->
<form action="../utils/forms/registerAdvisor.php" method="post">
    <ul>
        <li>
            <label>
            <input type="text" name="fName" placeholder="First Name">
            </label>
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_FNAME"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_FNAME"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_FNAME"]);
            }
            ?>
        </li>
	<!--
        <li>
            <label>
                Middle Name: <input type="text" name="mName">
            </label>
        </li>
	-->
        <li>
            <label>
             <input type="text" name="lName" placeholder="Last Name">
            </label>
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_LNAME"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_LNAME"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_LNAME"]);
            }
            ?>
        </li>

        <li>
            <label>
               <input type="email" name="email" placeholder="E-mail">
            </label>
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_EMAIL"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_EMAIL"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_EMAIL"]);
            }
            ?>
        </li>

	<li>
	    <label>
               <input type="password" name="pass" placeholder="Password">
            </label>
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_PASS"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_PASS"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_PASS"]);
            }
            ?>   
	</li>

        <li>
            <label>
             <input type="text" name="bldgName" placeholder="Office Building Name">
            </label>
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_BLDGNAME"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_BLDGNAME"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_BLDGNAME"]);
            }
            ?>
        </li>

        <li>
            <label>
               <input type="text" name="officeRm" placeholder="Room Number">
            </label>
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_OFFICERM"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_OFFICERM"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_OFFICERM"]);
            }
            ?>
        </li>
        <input class="submit" type="submit" name="Register!">
  <a href="homepage.php">Back to Homepage</a>
    </ul>
</div>
<br><br>
</div>
</form>
</body>
</html>
