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

	$sql = "SELECT COUNT(u.usuario)
			FROM usuarios AS u
			WHERE u.sw=1";
	
} else{
	
	$sql = "SELECT COUNT(u.usuario)
			FROM usuarios AS u
			WHERE u.sw=1
			AND (
				POSITION('$consulta' IN u.usuario) OR
				POSITION('$consulta' IN u.correo) OR
				POSITION('$consulta' IN u.contrasena) OR
				POSITION('$consulta' IN u.tipo) OR
				POSITION('$consulta' IN u.nombre) OR
				POSITION('$consulta' IN u.cargo) OR
				POSITION('$consulta' IN u.creacion)
			)";
	
}

$resultado = $conexion->query($sql);	
$datos = $resultado->fetch_array();
$filas = $datos[0];
$maximo = ceil($filas/$limite);

echo $maximo;

$conexion->close();

?>