<?php
//access level: administrators, professors, students, guests
//description: the game itself

session_start();
//require_once ('check_admin.php');
?>
<!doctype html>
<html lang="el">
<head>
<title>Hanoi Towers Game</title>
<?php

include 'connect.php';
date_default_timezone_set('Europe/Athens');
$datetime = date_create()->format('Y-m-d H:i:s');
$flag=true;
$quiz=$_GET['quizid'];
if(!isset($_SESSION['email']))	{
	if (!isset($_POST['sub1'])){
		header("Location: enter_name.php?quiz=$quiz");
	}
	else $_SESSION['email']=$_POST['name'];
}
$stud=$_SESSION['email'];
$result=$conn->prepare("select * from quizes where id=?");
$result->execute([$quiz]);
$qid=$_GET['quizid'];

	while($row = $result->fetch()) {
		$result1=$conn->prepare("select * from stud_quiz where stud_id=? and quiz_id=?");
		$result1->execute([$stud,$qid]);
		$tries=0;
		if ($result1->fetch()!='') {
			$row1 = $result1->fetch();
			$tries=$row1['tries'];
		}
		$disc=$row['number_of_discs'];
		if (($row['start_date'] >= $datetime || $row['end_date'] <= $datetime) || ($disc <= $tries)) header("Location: unavailable.php");	
	}

$result=$conn->query("select * from stud_quiz");
$result->execute();
if ($result->fetch()=='') {
	while($row = $result->fetch_assoc()) {
		if ($row['stud_id']==$stud && $row['quiz_id']==$quiz){
			$flag=false;
			break;
		}
	}
}
if($flag){
	$result=$conn->prepare("insert into stud_quiz (stud_id, quiz_id, tries) values(?,?,?)");
	$result->execute([$stud,$quiz,0]);
}
?>
<script type="text/javascript" src="myjquery.js">  </script>
<style>
    html, body {
      width: 100%;
      height: 100%;
      margin: 0px;
      border: 0;
      overflow: hidden; 
      display: block;  
    }
    #canvas{
		border:1px solid red;
		width: 90%;
		height: 80%;
	}
</style>
<script>
	var moves=new Array();
	function myfunc(){    
		//X = e.touches[0].clientX and Y = e.touches[0].clientY
		var correct=document.getElementById('correct');
		var wrong=document.getElementById('wrong');
        var canvas = document.getElementById("canvas");
        var ctx = canvas.getContext("2d");
        var $canvas = $("#canvas");
        var canvasOffset = $canvas.offset();
        var offsetX = canvasOffset.left;
        var offsetY = canvasOffset.top;
        var scrollX = $canvas.scrollLeft();
        var scrollY = $canvas.scrollTop();
		ctx.canvas.width  = window.innerWidth*0.9;
		ctx.canvas.height = window.innerHeight*0.8;
        var cw = canvas.width;
        var ch = canvas.height;
		var w=cw/100;
		var h=ch/100;
        var isDown = false;
        var lastX;
        var lastY;
		var pos;
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		const bars =<?php echo $disc; ?>;
		var myhit=0;
		//var bars1=[[w*7,h*95,w*24,h*5],[w*9,h*90,w*20,h*5],[w*11,h*85,w*16,h*5],[w*13,h*80,w*12,h*5]];
		var bar=0;
		var bars1=new Array();
		for (i=0;i<bars;i++){		
			bars1.push([w*(7+i),h*(95-i*5),w*(24-i*2),h*5]);
		}
		var bars2=new Array();
		var bars3=new Array();
		var len1=bars1.length-1;
		var len2=bars2.length-1;
		var len3=bars3.length-1;
		var current;
		var clin0,clin1;
		
		drawAll();

        function drawAll() {
			ctx.clearRect(0, 0, cw, ch);
			ctx.beginPath();
			ctx.moveTo(w*7, 0);
			ctx.lineTo(w*7, h*100);
			ctx.moveTo(w*31, 0);
			ctx.lineTo(w*31, h*100);
			ctx.moveTo(w*38, 0);
			ctx.lineTo(w*38, h*100);
			ctx.moveTo(w*62, 0);
			ctx.lineTo(w*62, h*100);
			ctx.moveTo(w*69, 0);
			ctx.lineTo(w*69, h*100);
			ctx.moveTo(w*93, 0);
			ctx.lineTo(w*93, h*100);
			for (i=0;i<bars1.length;i++)
				ctx.rect(bars1[i][0],bars1[i][1],bars1[i][2],bars1[i][3]);
			for (i=0;i<bars2.length;i++)
				ctx.rect(bars2[i][0],bars2[i][1],bars2[i][2],bars2[i][3]);
			for (i=0;i<bars3.length;i++)
				ctx.rect(bars3[i][0],bars3[i][1],bars3[i][2],bars3[i][3]);
			ctx.stroke();
        }
		
		function addCorrect(){
			correct.innerHTML=parseInt(correct.innerHTML)+1;
		}
		function addWrong(){
			wrong.innerHTML=parseInt(wrong.innerHTML)+1;
		}
		
        function handleMouseDown(e) {

            e.preventDefault();
            e.stopPropagation();

            lastX = parseInt(e.clientX - offsetX);
            lastY = parseInt(e.clientY - offsetY);
			
			if(len1>=0){
				if (lastX>=bars1[len1][0] && lastX<=(bars1[len1][2]+bars1[len1][0]) && lastY>=bars1[len1][1] && lastY<=(bars1[len1][1]+h*5)){
					bar=1;
					pos=len1;
					myhit=1;
					isDown = true;
					clin0=bars1[bars1.length-1][0];
					clin1=bars1[bars1.length-1][1];
					
				}
			}
			if(len2>=0){
				if (lastX>=bars2[len2][0] && lastX<=(bars2[len2][2]+bars2[len2][0]) && lastY>=bars2[len2][1] && lastY<=(bars2[len2][1]+h*5)){
					bar=2;
					pos=len2;
					myhit=1;
					isDown = true;
					clin0=bars2[bars2.length-1][0];
					clin1=bars2[bars2.length-1][1];
				}
			}
			if(len3>=0){
				if (lastX>=bars3[len3][0] && lastX<=(bars3[len3][2]+bars3[len3][0]) && lastY>=bars3[len3][1] && lastY<=(bars3[len3][1]+h*5)){
					bar=3;
					pos=len3;
					myhit=1;
					isDown = true;
					clin0=bars3[bars3.length-1][0];
					clin1=bars3[bars3.length-1][1];
				}
			}
        }

        function handleMouseUp(e) {

            e.preventDefault();
            e.stopPropagation();
			if (myhit==1 && bar==1){
				if (e.clientX>=w*69 && e.clientX<=w*93 && ( bars3.length==0 || bars3[bars3.length-1][2]>bars1[bars1.length-1][2])){
					
						bars3.push(bars1[len1]);
						bars3[bars3.length-1][0]=w*81-bars3[bars3.length-1][2]/2;
						len1--;
						len3++;
						bars1.pop();
						bars3[bars3.length-1][1]= h*95-5*h*(bars3.length-1);
						addCorrect();
						moves.push(['A to C','correct']);
				}
				else if (e.clientX>=w*38 && e.clientX<=w*62 && ( bars2.length==0 || bars2[bars2.length-1][2]>bars1[bars1.length-1][2])){
					bars2.push(bars1[len1]);
					bars2[bars2.length-1][0]=w*50-bars2[bars2.length-1][2]/2;
					len1--;
					len2++;
					bars1.pop();
					bars2[bars2.length-1][1]= h*95-5*h*(bars2.length-1);
					addCorrect();
					moves.push(['A to B','correct']);
				}
				else {
					bars1[bars1.length-1][0]=clin0;
					bars1[bars1.length-1][1]=clin1;
					if( e.clientX>=w*38 && e.clientX<=w*62) {
						addWrong();
						moves.push(['A to B','incorrect']);
					}
					if (e.clientX>=w*69 && e.clientX<=w*93)	{
						addWrong();
						moves.push(['A to C','incorrect']);
					}
				}
			}
			
			if (myhit==1 && bar==2){
				if (e.clientX>=w*69 && e.clientX<=w*93 && ( bars3.length==0 || bars3[bars3.length-1][2]>bars2[bars2.length-1][2])){
					bars3.push(bars2[len2]);
					bars3[bars3.length-1][0]=w*81-bars3[bars3.length-1][2]/2;
					len2--;
					len3++;
					bars2.pop();
					bars3[bars3.length-1][1]= h*95-5*h*(bars3.length-1);
					addCorrect();
					moves.push(['B to C','correct']);
				}
				else if (e.clientX>=w*7 && e.clientX<=w*31 && ( bars1.length==0 || bars1[bars1.length-1][2]>bars2[bars2.length-1][2])){
					bars1.push(bars2[len2]);
					bars1[bars1.length-1][0]=w*19-bars1[bars1.length-1][2]/2;
					len2--;
					len1++;
					bars2.pop();
					bars1[bars1.length-1][1]= h*95-5*h*(bars1.length-1);
					addCorrect();
					moves.push(['B to A','correct']);
				}
				else {
					bars2[bars2.length-1][0]=clin0;
					bars2[bars2.length-1][1]=clin1;
					if( e.clientX>=w*7 && e.clientX<=w*31) {
						addWrong();
						moves.push(['B to A','incorrect']);
					}
					if (e.clientX>=w*69 && e.clientX<=w*93)	{
						addWrong();
						moves.push(['B to C','incorrect']);
					}
				}
				
			}
			
			if (myhit==1 && bar==3){
				if (e.clientX>=w*7 && e.clientX<=w*31 && ( bars1.length==0 || bars1[bars1.length-1][2]>bars3[bars3.length-1][2])){
					bars1.push(bars3[len3]);
					bars1[bars1.length-1][0]=w*19-bars1[bars1.length-1][2]/2;
					len3--;
					len1++;
					bars3.pop();
					bars1[bars1.length-1][1]= h*95-5*h*(bars1.length-1);
					addCorrect();
					moves.push(['C to A','correct']);
				}
				else if (e.clientX>=w*38 && e.clientX<=w*62 && ( bars2.length==0 || bars2[bars2.length-1][2]>bars3[bars3.length-1][2])){
					bars2.push(bars3[len3]);
					bars2[bars2.length-1][0]=w*50-bars2[bars2.length-1][2]/2;
					len3--;
					len2++;
					bars3.pop();
					bars2[bars2.length-1][1]= h*95-5*h*(bars2.length-1);
					addCorrect();
					moves.push(['C to B','correct']);
				}
				else {
					bars3[bars3.length-1][0]=clin0;
					bars3[bars3.length-1][1]=clin1;
					if( e.clientX>=w*38 && e.clientX<=w*62) {
						addWrong();
						moves.push(['C to B','incorrect']);
					}
					if (e.clientX>=w*7 && e.clientX<=w*31)	{
						addWrong();
						moves.push(['C to A','incorrect']);
					}
				}
				
			}

			/*for(i=0;i<bars;i++){
				if(i<bars1.length)
				console.log("bar 1 "+bars1[i][0]+ "-----"+bars1[i][2]);
				if(i<bars2.length)
				console.log("bar 2 "+bars2[i][0]+ "-----"+bars2[i][2]);
				if(i<bars3.length)
				console.log("bar 3 "+bars3[i][0]+ "-----"+bars3[i][2]);
				
				
			}
			console.log("X="+e.clientX);
			console.log("Y="+e.clientY);*/
			myhit=0;
            isDown = false;
			//console.log(moves);
			drawAll();
        }

        function handleMouseMove(e) {

            if (!isDown) { return; }

			e.preventDefault();
            e.stopPropagation();

			if(myhit==1){
				if (bar==1){
					bars1[pos][0]=bars1[pos][0]+(e.clientX-lastX);
					bars1[pos][1]=bars1[pos][1]+(e.clientY-lastY);
					lastX = parseInt(e.clientX - offsetX);
					lastY = parseInt(e.clientY - offsetY);
				}
				if (bar==2){
					bars2[pos][0]=bars2[pos][0]+(e.clientX-lastX);
					bars2[pos][1]=bars2[pos][1]+(e.clientY-lastY);
					lastX = parseInt(e.clientX - offsetX);
					lastY = parseInt(e.clientY - offsetY);
				}
				if (bar==3){
					bars3[pos][0]=bars3[pos][0]+(e.clientX-lastX);
					bars3[pos][1]=bars3[pos][1]+(e.clientY-lastY);
					lastX = parseInt(e.clientX - offsetX);
					lastY = parseInt(e.clientY - offsetY);
				}
				drawAll();
			}      
        }
/*window.addEventListener('resize', function(event){
ctx.clearRect(0, 0, cw, ch);
	ctx.canvas.width  = window.innerWidth*0.9;
	ctx.canvas.height = window.innerHeight*0.9;
    cw = canvas.width;
    ch = canvas.height;
	w=cw/100;
	h=ch/100;
    isDown = false;
	bars=12;
	myhit=0;
	bar=0;
	bars1=new Array();
	for (i=0;i<bars;i++){		
		bars1.push([w*(7+i),h*(95-i*5),w*(24-i*2),h*5]);
	}
	len1=bars1.length-1;
	len2=bars2.length-1;
	len3=bars3.length-1;
	drawAll();
});*/
        $("#canvas").mousedown(function(e) { handleMouseDown(e); });
        $("#canvas").mousemove(function(e) { handleMouseMove(e); });
        $("#canvas").mouseup(function(e) { handleMouseUp(e); });
        $("#canvas").mouseout(function(e) { handleMouseUp(e); });
    }
</script>
</head>

<body>

    <canvas id="canvas" ></canvas></br>
	<form action="insertResult.php?quiz_id=<?php echo $_GET['quizid']; ?>" method="post" >
	<input type="text" hidden id="text1" name="correct" />
	<input type="text" hidden id="text2" name="wrong" /> 
	<input type="text" hidden id="text3" name="time" /> 
	<input type="text" hidden id="text4" name="move" /> 
	<input type="button" onclick="myfunc();mymy();this.hidden=true" value="start" id="start" />
	<input type="button" onclick="endfunc()" value="end try" id="end" /></br>
	<p>Correct moves: <label id="correct"  value="0" >0</label></br>
	<p>Wrong moves: <label id="wrong" >0</label></br>
	<p id="timer" name="timer"  ></p>
	<input type="submit" hidden id="sub" name="sub"/>
	</form>
<script>
var timer=document.getElementById('timer');
var start;
var  interval;
function mymy(){
	start = Date.now();
	interval = setInterval(mytimer,100);
}
function mytimer(){
	const milliseconds = Date.now() - start;
	timer.innerHTML=milliseconds/1000;
}
function endfunc(){
	var cor=document.getElementById('correct');
	var wro=document.getElementById('wrong');
	var time=document.getElementById('timer');
	var move=document.getElementById('text4');
	clearInterval(interval);
	document.getElementById('sub').hidden=false;
	document.getElementById('text1').value=cor.innerHTML;
	document.getElementById('text2').value=wro.innerHTML;
	document.getElementById('text3').value=time.innerHTML;
	var myJsonString = JSON.stringify(moves);
	move.value=myJsonString;

}
</script>
</body>
</html>
