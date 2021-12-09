<?php
session_start();
if (isset($_SESSION['email'])) header("Location: mypage.php");
?>
<!doctype html>
<html lang="el">
<head>
<title>Log In</title>
</head>
<body style="text-align: center" >


<form method="post" action="mypage.php">
	<input type="email" name="email" placeholder="email" /></br>
	<input type="password" name="password" placeholder="password" /></br>
	<input type="submit" name="sub" />
</form>
<a href="signup.php"><input type="button" value="Sign Up"/></a>

</body>
</html>