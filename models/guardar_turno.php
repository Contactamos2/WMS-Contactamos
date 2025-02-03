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
$turno = $_POST["turno"];
$sms = "";

if($turno != ""){

	if($idREG == ""){

		$sql = "INSERT INTO turnos(turno)
				VALUES ('$turno')";

		$sms = "Turno creado exitosamente.";

	} else{

		$sql = "UPDATE turnos
				SET turno='$turno'
				WHERE id='$idREG'";

		$sms = "Turno actualizado exitosamente.";

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