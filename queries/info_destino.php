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

$sql = "SELECT d.destino
		FROM destinos AS d
		WHERE d.id='$idEDI' AND d.sw=1";
$resultado = $conexion->query($sql);						
$datos = $resultado->fetch_array();
$destino = $datos[0];

$arreglo[] = array("destino"=>$destino);

echo json_encode($arreglo);

$resultado->free();
$conexion->close();

?>