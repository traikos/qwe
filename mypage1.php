<?php
	//access level: admins, professors, students
	//session_start();
	if (!isset($_SESSION['email'])) header("Location: login.php");
	$result0 = $conn->query("select * from quizes");
	$result0->execute();
	if ($_SESSION['type']=="admin") echo '<a href="admin_rights.php" ><input type="button" value="give admin rights" /></a>';
	if($_SESSION['type']=="professor"  || $_SESSION['type']=="admin"){
		echo '<a href="view_quizes.php" ><input type="button" value="view quizes" /></a>';
		echo '<input type="button" onclick="location.href='."'createQuiz.php'".';" value="create quiz" />';
	}
	echo '<a href="mypage.php" ><input type="button" value="My Page" /></a>';
	echo '<a href="logout.php" ><input type="button" value="logout" /></a>';
?>