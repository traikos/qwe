<?php
//access level: webserver 
// description: executes query to set user rights
session_start();
include 'connect.php';
$email=$_GET['email'];
$type=$_GET['mytype'];
$sql=$conn->prepare("update users set type=? where email=? ");
$sql->execute([$type,$email]);
?>



