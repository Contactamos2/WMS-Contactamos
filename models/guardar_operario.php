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
$nombre1 = trim($_POST["nombre1"]);
$nombre2 = trim($_POST["nombre2"]);
$apellido1 = trim($_POST["apellido1"]);
$apellido2 = trim($_POST["apellido2"]);
$ndi = $_POST["ndi"];
$estado = $_POST["estado"];
$sms = "";

if($nombre1 != "" && $nombre2 != "" && $apellido1 != "" && $apellido2 != "" && $ndi != "" && $estado != ""){

	if($idREG == ""){

		$sql = "INSERT INTO operarios(nombre1, nombre2, apellido1, apellido2, ndi, estado)
				VALUES ('$nombre1', '$nombre2', '$apellido1', '$apellido2', '$ndi', '$estado')";

		$sms = "Operario creado exitosamente.";

	} else{

		$sql = "UPDATE operarios
				SET nombre1='$nombre1', nombre2='$nombre2', apellido1='$apellido1', apellido2='$apellido2', ndi='$ndi', estado='$estado'
				WHERE id='$idREG'";

		$sms = "Operario actualizado exitosamente.";

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