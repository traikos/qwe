<?php
	//access level: admins, professors, students
	//session_start();
$tries=0;
		while($row0 = $result0->fetch()) {
			echo '<tr name="hide">';
			$quiz=$row0['id'];
			$datetime = date_create()->format('Y-m-d H:i:s');
			//if ($row['start_date'] < $datetime && $row['end_date'] > $datetime )
			$sid=$_SESSION['email'];
			$qid=$row0['id'];
			echo '<td>'.$row0['quiz_name'].'</td>';
			echo '<td>'.$row0['start_date'].'</td>';
			echo '<td>'.$row0['end_date'].'</td>';
			echo '<td>'.$row0['number_of_discs'].'</td>';
			echo '<td>'.$row0['number_of_tries'].'</td>';
			$result00 = $conn->prepare("select * from stud_quiz where stud_id=? and quiz_id=?");
			$result00->execute([$sid, $qid]);
			$row00=$result00->fetch();
			if ($row00=='') echo '<td>0</td>';
			else echo '<td>'.$row00['tries'].'</td>';
			if ($row0['start_date'] < $datetime && $row0['end_date'] > $datetime  && $row0['number_of_tries'] > $tries)
			echo '<td><a  target="_blank" href="canvas.php?quizid='.$quiz.'" ><input name="disableds" type="button" value="Take Quiz" /></a></td>';
			else echo '<td ><a  target="_blank" href="canvas.php?quizid='.$quiz.'" ><input name="disableds" type="button" disabled value="Take Quiz" /></a></td>';
			echo '</tr>';
		}
	
	
	
	
?>