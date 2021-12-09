<?php
//access level: administrators
//description: displays a specific/chosen quiz

session_start();
//require_once ('check_admin.php');
?>
<!doctype html>
<html lang='el'>
<head>
<title>View a specific quiz</title>
</head>
<body style='text-align: center' >

<table border="1">
<caption>View Quiz</caption>
<tr>
	<th scope='col' >Student</th>
	<th scope='col' >Tries and Statistics</th>
</tr>
<?php
include 'connect.php';
$qid=$_GET['quiz'];
$result=$conn->prepare("select * from users as u, stud_quiz as s where u.email=s.stud_id and s.quiz_id=? ");
$result->execute([$qid]);
	while($row = $result->fetch()) {
		echo "<tr>";
		echo "<td>".$row['email']."</td>";
		$email=$row['email'];
		echo "<td><a target='_blank' href='stud_stats.php?email=$email&qid=$qid' ><input type='button' value='view' /></a></td>";
		echo "</tr>";

	}


$result=$conn->prepare("select count(*) as total from  user_try where quiz_id=? ");
$result->execute([$qid]);
$row = $result->fetch();
echo $row['total']." Players </br>";
PHP_EOL;

$result=$conn->prepare("select MIN(total_moves) as total from  user_try where quiz_id=?");
$result->execute([$qid]);
$row = $result->fetch();
echo PHP_EOL .$row['total']." MIN moves </br>";

$result=$conn->prepare("select MAX(total_moves) as total from  user_try where quiz_id=?");
$result->execute([$qid]);
$row = $result->fetch();
echo $row['total']." MAX moves</br>";

$result=$conn->prepare("select MIN(wrong_moves) as total from  user_try where quiz_id=?");
$result->execute([$qid]);
$row = $result->fetch();
echo $row['total']." MIN wrong moves</br>";

$result=$conn->prepare("select MAX(wrong_moves) as total from  user_try where quiz_id=?");
$result->execute([$qid]);
$row = $result->fetch();
echo $row['total']." MAX wrong moves</br>";

$result=$conn->prepare("select MIN(time) as total from  user_try where quiz_id=?");
$result->execute([$qid]);
$row = $result->fetch();
echo $row['total']." MAX time</br>";

$result=$conn->prepare("select MAX(time) as total from  user_try where quiz_id=?");
$result->execute([$qid]);
$row = $result->fetch();
echo $row['total']." MAX time</br>";

$result=$conn->prepare("select MIN(date) as total from  user_try where quiz_id=?");
$result->execute([$qid]);
$row = $result->fetch();
echo $row['total']." MIN date</br>";

$result=$conn->prepare("select MAX(date) as total from  user_try where quiz_id=?");
$result->execute([$qid]);
$row = $result->fetch();
echo $row['total']." MAX date</br>";

$result=$conn->prepare("select number_of_discs as total from quizes where id=?");
$result->execute([$qid]);
$row = $result->fetch();

$solution=pow(2,$row['total'])-1;

echo "Best possible solution: 2^n-1=2^".$row['total']."-1=$solution";



?>
</table>
<br><br>
<button type="button" onclick="tableToCSV()">
download CSV
</button>

<script src="table_to_csv.js"></script>
</body>
</html>