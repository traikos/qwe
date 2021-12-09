<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Draggable - Default functionality</title>


  
</head>
<body>
 

<div name="mydiv" id="div" >
</div>
<div id="div1" name="mydiv" class="ui-widget-content">
</div>
<div id="div2" name="mydiv" class="ui-widget-content">
</div>
<div id="div3" name="mydiv" class="ui-widget-content">
</div>
<div id="div4" name="mydiv" class="ui-widget-content">
</div>
<div id="div5" name="mydiv" class="ui-widget-content">
</div>
<div id="div6" name="mydiv" class="ui-widget-content">
</div>
<div id="div7" name="mydiv" class="ui-widget-content">
</div>
<div id="div8" name="mydiv" class="ui-widget-content">
</div>
<div id="div9" name="mydiv" class="ui-widget-content">
</div>
  <script src="jquery-1.js"></script>
  <script src="jquery-ui.js"></script>
  <script>
  $( function() {
    $( "div[name='mydiv']" ).draggable();
  } );
  </script>
 <script>
var mousePosition;
var offset = [0,0];
var div,div1;
var isDown = false;
div = document.getElementsByName("mydiv");
var mydoc=div[0];
for (let i = 0; i < div.length; i++) {
px=(i*50).toString();
wd=(1000-i*100).toString();
div[i].className="";
div[i].style.position = "absolute";
div[i].style.left = "calc(50% - "+wd/2+"px)";
div[i].style.top = "calc(80% - "+px+"px)";
div[i].style.width = wd+"px";
div[i].style.height = "50px";
div[i].style.background = "red";
div[i].style.color = "blue";
}
</script>
 
</body>
</html>