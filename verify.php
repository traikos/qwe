<?php
//description: clicked emailed link to verify the new user
include 'connect.php';
$token=$_GET['token'];
$result=$conn->prepare("update users set verified=true where token=?");
$result->execute([$token]);
if ($result) echo "<script>alert('Your account has been verified'); window.close();</script>";
else echo "failed";
?>