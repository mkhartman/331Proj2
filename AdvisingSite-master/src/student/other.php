<?php
include 'header.php';
?>

<html>
<head>
</head>
<body>
<div class="container">
<h1>Welcome to the CMNS advising site</h1>
 <img src="https://pbs.twimg.com/profile_images/651861816683851776/zGSMy69H.jpg" class="create"/>

<div class="sign-up">
<h1>Other Majors </h1>

<?php
    echo "You have indicated that you plan to pursue a major other than one of the following, beginning next semester: ";
echo "<br><br>";
    echo "Biological Sciences B.A. <br> Biological Sciences B.S. <br> Biochemistry & Molecular Biology B.S. <br> Bioinformatics & Computational Biology B.S. <br> Biology Education B.A. <br> Chemistry B.A. <br> Chemistry B.S. <br>Chemistry Education B.A <br><br>";

echo"In order to obtain the BEST advice about course selection, degree progress, and academic policy,please meet with a representative of the department that administers your NEW major. <br>
You can find advising contact information for your new major on the Office for Academic and Pre-Professional Advising Office’s Departmental Advising page. That contact person/office will be able to give you instructions on how to schedule an advising appointment with someone in that area. <br>

Good luck with your new major! <br> <br>

If you selected “Other” in error, click the button to return to the previous screen. <br>";
?>

<br>
<h3><a href="createAccount.php">Back to registration</a>
</div>
</div>
</body>
</html>
