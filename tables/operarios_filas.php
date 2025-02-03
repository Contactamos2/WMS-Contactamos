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

$limite = $_POST["limite"];
$consulta = $_POST["consulta"];

if($consulta == ""){

	$sql = "SELECT COUNT(o.id)
			FROM operarios AS o
			WHERE o.sw=1";
	
} else{
	
	$sql = "SELECT COUNT(o.id)
			FROM operarios AS o
			WHERE o.sw=1
			AND (
				POSITION('$consulta' IN o.nombre1) OR
				POSITION('$consulta' IN o.nombre2) OR
				POSITION('$consulta' IN o.apellido1) OR
				POSITION('$consulta' IN o.apellido2) OR
				POSITION('$consulta' IN o.ndi) OR
				POSITION('$consulta' IN o.estado)
			)";
	
}

$resultado = $conexion->query($sql);	
$datos = $resultado->fetch_array();
$filas = $datos[0];
$maximo = ceil($filas/$limite);

echo $maximo;

$conexion->close();

?>