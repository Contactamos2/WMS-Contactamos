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

$sql = "SELECT p.procedencia
		FROM procedencias AS p
		WHERE p.id='$idEDI' AND p.sw=1";
$resultado = $conexion->query($sql);						
$datos = $resultado->fetch_array();
$procedencia = $datos[0];

$arreglo[] = array("procedencia"=>$procedencia);

echo json_encode($arreglo);

$resultado->free();
$conexion->close();

?>