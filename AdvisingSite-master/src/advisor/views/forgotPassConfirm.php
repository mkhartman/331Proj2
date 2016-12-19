<?php
include '../utils/CommonMethods.php';
session_start();

echo "Your password has been changed!";

echo '<form action="index.php">';
echo '<input type="submit" value ="Log In">';
echo '</form>';
?>
