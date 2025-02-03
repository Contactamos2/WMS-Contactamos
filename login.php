<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
var_dump($_SESSION);

$url_base = $_SESSION["url_base"];

if(isset($id)){
	
	header("Location:" . $url_base . "index.php");
	//header("Location:http://vefers.000webhostapp.com/wms/index.php");
	//header("Location:http://localhost/wms/index");
	
	die();
	
}

if(isset($_POST["submitLOG"])){
	
	$usuarioLOG = $_POST["usuario"];
	
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
	<head>
		<title>WMS Contactamos V2.0</title>
		<meta charset="UTF-8">
		<meta name="description" content="Warehouse Managment System">
		<meta name="keywords" content="wms, almacen, inventario, sku">
		<meta name="author" content="Carlos Vega">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="public/css/estilos.css">  	
		<link href="https://fonts.googleapis.com/css?family=Roboto|Oswald&display=swap" rel="stylesheet">
		<link rel="shortcut icon" href="public/img/icologo.ico">
		<script src='https://kit.fontawesome.com/eb26fd3e3b.js'></script>
	</head>
	<body>
	    <div class="login caja-scroll">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<!-- <form action="controllers/inicio_sesion.php" method="post"> -->
				<div> 
					<img src="public/img/logow.png" alt="Logo" title="Contactamos">
					<p class="titulo">Warehouse Management System</p>
				</div>
				<div>
					<input type="text" name="usuario" value="<?php if(isset($usuarioLOG)){ echo $usuarioLOG; } ?>" placeholder="Usuario o correo electrónico" required>
					<input type="text" name="contrasena" placeholder="Contraseña" required>
					<input type="submit" value="INICIAR SESIÓN" name="submitLOG">
				</div>
				<div><?php include "models/iniciar_sesion.php"; ?></div>
				<div>
					<p>&copy; 2018 - <?php echo date("Y"); ?> Todos los derechos reservados.</p>
				</div>
			</form>
		</div>
	</body>
</html>
