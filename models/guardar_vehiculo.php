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
$vehiculo = trim($_POST["vehiculo"]);
$e1 = $_POST["e1"];
$e2 = $_POST["e2"];
$e3 = $_POST["e3"];
$sms = "";

if($vehiculo != "" && $e1 != "" && $e2 != "" && $e3){

	if($idREG == ""){

		$sql = "INSERT INTO vehiculos(vehiculo, e1, e2, e3)
				VALUES ('$vehiculo', '$e1', '$e2', '$e3')";

		$sms = "Vehículo creado exitosamente.";

	} else{

		$sql = "UPDATE vehiculos
				SET vehiculo='$vehiculo', e1='$e1', e2='$e2', e3='$e3'
				WHERE id='$idREG'";

		$sms = "Vehículo actualizado exitosamente.";

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