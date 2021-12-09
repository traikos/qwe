<?php
//access level: all registered users
//description: displays available and not available quizes

session_start();
//require_once ('check_admin.php');
?>
<html lang="el">
<head>
<title>Home Page</title>
<script>
function mynewfunc(){
var dis=document.getElementsByName("disableds");
var des=document.getElementsByName("hide");
var show=document.getElementById("show");

if (show.value=="show available only") {
	show.value="show not available";
for (var i=0;i<dis.length;i++){
	if (dis[i].disabled==true){
		des[i].hidden=true;
	}
}
}
else{
	show.value="show available only";
	for (var i=0;i<dis.length;i++){
	if (dis[i].disabled==true){
		des[i].hidden=false;
	}
}
}
}
</script>
</head>
<body style='text-align: center'>

<?php
include 'connect.php';
	date_default_timezone_set('Europe/Athens');
	
	if (isset($_POST["sub"]) ){
		$email=$_POST['email'];
		$pass=$_POST['password'];
		$sql=$conn->query("select * from users");	
		while($row = $sql->fetch()) {
			if($email==$row["email"] && $pass==$row["password"]) {				
				$_SESSION['id']=$row["email"];
				$_SESSION['email']=$email;
				$_SESSION['pass']=$pass;
				$_SESSION['token']=$row["token"];
				$_SESSION['type']=$row["type"];
				if($row['verified']==0) header ("Location: logout.php");
				else header ("Location: mypage.php");
				break;
			}
		}		
	}
include 'mypage1.php';
?>
<a href="stud_stats.php" ><input type="button" value="My statistics" /></a>

 
<table>
<caption>Quizes</caption>
<tr>
    <th scope="col" >Quiz Name</th>
    <th scope="col" >Start Date</th>
    <th scope="col" >End Date</th>
	<th scope="col" >Number of Discs</th>
	<th scope="col" >Max Tries</th>
	<th scope="col" >Your Tries</th>
	<th scope="col" >Available</th>
</tr>
<?php
include 'mypage2.php';
?>
</table>
<br><br>
<button type="button" onclick="tableToCSV()">
download CSV
</button>
<input type="button" id="show" onclick="mynewfunc()" value="show available only" />


<script src="table_to_csv.js"></script> 

</body>
</html>