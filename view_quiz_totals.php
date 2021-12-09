<?php
//access level: administrators
// description: displays ALL quizes
session_start();
?>
<!doctype html>
<html lang='el'>
<head>
<title>View All Quizes</title>
</head>
<body style='text-align: center' >

<table border="1" >
<caption>View All quizes</caption>
<tr>
	<th scope="col">Email</th>
	<th scope="col">Try ID</th>
    <th scope="col">Quiz ID</th>
	<th scope="col">Number of Discs</th>
    <th scope="col">Correct Moves</th>
    <th scope="col">Wrong Moves</th>
	<th scope="col">Total Moves</th>
	<th scope="col">Time</th>
	<th scope="col">Date</th>
	<th scope="col">Moves</th>
</tr>
<?php
include 'connect.php';
if (isset($_GET['email'])){
	$myid=$_GET['email'];
	$qid=$_GET['qid'];
	$result=$conn->prepare("select * from user_try where quiz_id=? ");
	$result->execute([$qid]);
}
else {
	$qid=$_GET['qid'];
	$myid=$_SESSION['email'];
	$result=$conn->prepare("select * from user_try as u, quizes as q where u.quiz_id=q.id and u.quiz_id=? ");
	$result->execute([$qid]);
}


	while($row = $result->fetch()) {
		echo "<tr>";
		echo "<td>".$row['user_id']."</td>";
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