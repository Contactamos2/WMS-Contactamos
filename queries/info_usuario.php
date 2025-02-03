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

$sql = "SELECT u.usuario, u.correo, u.contrasena, u.tipo, u.nombre, u.cargo
		FROM usuarios AS u
		WHERE u.id='$idEDI' AND u.sw=1";
$resultado = $conexion->query($sql);						
$datos = $resultado->fetch_array();
$usuario = $datos[0];
$correo = $datos[1];
$contrasena = $datos[2];
$tipo = $datos[3];
$nombre = $datos[4];
$cargo = $datos[5];

$arreglo[] = array("usuario"=>$usuario,
				   "correo"=>$correo,
				   "contrasena"=>$contrasena,
				   "tipo"=>$tipo,
				   "nombre"=>$nombre,
				   "cargo"=>$cargo);

echo json_encode($arreglo);

$resultado->free();
$conexion->close();

?>