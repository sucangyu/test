var canvasWidth = 800;
var canvasHeight = canvasWidth;

var strokeColor = 'black';
var isMouseDown = false;
var lastLoc = {x:0,y:0};
var lastTimestamp = 0;
var lastLineWidth = -1;

var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');

canvas.width = canvasWidth;
canvas.height = canvasHeight

drawGrid();

$("#clear_btn").click(
	function(e){
		context.clearRect(0,0,canvasWidth,canvasHeight);
		drawGrid();
	}
);

$(".btns").click(
	function(e){
		strokeColor = $(this).css("background-color");
		console.log(strokeColor);
	}

);

canvas.onmousedown = function(e){
	e.preventDefault();
	isMouseDown = true;
	//console.log('mouse down!');
	lastLoc = windowToCanvas(e.clientX,e.clientY);
	lastTimestamp = new Date().getTime();
	
}
canvas.onmouseup = function(e){
	e.preventDefault();
	isMouseDown = false;
	//console.log('mouse up');
}
canvas.onmouseout = function(e){
	e.preventDefault();
	isMouseDown = false;
	//console.log('mouse out');
}
canvas.onmousemove = function(e){
	e.preventDefault();
	if (isMouseDown) {
		//console.log('mouse move');
		var curLoc = windowToCanvas(e.clientX,e.clientY);
		var curTimestamp = new Date().getTime();
		var s = calcDistance(curLoc,lastLoc);
		var t = curTimestamp - lastTimestamp;

		var lineWidth = calcLineWidth(t,s);


		context.beginPath();
		context.moveTo(lastLoc.x,lastLoc.y);
		context.lineTo(curLoc.x,curLoc.y);


		context.strokeStyle = strokeColor;
		context.lineWidth = lineWidth;
		context.lineCap = "round";
		context.lineJoin = "round";
		context.stroke();

		lastLoc = curLoc;
		lastTimestamp = curTimestamp;
		lastLineWidth = lineWidth;
	}
	
}

var amxLineWidth = 30;
var ainLineWidth = 1;
var maxStrokeV = 10;
var minStrokeV = 0.1;

function calcLineWidth(t,s){
	var v = s/t;
	var resultLineWidth;
	if (v<=minStrokeV) {
		resultLineWidth = amxLineWidth;
	}else if (v>=maxStrokeV) {
		resultLineWidth = ainLineWidth;
	}else{
		resultLineWidth = amxLineWidth-(v-minStrokeV)/(maxStrokeV-minStrokeV)*(amxLineWidth-ainLineWidth);
	}
	return lastLineWidth*3/5 + resultLineWidth*2/5;
}

function calcDistance(loc1,loc2){
	return Math.sqrt((loc1.x - loc2.x)*(loc1.x-loc2.x)+(loc1.y-loc2.y)*(loc1.y-loc2.y));
}

function windowToCanvas(x,y){
	var bbox = canvas.getBoundingClientRect();
	return {x:Math.round(x-bbox.left),y:Math.round(y-bbox.top)}
}


function drawGrid(){

	context.save();
	context.strokeStyle = 'DarkRed';

	context.beginPath();
	context.moveTo(3,3);
	context.lineTo(canvasWidth - 3 , 3);
	context.lineTo(canvasWidth - 3 , canvasHeight - 3 );
	context.lineTo(3 ,canvasHeight - 3);
	context.closePath();

	context.lineWidth = 6;
	context.stroke();

	context.beginPath();
	context.moveTo(0,0);
	context.lineTo(canvasWidth , canvasHeight);

	context.moveTo(canvasWidth,0);
	context.lineTo(0 , canvasHeight);

	context.moveTo(canvasWidth/2,0);
	context.lineTo(canvasWidth/2 , canvasHeight);

	context.moveTo(0,canvasHeight/2);
	context.lineTo(canvasWidth , canvasHeight/2);

	context.lineWidth = 1;
	context.stroke();

	context.restore();

}
