<?php
// access level: administrators, professors
// description: displays statistics of a student
session_start();
?>
<!doctype html>
<html lang='el'>
<head>
<title>Student Statistics</title>
</head>
<body style='text-align: center' >

<table border="1" cellspacing="0" cellpadding="10">
<tr>
	<th>Try ID</th>
    <th>Quiz ID</th>
	<th>Number of Discs</th>
    <th>Correct Moves</th>
    <th>Wrong Moves</th>
	<th>Total Moves</th>
	<th>Time</th>
	<th>Date</th>
	<th>Moves</th>
</tr>
<?php

include 'connect.php';
if (isset($_GET['email'])){
	$myid=$_GET['email'];
	$qid=$_GET['qid'];
	$result=$conn->prepare("select * from user_try as u, quizes as q where u.quiz_id=q.id and u.user_id=? and u.quiz_id=? ");
	$result->execute([$myid,$qid]);
}
else {
	$myid=$_SESSION['email'];
	$result=$conn->prepare("select * from user_try as u, quizes as q where u.quiz_id=q.id and u.user_id=? ");
	$result->execute([$myid]);
}


	while($row = $result->fetch()) {
		echo "<tr>";
		echo "<td>".$row['try_id']."</td>";
		$try=$row['try_id'];
		echo "<td>".$row['quiz_id']."</td>";
		echo "<td>".$row['number_of_discs']."</td>";
		echo "<td>".$row['correct_moves']."</td>";
		echo "<td>".$row['wrong_moves']."</td>";
		echo "<td>".$row['total_moves']."</td>";
		echo "<td>".$row['time']."</td>";
		echo "<td>".$row['date']."</td>";
		echo "<td><a target='_blank' href='show_moves.php?try_id=$try' ><input type='button' value='show moves' /></a></td>";
		echo "</tr>";
	}
?>
</table>
<br><br>
<button type="button" onclick="tableToCSV()">
download CSV
</button>

<script src="table_to_csv.js"></script> 
</body>
</html>