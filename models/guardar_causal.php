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
$causal = trim($_POST["causal"]);
$proceso = $_POST["proceso"];
$cargue = $_POST["cargue"];
$muelle = $_POST["muelle"];
$sms = "";

if($causal != "" && $proceso != "" && $cargue != "" && $muelle != ""){

	if($idREG == ""){

		$sql = "INSERT INTO causales(causal, proceso, cargue, muelle)
				VALUES ('$causal', '$proceso', '$cargue', '$muelle')";

		$sms = "Causal creada exitosamente.";

	} else{

		$sql = "UPDATE causales
				SET causal='$causal', proceso='$proceso', cargue='$cargue', muelle='$muelle'
				WHERE id='$idREG'";

		$sms = "Causal actualizada exitosamente.";

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