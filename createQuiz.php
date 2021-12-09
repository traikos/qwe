<?php
//access level: administrators and professors
//description: displays form to create quiz

session_start();
//require_once ('check_admin.php');
?>
<html lang="el">
<head>
<title>Create Quiz</title>
</head>
<body style="text-align: center" >

<?php
include 'connect.php';
include 'mypage1.php';
?>
<form action="insertQuiz.php" method="post" >
<input type="text" required name="quiz_name" /><label>Όνομα Quiz</label></br>
<input type="datetime-local" required name="start" /><label>Έναρξη Quiz</label></br>
<input type="datetime-local" required name="end" /><label>Λήξη Quiz</label></br>
<input type="number" min="1" max="12" required name="discs" /><label>Αριθμός δίσκων</label></br>
<input type="number" min="1" required name="tries" /><label>Αριθμός προσπαθειών</label></br>
<input type="submit" name="sub" />
</form>

</body>
</html>