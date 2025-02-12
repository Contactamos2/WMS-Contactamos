// JavaScript Document

function cambioNav(n){
	
	document.getElementById("nav1").style.display = "none";	
	document.getElementById("nav2").style.display = "none";		
	document.getElementById("nav" + n).style.display = "block";	
	
	var left = "220px";
	
	if(n == 1){
		
		left = "56px";
		
	}	
	
	document.getElementById("layout").style.left = left;
	document.getElementById("seccion").style.left = left;
	
}

function cambioLayout(ico){
		
	var activo = ico.dataset.activo;
	var n = ico.dataset.n;
	var layouts = document.getElementsByClassName("caja-layout");
	
	for(var i = 0; i < layouts.length; i++){
		
		if((i + 1) != n){
		
			layouts.item(i).style.display = "none";
			
		}		
	}
		
	document.getElementById("layout" + n).style.display = "block";	
	document.getElementById("layout-activo").innerHTML = activo;
	
}

//VER SECCIONES

$(document).ready(function() {
	
	$(".aUSU").on("click", function() {
		$("#seccion").load("views/usuario.php");
		$("#seccion").show(); 
		return false;		
    });	
    $(".aAYU").on("click", function() {
		$("#seccion").load("views/ayuda.php");
		$("#seccion").show(); 
		return false;			
    });	
    $(".aCER").on("click", function() {
		$("#seccion").load("views/logout.php");
		$("#seccion").show(); 
		return false;			
    });	
    $(".aFLE").on("click", function() {
		$("#seccion").load("views/procesos.php");
		$("#seccion").show(); 
		return false;		
    });	
    $(".aADI").on("click", function() {
		console.log("click");
		$("#seccion").load("views/auditoria.php");
		$("#seccion").show(); 
		console.log("click");
		return false;		
    });
    $(".aESTprocesos").on("click", function() {
		$("#seccion").load("views/procesos_estadisticas.php");
		$("#seccion").show(); 
		return false;		
    });	
    $(".aPANprocesos").on("click", function() {    	
		$("#seccion").load("views/procesos_pantalla.php");
		$("#seccion").show(); 
		return false;		
    });	
    $(".aESTprocesosBeta").on("click", function() {
		$("#seccion").load("views/procesos_estadisticas_beta.php");
		$("#seccion").show(); 
		return false;		
    });	
    $(".aINF").on("click", function() {
		$("#seccion").load("views/informes.php");
		$("#seccion").show(); 
		return false;		
    });	
    $(".aEST").on("click", function() {
		$("#seccion").load("views/estadisticas.php");
		$("#seccion").show(); 
		return false;		
    });	
    $(".aPAN").on("click", function() {
		$("#seccion").load("views/panel.php");
		$("#seccion").show(); 
		return false;		
    });	
    $(".aRANprocesos").on("click", function() {    	
		$("#seccion").load("views/procesos_ranking.php");
		$("#seccion").show(); 
		return false;		
    });
	
});

//OCULTAR SECCIÓN

function seccionHide(){
	
	document.getElementById("seccion").innerHTML = "";
	document.getElementById("seccion").style.display = "none";
		
}
	
//ELIMINAR REGISTRO GENERAL
	
function eliminar(a){
	
	var id = a.dataset.id;
	var elemento = a.dataset.elemento;
	var tabla = a.dataset.tabla;
		
	$("#caja-mensaje").hide();
	$("#mensaje").html("");
	$("#caja-alert").show();
	$("#confirmacion").html("¿Deseas eliminar el siguiente registro?<br><br>" + elemento);	
	$("#btn-confirmacion").click(function(){	  
		$.ajax({
			url: "models/eliminar_general.php",
			type: "POST",
			dataType: "HTML",
			data: {id: id, tabla: tabla}
		})
		.done(function(sms){
			$("#mensaje").html(sms);
			$("#caja-mensaje").show();
			$("#caja-confirmacion").hide();
		});	

		tablear();
		
	})
	$("#caja-confirmacion").show();
	
}	

//ACTUALIZAR CELDA EN LAYOUT

function celdaF5(modulo){
	
	$.ajax({
		url: "queries/info_modulo_modulo.php",
		type: "POST",
		dataType: "JSON",
		data: {modulo: modulo}
	})
	.done(function(info){
		
		var bdlayout = info[0].bdlayout;
		var x = info[0].x;
		var y = info[0].y;
		
		$.ajax({
			url: "models/actualizar_celda.php",
			type: "POST",
			dataType: "HTML",
			data: {modulo: modulo}
		})
		.done(function(r){
			$("#celda" + bdlayout + x + "-" + y).replaceWith(r);
		})		
	})
}

//REFRESH

setInterval(function f5(){

	//FLETEO
	try{

		$("#caja-muelles").load("views/procesos_muelles.php");

		tablear();	

	} catch(e){}

	try{

		$("#caja-pantalla-muelles").load("views/procesos_pantalla_muelles.php");		

	} catch(e){}

},60000);



