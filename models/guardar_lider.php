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
$ndi = $_POST["ndi"];
$nombre = trim($_POST["nombre_apellido"]);
$nick = trim($_POST["nick"]);
$proceso = $_POST["proceso"];
$sms = "";

if($ndi != "" && $nombre != "" && $nick != ""){

	if($idREG == ""){

		$sql = "INSERT INTO lideres(ndi, nombre, nick, proceso)
				VALUES ('$ndi', '$nombre', '$nick', '$proceso')";

		$sms = "Líder creado exitosamente.";

	} else{

		$sql = "UPDATE lideres
				SET ndi='$ndi', nombre='$nombre', nick='$nick', proceso='$proceso'
				WHERE id='$idREG'";

		$sms = "Líder actualizado exitosamente.";

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