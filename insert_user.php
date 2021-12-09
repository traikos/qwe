<?php
//access level: webserver
//description: executes sql query to inser a new user

session_start();
//require_once ('check_admin.php');
	
	if (isset($_POST["sub"]) && $_POST['pass1']==$_POST['pass2'] && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		include 'connect.php';
		$token = bin2hex(random_bytes(50));
		$email=filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
		$pass=$_POST['pass1'];
		$result = $conn->prepare("insert into users (email,password,token,verified,type) values(?,?,?,?,?)");
		$result->execute([$email,$pass,$token,false,'student']);
		$msg = "http://localhost/hanoi/verify.php?token=$token";
		$sub="this is it";
		$headers="From: smtphanoi@gmail.com";
		mail($email,$sub,$msg,$headers);
	}
	else header('Location: signup.php');
?>
