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

$arreglo = array();
$idEDI = $_POST["id"];

$sql = "SELECT l.ndi, l.nombre, l.nick, l.proceso
		FROM lideres AS l
		WHERE l.id='$idEDI' AND l.sw=1";
$resultado = $conexion->query($sql);						
$datos = $resultado->fetch_array();
$ndi = $datos[0];
$nombre_apellido = $datos[1];
$nick = $datos[2];
$proceso = $datos[3];

$arreglo[] = array("ndi"=>$ndi,
				   "nombre_apellido"=>$nombre_apellido,
				   "nick"=>$nick,
				   "proceso"=>$proceso);

echo json_encode($arreglo);

$resultado->free();
$conexion->close();

?>