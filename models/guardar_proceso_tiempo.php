<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = $_SESSION["url_base"];

if(!isset($id) || ($tipo != "ADMINISTRADOR" && $tipo != "BÁSICO" && $tipo != "PROCESO")){
	
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

include "../conexion.php";

$usuario = $_SESSION["usuario"];
$idREG = $_POST["idTiempo"];
$causal = $_POST["causal"];
$minutos = $_POST["minutos"];
$sms = "";

if($causal != "" && $minutos != ""){
		
	if($idREG != ""){

		$sql = "INSERT INTO tiempos(proceso, causal, minutos, usuario)
				VALUES ('$idREG', '$causal', '$minutos', '$usuario')";

		$resultado = $conexion->query($sql);
		
		if($resultado === true) {

			echo "Tiempo perdido agregado exitosamente.";

		} else{

			echo "El proceso no pudo ser completado.<br><br>" . $conexion->error;

		}
	} else{

		echo "El proceso no ha sido creado.";

	}
} else{

	echo "Completar campos obligatorios e internar nuevamente.";

}

$conexion->close();

?>