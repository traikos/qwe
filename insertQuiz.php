<?php	
// access level: web server
// description: executes the query to insert the quiz into the database
session_start();
	if (isset($_POST["sub"])){
		include 'connect.php';
		$id=$_SESSION['email'];
		$start=$_POST['start'];
		$end=$_POST['end'];
		$discs=$_POST['discs'];
		$tries=$_POST['tries'];
		$name=$_POST['quiz_name'];
		$result=$conn->prepare("insert into quizes (quiz_name,start_date,end_date,number_of_discs,number_of_tries) values(?,?,?,?,?) ");
		$result->execute([$name,$start,$end,$discs,$tries]);
		$quiz=$conn->lastInsertId();
		$result=$conn->prepare("insert into prof_quiz (prof_id, quiz_id) values(?,?)");
		$result->execute([$id,$quiz]);
		if ($result) echo "Successful";
	}
	else header('Location: createQuiz.php');
?>
