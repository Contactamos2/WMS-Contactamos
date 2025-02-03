<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$nombre = $_SESSION["nombre"];
$url_base = $_SESSION["url_base"];

if(!isset($id)){
	
	hader("Location:" . $url_base . "login.php");
	
	die();
	
}

?>

<footer class="capa2">
	<div class="capa2">
		<p class="capa2">
			<i class="fas fa-map-marker-alt"></i>
			<label id="layout-activo"></label>
		</p>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" rel="noopener"></script>
	<script>
		
	//ESCUCHAR
		
	var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
	var recognition = new SpeechRecognition();

	recognition.lang = "es-MX";
	recognition.continuous = false;
	recognition.interimResults = true;

	recognition.onresult = function(event) {
		
		for (var i = event.resultIndex; i < event.results.length; i++) {
			
			if (event.results[i].isFinal){
				
				var texto = event.results[i][0].transcript;
				
				console.log(texto);
				
				verificarBusqueda(texto);
				
				recognition.onend = function() {
					
					recognition.start();
				
				}
			}
		}
	}

	recognition.start();
		
	//BÚSQUEDA	
													   
	function verificarBusqueda(texto){
		
		var mensaje = "";		
		var arreglo = texto.split(" ");
		
		var ella = false;
		var clave = false;
		var codigo = "";
		var r = "";
		
		var nombreapellido = document.getElementById("nombre").value;
		var nombre = ((nombreapellido.trim()).split(" "))[0];		
		
		for(var i = 0; i < arreglo.length; i++){
			
			var e = (arreglo[i]).toLowerCase();
			
			//PATRONES
			
			if(e == "luna"){ ella = true; }
			
			if(e.indexOf("busca") > -1 || e.indexOf("búsca") > -1){ clave = true; }
			
			if(!isNaN(e)){ codigo += "" + e; }
			
			//RESPUESTAS
			
			if(e == "hola" && r == ""){ r = "Hola " + nombre + ", ¿cómo estás?"; }
			
			if(e == "bien" && r == ""){ r = "Me alegra escuchar eso. Estoy lista para trabajar."; }
			
			if(e == "mal" && r == ""){ r = "Qué triste. No te preocupes, estoy aquí para ayudarte."; }
			
			if(e == "gracias" && r == ""){ r = "Con gusto. Estoy para servirte."; }
			
		}
		
		if(ella){
			
			if(r != ""){
				
				darRespuesta(r);
				
			}
			
			if(clave && codigo != ""){
			
				hacerBusqueda(codigo);
				
				r = "búsqueda";

			}
			
			if(arreglo.length > 1 && r == ""){
				
				r = nombre + ", lo siento, no pude entender tu solicitud. Por favor dímelo nuevamente.";
				
				darRespuesta(r);
				
			}
		}
	}
		
	function hacerBusqueda(codigo){
		
		$.ajax({
			url: "voice/buscar_sku.php",
			type: "POST",
			dataType: "HTML",
			data: {codigo: codigo}
		})
		.done(function(modulos){	
			
			if(modulos != ""){
			
				var r = "El SKU " + codigo + " se encuentra en los módulos " + modulos;
			
			} else{
				
				var r = "El SKU " + codigo + " no cuenta con existencias";
				
			}

			darRespuesta(r);

		}).fail(function(e){
			
			var r = "Se presentó un error en la consulta.";
			
			darRespuesta(r);
			
		});
	}
		
	//HABLAR
	function darRespuesta(r){
		
		speechSynthesis.speak(new SpeechSynthesisUtterance(r));
		
	}
													   
	</script>
	<input type="hidden" id="nombre" value="<?php echo $nombre; ?>">
</footer>