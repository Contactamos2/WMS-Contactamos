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

$sql = "SELECT o.nombre1, o.nombre2, o.apellido1, o.apellido2, o.ndi, o.estado
		FROM operarios AS o
		WHERE o.id='$idEDI' AND o.sw=1";
$resultado = $conexion->query($sql);						
$datos = $resultado->fetch_array();
$nombre1 = $datos[0];
$nombre2 = $datos[1];
$apellido1 = $datos[2];
$apellido2 = $datos[3];
$ndi = $datos[4];
$estado = $datos[5];

$arreglo[] = array("nombre1"=>$nombre1,
				   "nombre2"=>$nombre2,
				   "apellido1"=>$apellido1,
				   "apellido2"=>$apellido2,
				   "ndi"=>$ndi,
				   "estado"=>$estado);

echo json_encode($arreglo);

$resultado->free();
$conexion->close();

?>