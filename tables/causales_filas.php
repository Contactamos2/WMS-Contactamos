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

	$sql = "SELECT COUNT(c.causal)
			FROM causales AS c
			WHERE c.sw=1";
	
} else{
	
	$sql = "SELECT COUNT(c.causal)
			FROM causales AS c
			WHERE c.sw=1
			AND (
				POSITION('$consulta' IN c.causal) OR
				POSITION('$consulta' IN c.proceso) OR
				POSITION('$consulta' IN c.cargue) OR
				POSITION('$consulta' IN c.muelle)
			)";
	
}

$resultado = $conexion->query($sql);	
$datos = $resultado->fetch_array();
$filas = $datos[0];
$maximo = ceil($filas/$limite);

echo $maximo;

$conexion->close();

?>