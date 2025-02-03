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

$sql = "SELECT t.turno
		FROM turnos AS t
		WHERE t.id='$idEDI' AND t.sw=1";
$resultado = $conexion->query($sql);						
$datos = $resultado->fetch_array();
$turno = $datos[0];

$arreglo[] = array("turno"=>$turno);

echo json_encode($arreglo);

$resultado->free();
$conexion->close();

?>