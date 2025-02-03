<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = $_SESSION["url_base"];

if(!isset($id) || ($tipo != "ADMINISTRADOR" && $tipo != "PROCESO" && $tipo != "CLIENTE" && $tipo != "TV")){
	
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" rel="noopener"></script>
<script>

function cronoPantalla(b){

	var proceso = document.getElementById("finicioPantallaB" + b).innerHTML;
	var estado = document.getElementById("festadoPantallaB" + b).innerHTML;
	var etapa = document.getElementById("einicioPantallaB" + b).innerHTML;
	var max = document.getElementById("emaxPantallaB" + b).innerHTML;
	var clase = document.getElementById("anclaPantallaB" + b).className;
	var clases = "parpadea estado" + estado;

	if(proceso != ""){

		var now = new Date().getTime();    
		var now5 = new Date(now - 300*60000).getTime();  				
		var tiempoProceso = new Date(proceso).getTime();	
		var tiempoEtapa = new Date(etapa).getTime();

		<?php
		if($tipo == "TV"){
			echo "var distanceF = now5 - tiempoProceso;"; 
			echo "var distanceE = now5 - tiempoEtapa;"; 
		} else{
			echo "var distanceF = now - tiempoProceso;";
			echo "var distanceE = now - tiempoEtapa;";
		} 
		?>
		
		//TIEMPO PROCESO
		var daysF = Math.floor(distanceF / (1000 * 60 * 60 * 24));
		var hoursF = Math.floor((distanceF % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutesF = Math.floor((distanceF % (1000 * 60 * 60)) / (1000 * 60));
		var secondsF = Math.floor((distanceF % (1000 * 60)) / 1000);

		if(hoursF < 10){ hoursF = "0" + hoursF; }
		if(minutesF < 10){ minutesF = "0" + minutesF; }
		if(secondsF < 10){ secondsF = "0" + secondsF; }
		
		document.getElementById("fcronoPantallaB" + b).innerHTML = hoursF + ":" + minutesF;

		//TIEMPO ETAPA
		var daysE = Math.floor(distanceE / (1000 * 60 * 60 * 24));
		var hoursE = Math.floor((distanceE % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutesE = Math.floor((distanceE % (1000 * 60 * 60)) / (1000 * 60));
		var secondsE = Math.floor((distanceE % (1000 * 60)) / 1000);

		if(hoursE < 10){ hoursE = "0" + hoursE; }
		if(minutesE < 10){ minutesE = "0" + minutesE; }
		if(secondsE < 10){ secondsE = "0" + secondsE; }

		var minutosE = Number(hoursE)*60 + Number(minutesE);

		document.getElementById("ecronoPantallaB" + b).innerHTML = hoursE + ":" + minutesE + " (" + minutosE + ")";

		if(max > 0 && minutosE > max && clase != clases){

			document.getElementById("anclaPantallaB" + b).className = "parpadea " + clase;

		}
	}	
}

function timerPantalla(b){

	try{

		cronoPantalla(b);

	} catch(e){}

	setInterval(function() {

		try{

			cronoPantalla(b);

		} catch(e){}

	}, 60000);
	
}

</script>

<div>		
	<div class="caja-form-header">
		<a href="javascript:void()" onClick="seccionHide()" title="Salir"><i class="fas fa-times"></i></a>
		<h2><i class="fas fa-desktop"></i>Pantalla de Procesos</h2>
	</div>	
	<div class="caja-scroll caja-bahias-pantalla-estados">	
		<div>
			<a class="estado0">disponible</a>	
			<a class="estado1">en muelle</a>	
			<a class="estado2">en proceso de des/cargue</a>	
			<a class="estado3">des/cargado</a>	
			<a class="estado4">salida de muelle</a>
		</div>
	</div>		
	<div class="caja-scroll caja-bahias-pantalla-estados">	
		<div>
			<a>P: Placa</a>
			<a>C: Canal</a>
			<a>T: Transporte Salida</a>
			<a>D: Destino</a>
		</div>
	</div>
	<div id="caja-pantalla-muelles" class="caja-form-section caja-scroll caja-bahias-pantalla">			
		<?php include_once "procesos_pantalla_muelles.php"; ?>
	</div>
</div>
