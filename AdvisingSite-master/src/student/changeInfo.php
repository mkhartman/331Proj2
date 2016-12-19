<?php
// this is the page where student go if they want to change their information
session_start();
include 'header.php';
?>
<div class="container">

<strong><font size="6">Edit your info</font></strong>
<table>
<form action="changeInfoConfirm.php" method="post" name="EditConfirm">
  <!-- echo htmlspecialchars($_SESSION["Fname"]) set the php variable to html value -->

  <tr><td>First Name: </td><td><input type="text" name="tfNewFname" 
   value=<?php echo ($_SESSION["FIRST_NAME"]); ?> onfocus="inputFocus(this)" onblur="inputBlur(this)" /></td></tr><br>

  <tr><td>Last Name: </td><td><input type="text" name="tfNewLname" 
  value=<?php echo ($_SESSION["LAST_NAME"]); ?> onfocus="inputFocus(this)" onblur="inputBlur(this)" /></td></tr><br>

  <tr><td>Preferred Name: </td><td><input type="text" name="tfNewPname" 
  value=<?php echo ($_SESSION["NICK_NAME"]); ?> onfocus="inputFocus(this)" onblur="inputBlur(this)" /></td></tr><br>

  <tr><td>Email: </td><td><input type="text" name="tfNewEmail" 
  value=<?php echo ($_SESSION["STUDENT_EMAIL"]); ?> onfocus="inputFocus(this)" onblur="inputBlur(this)" disabled /></td></tr><br>
 
  <tr><td>Student ID: </td><td><input type="text" name="tfStuID" 
  value=<?php echo ($_SESSION["SCHOOL_ID"]); ?> onfocus="inputFocus(this)" onblur="inputBlur(this)" disabled /></td></tr><br>
    
  <tr><td>Career Interest: </td><td><input type="text" name="tfCareer" 
  value=<?php echo ($_SESSION["CAREER"]); ?> onfocus="inputFocus(this)" onblur="inputBlur(this)" /></td></tr><br>
  
  <tr><td>Major     : </td><td><select name="ddNewMajor">
    <!-- the default option is their previous used Major, the option is also hidden -->
   <option hidden="hidden">
    <?php echo ($_SESSION["MAJOR"]); ?> 
  </option>
  <option value="Biological Sciences BA">Biological Sciences BA</option>
    <option value="Biological Sciences BS">Biological Sciences BS</option>
    <option value="Biochemistry & Molecular Biology BS">Biochemistry & Molecular Biology BS</option>
    <option value="Bioinformatics & Computational Biology BS">Bioinformatics & Computational Biology BS</option>
    <option value="Biology Education BA">Biology Education BA</option>
    <option value="Chemistry BA">Chemistry BA</option>
    <option value="Chemistry BS">Chemistry BS</option>
    <option value="Chemistry Education BA">Chemistry Education BA</option>
    </td><tr>
   <br>
   </select>
   <br>
    
    <tr><td>Comment for Meeting: </td><td>
    <textarea name="comment" rows="5" cols="40">
    <?php echo($_SESSION["COMMENT"]); ?>
    </textarea>
    
<?php

   
echo '<tr><td>';
echo '<button name="Confirm" type="submit">Confirm</button>';
echo '</td></tr>';
echo '</form>';
echo '</table>';

// click the button if the student want to go home 
echo '<form action="homePage.php">';
echo '<input type="submit" value ="Home">';
echo '</form>';
										       
?>
</div>
</body>
</html>