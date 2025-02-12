<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = "http://localhost/comercialnutresa/";

if (!isset($id)) {

	header("Location:" . $url_base . "login.php");

	die();
}

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">

<head>
	<title>WMS Contactamos V2.0</title>
	<meta charset="UTF-8">
	<meta name="description" content="Warehouse Management System">
	<meta name="keywords" content="wms, almacen, inventario, sku">
	<meta name="author" content="Carlos Vega">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Last-Modified" content="0">
	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
	<meta http-equiv="Pragma" content="no-cache">
	<link rel="stylesheet" href="public/css/estilos.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto|Oswald&display=swap" rel="stylesheet">
	<link rel="icon" type="image/png" href="public/img/icologo.png">
	<script src="controllers/icons.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

	
</head>

<body id="body">

	<!-- LOADING -->
	<?php if ($tipo != "" && $tipo != "CLIENTE" && $tipo != "TV") { ?>
		<div id="caja-load" class="caja-fixed left0 center load capa5" style="display: none">
			<p>Espere un momento...</p>
		</div>
	<?php } ?>

	<!-- FIJOS -->
	<?php require_once "config/config.php"; ?>
	<?php if ($tipo != "" && $tipo != "CLIENTE" && $tipo != "TV") {
		require_once "fixed/header.php";
	} ?>
	<?php require_once "fixed/nav.php"; ?>
	<?php if ($tipo != "" && $tipo != "CLIENTE" && $tipo != "TV") {
		require_once "fixed/footer.php";
	} ?>
	<?php if ($tipo != "" && $tipo != "CLIENTE" && $tipo != "TV") {
		require_once "fixed/alert.php";
	} ?>

	<!-- SECCIÓN -->
	<div id="seccion" class="caja-fixed left56 caja-form caja-scroll capa2" style="display: none">

	</div>

	<!-- CELDA -->
	<div id="celda">

	</div>

	<!-- MÓDULO -->
	<div id="modulo">

	</div>

	<!-- LAYOUTS -->
	<div id="layout" class="caja-fixed left56 layout capa0">

	</div>

	<!-- LIBRERIAS -->
	<?php require_once "fixed/librerias.php"; ?>

</body>

</html>