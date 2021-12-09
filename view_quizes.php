<?php
// access level: administrators, professors
// description: displays quizes
session_start();
?>
<!doctype html>
<html lang='el' >
<head>
<title>View Quizes</title>
</head>
<body style='text-align: center' >

<table border="1">
<caption></caption>
<tr>
	<th scope='col'>Move</th>
	<th scope='col'>Quizes By Student</th>
	<th scope='col'>Quizes Totals</th>
</tr>
<?php

include 'connect.php';
include 'mypage1.php';
$myid=$_SESSION['email'];
if ($myid=="admin@gmail.com"){
	$result=$conn->query("select * from quizes");
	$result->execute();
}
else {
$result=$conn->prepare("select * from quizes as q, prof_quiz as p where p.quiz_id=q.id and prof_id=? ");
$result->execute([$myid]);
}

	while($row = $result->fetch()) {
		echo '<tr>';
		echo '<td>'.$row['quiz_name'].'</td>';
		$id=$row['id'];
		echo "<td><a target='_blank' href='view_quiz.php?quiz=$id' ><input type='button' value='view quiz' /></td>";
		echo "<td><a target='_blank' href='view_quiz_totals.php?qid=$id' ><input type='button' value='view quiz totals' /></td>";
		echo '</tr>';
	}


?>
</table>
<br><br>
<button type="button" onclick="tableToCSV()">
download CSV
</button>
</center>
<script src="table_to_csv.js"></script
</body>
</html>