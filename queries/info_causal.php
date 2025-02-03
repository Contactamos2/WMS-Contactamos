<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = $_SESSION["url_base"];

if(!isset($id) || ($tipo != "ADMINISTRADOR" && $tipo != "FLETEO")){
	 
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

include "../conexion.php";

$arreglo = array();
$idEDI = $_POST["id"];

$sql = "SELECT c.causal, c.proceso, c.cargue, c.muelle
		FROM causales AS c
		WHERE c.id='$idEDI' AND c.sw=1";
$resultado = $conexion->query($sql);						
$datos = $resultado->fetch_array();
$causal = $datos[0];
$proceso = $datos[1];
$cargue = $datos[2];
$muelle = $datos[3];

$arreglo[] = array("causal"=>$causal,
				   "proceso"=>$proceso,
				   "cargue"=>$cargue,
				   "muelle"=>$muelle);

echo json_encode($arreglo);

$resultado->free();
$conexion->close();

?>