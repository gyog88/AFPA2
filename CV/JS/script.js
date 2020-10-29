function ajaxRequest(url,type,params) {
	if(type===undefined) var type='GET';
	if(type=='GET') params=null;
	var http=new XMLHttpRequest();
	http.open(type,url,false);
	http.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	http.onreadystatechange=function(){if(http.readyState==4 && http.status==200) ajaxResponse=http.responseText;};
	http.send(params);
	return ajaxResponse;
}

function affichenumero() {
    var numero=ajaxRequest('./src/docs/numero.txt');
    document.getElementById('tel').innerHTML=numero;
}













//-----------------BALLOONS---------------------------//

function random(num) {
	return Math.floor(Math.random()*num)
  }
  
  function getRandomStyles() {

	//var colors=['#94E8b4','#72bda3','#5E8c61','#4e6151','#3b322c']
	//var mycolor=colors[Math.floor(Math.random()*colors.length)];

	var r=[148,114,94,78,59];
	var g=[232,189,140,97,50];
	var b=[180,163,97,81,44];
	var mt = random(200);
	var ml = random(50);
	var dur = random(10)+10;
	var numColor=Math.floor(Math.random() * Math.floor(4));
	return `
	background-color: rgba(${r[numColor]},${g[numColor]},${b[numColor]},0.7);
	color: rgba(${r[numColor]},${g[numColor]},${b[numColor]},1); 
	box-shadow: inset -7px -3px 10px rgba(${r[numColor]-10},${g[numColor]-10},${b[numColor]-10},0.7);
	margin: ${mt}px 0 0 ${ml}px;
	animation: float ${dur}s ease-in infinite
	`
  }
  
  function createBalloons(num) {
	var skills=['PHP',' ','Javascript',' ','HTML', ' ', 'Bootstrap', ' ', 'CSS', ' ', 'Java Android', '', 'Symphony', 'VS Code',' ','UML','Java FX','Merise','Suite Jetbrain' ];
	var balloonContainer = document.getElementById("balloon-container");
	
	for (var i = num; i > 0; i--) {
	var myText=skills[Math.floor(Math.random()*(skills.length))];
	var balloon = document.createElement("div");
	balloon.className="balloon";
	balloon.id=i;
	balloon.style.cssText = getRandomStyles();
	balloon.innerHTML=myText;
	balloonContainer.append(balloon);
	}
  }
  
  window.onload = function() {
	createBalloons(100);
  }








//faire disparaitre une div apres 20 secs
  setTimeout(function() {
    $('#balloon-container').fadeOut('fast');
}, 20000); // <-- time in milliseconds














/*POPPERS*/

  const button = document.querySelector('#button');
  const tooltip = document.querySelector('#tooltip');

  // Pass the button, the tooltip, and some options, and Popper will do the
  // magic positioning for you:
  Popper.createPopper(button, tooltip, {
    placement: 'right',
  });

/*-------------------*/