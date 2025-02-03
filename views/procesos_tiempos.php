<?php 

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = $_SESSION["url_base"];

if(!isset($id) || ($tipo != "ADMINISTRADOR" && $tipo != "BÁSICO" && $tipo != "PROCESO" && $tipo != "CLIENTE")){
	
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

include "../conexion.php";

$proceso = $_POST["proceso"];
$sql = "SELECT t.id, c.causal, t.minutos
		FROM tiempos AS t, causales AS c
		WHERE t.sw=1 AND t.causal=c.id AND t.proceso='$proceso'";

$resultado = $conexion->query($sql);

if($resultado == true){

	while($fila = $resultado->fetch_array()){	

		$causal = $fila[1];
		$minutos = $fila[2];

		echo "<div class='caja-tiempos-elemento'>";
	     	echo "<div class='caja-tiempos-a' title='Eliminar'>"; 
	    		echo "<a href='Javascript:void()' data-id='$fila[0]' data-tabla='tiempos' data-elemento='Causal $causal' onClick='eliminarTiempo(this)'>X</a>";
	     	echo "</div>";
	     	echo "<div class='caja-tiempos-span'>";
	       		echo "<span>" . $causal . " (" . $minutos . ")</span>"; 
	         echo "</div>";
	     echo "</div>";

	}

	$resultado->free();

} else{
	echo "Error al agregar tiempos perdidos: " . $conexion->error;
}

$conexion->close();

?>