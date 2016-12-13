<?php

include('header.php');
include('../CommonMethods.php');
 $debug = true;
 $COMMON = new Common($debug);
 $fileName = "index.php";

 $email_error_message = $fName_error_message = $lName_error_message = "";
echo " ";
 $schoolID_error_message = $major_error_message = "";
 $email = $fName = $lName = $schoolID = $major = "";

if($_POST){
 
  //defining variables used for query
  $email = $_POST["email"];
  $fName = $_POST["fName"];
  $mName = $_POST["mName"];
  $lName = $_POST["lName"];
  $schoolID = $_POST["schoolID"];
  $major = $_POST["major"]; 
  
  //regex for email validation 
  $email_validation = '^[a-zA-Z]?@umbc.edu$^';
  
  //boolean to determine if email is invalid
  $invalid_email = false;
  
  //boolean to determine if miscellanious error has occured
  $misc_error = false;
  
  //boolean to determine if student record exists in db
  $student_exists = false;
  
  //query for student validation
  $student_val_query = "SELECT * FROM Student WHERE email = '$email'";
  
  //query execution
  $validation_query = $COMMON->executequery($student_val_query, $fileName);

  //determines if atleast one record exists with entered email
  if(mysql_num_rows($validation_query) > 0){
    $student_exists = true;
    $email_error_message = "Record exists for ". $email;
  }
  
  if(!preg_match($email_validation, $email)){
    $invalid_email = true;
    $misc_error = true;
    $email_error_message = "Please enter a valid e-mail address";
  }
  if(!preg_match("^[a-zA-Z]+[-']?[a-zA-Z]+&^",$_POST["fName"])) {
    $misc_error = true;
    $fName_error_message = "*Please enter a valid first name";
  }
  if(!preg_match("^[a-zA-Z]+[-']?[a-zA-Z]+&^",$_POST["lName"])) {
    $misc_error = true;
    $lName_error_message = "Please enter a valid last name";
  }
  if(!preg_match("^[a-zA-Z]{2}[0-9]{5}^", $_POST["schoolID"])){
    $misc_error = true;
    $schoolID_error_message = "Please enter a valid student ID";
  }
  
  //checking if empty
  if(empty($_POST["email"])){
    $misc_error = true;
    $email_error_message = "Please enter an e-mail address";
  }
  if(empty($_POST["fName"])){
    $misc_error = true;
    $fName_error_message = "Please enter your first name";
  }
  if(empty($_POST["lName"])){
    $misc_error = true;
    $lName_error_message = "Please enter your last name";
  }
  if(empty($_POST["schoolID"])){
    $misc_error = true;
    $schoolID_error_message = "Please enter your school ID";
  }
  if(empty($_POST["major"])){
    $misc_error = true;
    $major_error_message = "Please enter your major";
  }

  //query activity after determining if no errors have occured
  if($invalid_email == false && $misc_error == false && $student_exists == false){
        
    $sql = "INSERT INTO Student (email,firstName,middleName,lastName,schoolID,major) VALUES ('$email','$fName','$mName','$lName', '$schoolID','$major')";
    
    //executes query and redirects to login
    if($rs = $COMMON->executeQuery($sql,$fileName)){
      header('Location: login.php');
    }
  }
}
?>

<!DOCTYPE HTML>
<html>
 <head>

<title>Student Registration</title>

</head>
<body>

<style>
.error{color: #FF0000;}
</style>

<div class="container">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"/>
	  
 <h1>Welcome to the CMNS advising site.</h1>
 <img src="https://pbs.twimg.com/profile_images/651861816683851776/zGSMy69H.jpg" class ="create"/>

<div class="sign-up">

    <h2>Sign up.</h2>
  <span class="error"> <?php echo $email_error_message;?></span>
  <label></label><input placeholder="E-mail [Must be an UMBC e-mail]" type="text" name="email" value="<?php if(isset($_POST['email'])) {echo $_POST['email']; }?>" />

 <span class="error"> <?php echo "<br>"; echo $fName_error_message;?></span>
 <label></label><input placeholder="First Name" type="text" name="fName" value="<?php if(isset($_POST['fName'])) {echo $_POST['fName']; }?>" />

 <label></label><input placeholder="Middle Name" type="text" name="mName" value="<?php if(isset($_POST['mName'])) {echo $_POST['mName']; }?>" />

 <span class="error"> <?php echo "<br>"; echo $lName_error_message;?></span>
 <label></label><input placeholder="Last Name" type="text" name="lName" value="<?php if(isset($_POST['lName'])) {echo $_POST['lName']; }?>" />
  
 <span class="error"> <?php echo "<br>";echo $schoolID_error_message;?></span>
 <label></label><input placeholder="Student ID" type="varchar" name="schoolID" value="<?php if(isset($_POST['schoolID'])) {echo $_POST['schoolID']; }?>" />
 


 <label></label>
	  <select name="major">
	  <option value="">Select a major</option>
          <option value="BioSciBA">Biological Sciences BA</option>
	  <option value="BioSciBS">Biological Sciences BS</option>
	  <option value="BioChem">Biochemistry & Molecular Biology BS</option>
	  <option value="BioInfo">Bioinformatics & Computational Biology BS</option>
	  <option value="BioEd">Biology Education BA</option>
	  <option value="ChemBA">Chemistry BA</option>
	  <option value="ChemBS">Chemistry BS</option>
	  <option value="ChemEd">Chemistry Education BA</option>
</select>
  <span class="error"> <?php $major_error_message;?></span>
<input class="submit" type="submit" value="Log In">
<br>
</form>
</body>

<h3><a href="login.php"><font size="3"> Have you already registered? Log in here. </font></a></h3>

</div> <!--end of container-->


</div> <!--end of sign-up-->

</html>