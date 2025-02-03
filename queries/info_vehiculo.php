<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = $_SESSION["url_base"];

if(!isset($id) || ($tipo != "ADMINISTRADOR" && $tipo != "FLETEO" && $tipo != "DESPACHOS" && $tipo != "SEDIAL")){
	 
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

include "../conexion.php";

$arreglo = array();
$idEDI = $_POST["id"];

$sql = "SELECT v.vehiculo, v.carpado, v.precarga, v.e1, v.e2, v.e3, v.e4, v.e5, v.e6, v.e7
		FROM vehiculos AS v
		WHERE v.id='$idEDI' AND v.sw=1";
$resultado = $conexion->query($sql);						
$datos = $resultado->fetch_array();
$vehiculo = $datos[0];
$carpado = $datos[1];
$precarga = $datos[2];
$e1 = $datos[3];
$e2 = $datos[4];
$e3 = $datos[5];
$e4 = $datos[6];
$e5 = $datos[7];
$e6 = $datos[8];
$e7 = $datos[9];

$arreglo[] = array("vehiculo"=>$vehiculo,
				   "carpado"=>$carpado,
				   "precarga"=>$precarga,
				   "e1"=>$e1,
				   "e2"=>$e2,
				   "e3"=>$e3,
				   "e4"=>$e4,
				   "e5"=>$e5,
				   "e6"=>$e6,
				   "e7"=>$e7);

echo json_encode($arreglo);

$resultado->free();
$conexion->close();

?>