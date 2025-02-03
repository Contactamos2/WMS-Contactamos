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

$sql = "SELECT b.muelle
		FROM muelles AS b
		WHERE b.id='$idEDI' AND b.sw=1";
$resultado = $conexion->query($sql);						
$datos = $resultado->fetch_array();
$muelle = $datos[0];

$arreglo[] = array("muelle"=>$muelle);

echo json_encode($arreglo);

$resultado->free();
$conexion->close();

?>