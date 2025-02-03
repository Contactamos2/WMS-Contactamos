<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = $_SESSION["url_base"];

if(!isset($id) || $tipo != "ADMINISTRADOR"){
	
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

include "../conexion.php";

$usuario = $_SESSION["miusuario"];
$idREG = $_POST["id"];
$usuario = trim($_POST["usuario"]);
$correo = trim($_POST["correo"]);
$contrasena = $_POST["contrasena"];
$tipo = $_POST["tipo"];
$nombre = trim($_POST["nombreapellido"]);
$cargo = trim($_POST["cargo"]);
$sms = "";

if($usuario != "" && $correo != "" && $tipo != "" && $nombre != "" && $cargo != ""){
	
	if($contrasena != ""){
		
		//HASHEAR CONTRASEÑA

		$timeTarget = 0.05;
		$coste = 8;

		do {
			$coste++;
			$inicio = microtime(true);
			password_hash("test", PASSWORD_BCRYPT, ["cost" => $coste]);
			$fin = microtime(true);
		} while (($fin - $inicio) < $timeTarget);

		$opciones = [
			'cost' => $coste,
		];

		$hash = password_hash($contrasena, PASSWORD_BCRYPT, $opciones);

		if($idREG == ""){

			$sql = "INSERT INTO usuarios(usuario, correo, contrasena, tipo, nombre, cargo)
					VALUES ('$usuario', '$correo', '$hash', '$tipo', '$nombre', '$cargo')";

			$sms = "Usuario creado exitosamente.";

		} else{

			$sql = "UPDATE usuarios
					SET usuario='$usuario', correo='$correo', contrasena='$hash', tipo='$tipo', nombre='$nombre', cargo='$cargo'
					WHERE id='$idREG'";

			$sms = "Usuario actualizado exitosamente.";

		}
	}
	
	else{
		
		if($idREG != ""){

			$sql = "UPDATE usuarios
					SET usuario='$usuario', correo='$correo', tipo='$tipo', nombre='$nombre', cargo='$cargo'
					WHERE id='$idREG'";

			$sms = "Usuario actualizado exitosamente.";

		}
	}
	
	$resultado = $conexion->query($sql);

	if($resultado === true) {

		echo $sms;

	} else{

		echo "El proceso no pudo ser completado.<br><br>" . $conexion->error;

	}
} else{

	echo "Completar campos obligatorios e internar nuevamente.";

}

$conexion->close();

?>