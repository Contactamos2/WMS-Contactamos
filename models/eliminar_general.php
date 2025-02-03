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
$idREG = $_POST["id"];
$tabla = $_POST["tabla"];

$sql = "UPDATE $tabla 
		SET sw=0
		WHERE id=$idREG";

$resultado = $conexion->query($sql);

if($resultado === true){
	
	echo "Registro eliminado existosamente.";	
	
} else {
	
	echo "El registro no pudo ser eliminado. <br><br>" . $conexion->error;
	
}

?>