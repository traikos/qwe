<?php
// access level: administrators, professors, students
// description: shows moves of a quiz try
session_start();
?>
<!doctype html>
<html lang='el'>
<head>
<title>Show Moves</title>
</head>
<body style='text-align: center' >
<table border="1">
<caption>Moves</caption>
<tr>
	<th scope='col' >Move</th>
    <th scope='col' >Cor/Incor</th>
</tr>
<?php

include 'connect.php';

$id=$_GET['try_id'];
$result->prepare("select moves from user_try where try_id=? ");
$result->execute([$id]);
	while($row = $result->fetch()) {
		$moves=json_decode($row["moves"],true);
		for ($i=0;$i<sizeof($moves);$i++){
			echo '<tr>';		
			//print_r($moves[0]);
			echo '<td>'.$moves[$i][0].'</td>';
			echo '<td>'.$moves[$i][1].'</td>';
			echo '</tr>';
		}
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