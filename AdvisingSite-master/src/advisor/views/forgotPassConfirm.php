<?php
include '../utils/dbconfig.php';
include 'header.php';
session_start();
?>
<html>
<body>

<div class="container">
  <form action="forgotPassConfirm.php" method="post">
  
  <label>
  New Password: <input type="password" name="pass">
  </label>
  <label>
  <input type="submit">
  </label>
  
  </form>

</div>

<?php
  if($_POST){
    // process the new password
    $pass = md5($_POST['pass']);
    $advisorID = $_SESSION['advisorID'];
    $filename = "forgotPassConfirm.php";

    $openConnection = connectToDB();
   
    $sql = "UPDATE `Advisor` SET `password` = '$pass' WHERE `advisorID` = '$advisorID'";
    $rs = $openConnection->query($sql);

    header("Location: index.php");
  }
?>

</body>
</html>

