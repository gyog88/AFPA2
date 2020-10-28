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