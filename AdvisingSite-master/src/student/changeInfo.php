<?php
session_start();
?>

<strong><font size="6">Edit your info</font></strong>

<table>
<form action="InfoEditConfirm.php" method="post" name="EditConfirm">
  <tr><td>First Name: </td><td><input type="text" name="tfNewFname" 
   value=<?php echo ($_SESSION["FIRST_NAME"]); ?> onfocus="inputFocus(this)" onblur="inputBlur(this)" /></td></tr><br>

  <tr><td>Last Name: </td><td><input type="text" name="tfNewLname" 
  value=<?php echo ($_SESSION["LAST_NAME"]); ?> onfocus="inputFocus(this)" onblur="inputBlur(this)" /></td></tr><br>

  <tr><td>Email: </td><td><input type="text" name="tfNewEmail" 
  value=<?php echo ($_SESSION["STUDENT_EMAIL"]); ?> onfocus="inputFocus(this)" onblur="inputBlur(this)" /></td></tr><br>

  <tr><td>Student ID: </td><td><input type="text" name="tfStuID" 
  value=<?php echo ($_SESSION["STUDENT_ID"]); ?> onfocus="inputFocus(this)" onblur="inputBlur(this)" disabled /></td></tr><br>

   <tr><td>Major     : </td><td><select name="ddNewMajor">
    <!-- the default option is their previous used Major, the option is also hidden -->
   <option hidden="hidden">
    <?php echo ($_SESSION["MAJOR"]); ?> 
  </option>
   <option>Biological Sciences BA</option> <!-- option for drop down box for selecting the Major -->
   <option>Biological Sciences BS</option>
   <option>Biochemistry & Molecular Biology BS</option>
   <option>Bioinformatics & Computional Biology BS</option>
   <option>Biology Education BA</option>
   <option>Chemistry BA</option>
   <option>Chemistry BS</option>
   <option>Chemistry Education BA</option>
   </td><tr>
   <br>
   </select>
   <br>

<?php

   
echo '<tr><td>';
echo '<button name="Confirm" type="submit">Confirm</button>';
echo '</td></tr>';
echo '</form>';
echo '</table>';

echo '<form action="homePage.php">';
echo '<input type="submit" value ="Home">';
echo '</form>';


/*
<!-- Click this button when Student change their mind about changing their info -->
<!-- Go back to home page, but also send the current Student ID so StudentHome.php have something to work with-->
<form action="StudentHome.php" method="post" name="Cancel">
<input type="hidden" name="tfStuID" value=<?php echo htmlspecialchars($_SESSION["StuID"]); ?>>
<tr><td>
<button name="Cancel" type="submit" >Return to Home</button>
</td></tr></table>
</form>
</center>
</body>
</html>
										       */
?>