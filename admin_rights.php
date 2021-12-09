<?php
//access level: administrators
//description: displays users and sets rights

session_start();
//require_once ('check_admin.php');
?>
<!doctype html>
<html lang="el">
<head>
<title>Admin Rights</title>
<script>
function loadDoc(b) {
  const xhttp = new XMLHttpRequest();
  var mytype=document.getElementById(b).value;
  xhttp.open("GET", "change_rights.php?email="+b+"&mytype="+mytype, true);
  xhttp.send();
}
</script>
</head>
<body style="text-align: center" >
<p id="demo" ></p>

<table style="margin-left: auto; margin-right: auto;" border="1" >
<caption>Users and Rights</caption>
<tr>
	<th scope="col">Email</th>
	<th scope="col">Type</th>
	<th scope="col">Make Admin</th>
</tr>
<?php
include 'connect.php';
include 'mypage1.php';
//include 'mypage2.php';
$result=$conn->prepare("select * from users");
$result->execute();
	while($row = $result->fetch()) {
		if ($row['email']!="admin@gmail.com"){
		$email=$row['email'];
		echo "<tr>";
		echo "<td>".$row['email']."</td>";
		echo "<td>".$row['type']."</td>";	
		echo '<td><select id="'."$email".'" name="rights" ><option value="admin" >Admin</option><option value="professor" >Professor</option><option value="student" >Student</option></select></td>';
		echo '<td><input onclick="loadDoc('."'$email'".')" type="button" value="Confirm" /></a></td>';
		echo "</tr>";
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