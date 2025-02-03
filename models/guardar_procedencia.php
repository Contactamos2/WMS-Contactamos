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
$procedencia = trim($_POST["procedencia"]);
$sms = "";

if($procedencia != ""){

	if($idREG == ""){

		$sql = "INSERT INTO procedencias(procedencia)
				VALUES ('$procedencia')";

		$sms = "Procedencia creada exitosamente.";

	} else{

		$sql = "UPDATE procedencias
				SET procedencia='$procedencia'
				WHERE id='$idREG'";

		$sms = "Procedencia actualizada exitosamente.";

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