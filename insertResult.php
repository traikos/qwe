<?php
// access leve: web server
// description: executes the query to insert the result of a quiz into the database
session_start();
if (isset($_POST["sub"])){
	echo "this";
	include 'connect.php';
	date_default_timezone_set('Europe/Athens');
	$datetime = date_create()->format('Y-m-d H:i:s');
	$user_id=$_SESSION['email'];
	$quiz_id=$_GET['quiz_id'];
	$cor=$_POST['correct'];
	$wro=$_POST['wrong'];
	$time=$_POST['time'];
	$move=$_POST['move'];
	$total=$cor+$wro;
	$ip=$_SERVER['REMOTE_ADDR'];
	echo $user_id,$quiz_id,$cor,$wro,$time,$move,$total,$datetime;
	$result=$conn->prepare("insert into user_try (user_id,quiz_id,correct_moves,wrong_moves,total_moves,time,moves,ip_addr,date) values(?,?,?,?,?,?,?,?,?)");
	$result->execute([$user_id,$quiz_id,$cor,$wro,$total,$time,$move,$ip,$datetime]);
	$result=$conn->prepare("select * from stud_quiz where stud_id=? and quiz_id=?");
	$row1=$result->execute([$user_id,$quiz_id]);
	if ($row1==0) {
		$result=$conn->prepare("insert into stud_quiz (stud_id,quiz_id,tries) values(?,?,?)");
		$result->execute([$user_id,$quiz_id,1]);
	}
	else{
		$result=$conn->prepare("update stud_quiz set tries=tries+1 where stud_id=? and quiz_id=?");
		$result->execute([$user_id,$quiz_id]);
	}
}
?>