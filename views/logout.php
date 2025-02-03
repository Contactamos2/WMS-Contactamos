<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$nombre = $_SESSION["nombre"];
$url_base = $_SESSION["url_base"];

if(!isset($id)){
	
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

?>

<div>
	<div class="caja-form-header">
		<a href="javascript:void()" onClick="seccionHide()" title="Salir"><i class="fas fa-times"></i></a>
		<h2><i class="fas fa-power-off"></i>Cerrar sesión</h2>
	</div>
	<div class="caja-form-section">
		<div class="caja-fila-textos">
			<h3>Confirmación</h3>
			<p><?php echo $nombre; ?>,</p>
			<p>¿Realmente deseas cerrar sesión?</p>
		</div>
	</div>
	<div class="caja-form-footer no-save">
		<a href="models/cerrar_sesion.php"><input type="submit" value="Sí, deseo salir" class="der"></a>
	</div>
</div>