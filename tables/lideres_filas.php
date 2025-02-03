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

	$sql = "SELECT COUNT(l.id)
			FROM lideres AS l
			WHERE l.sw=1";
	
} else{
	
	$sql = "SELECT COUNT(l.id)
			FROM lideres AS l
			WHERE l.sw=1
			AND (
				POSITION('$consulta' IN l.id) OR
				POSITION('$consulta' IN l.nombre) OR
				POSITION('$consulta' IN l.nick) OR
				POSITION('$consulta' IN l.proceso)
			)";
	
}

$resultado = $conexion->query($sql);	
$datos = $resultado->fetch_array();
$filas = $datos[0];
$maximo = ceil($filas/$limite);

echo $maximo;

$conexion->close();

?>