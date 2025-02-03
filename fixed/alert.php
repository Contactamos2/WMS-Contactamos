<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$url_base = $_SESSION["url_base"];

if(!isset($id)){
	
	ader("Location:" . $url_base . "login.php");
	
	die();
	
}

?>

<div id="caja-alert" class="capa4">	
	<div class="caja-fixed left0 center alert capa4">	
		<div id="caja-mensaje" style="display: none">
			<div class="caja-form animatezoom">
				<div class="caja-form-header">
					<h2><i class="fas fa-envelope"></i>Mensaje</h2>
				</div>
				<div class="caja-form-section">
					<p id="mensaje"></p>
				</div>
				<div class="caja-form-footer">
					<button class="der" onClick="document.getElementById('caja-alert').style.display='none'">Aceptar</button>
				</div>
			</div>	
		</div>
		<div id="caja-confirmacion" style="display: none">
			<div class="caja-form animatezoom">
				<div class="caja-form-header">
					<h2><i class="fas fa-exclamation-circle"></i>Confirmación</h2>
				</div>
				<div class="caja-form-section">
					<p id="confirmacion"></p>
				</div>
				<div class="caja-form-footer">
					<button class="izq" onClick="document.getElementById('caja-alert').style.display='none'">Cancelar</button>
					<button id="btn-confirmacion" class="der">Aceptar</button>
				</div>
			</div>	
		</div>	
	</div>
</div>