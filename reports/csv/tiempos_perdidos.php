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

$inicio = $_GET["inicio"];
$fin = $_GET["fin"];
$turno = $_GET["turno"];
$criterios = "";

if(isset($inicio) && isset($fin) && isset($turno)){

	if($inicio != ""){ $criterios .= "AND f.registro>='$inicio'"; }
	if($fin != ""){ $criterios .= "AND f.registro<='$fin'"; }
	if($turno != ""){ $criterios .= "AND t.turno='$turno'"; }

} else{

	header("Location:" . $url_base . "login.php");
	
	die();

}

include "../../conexion.php";

$sql = "SELECT f.id, f.estado, f.registro, l.nick, t.turno, b.muelle, f.atencion, v.vehiculo, c.canal, f.placa
		FROM procesos AS f, lideres AS l, vehiculos AS v, turnos AS t, muelles AS b, canales AS c
		WHERE f.sw=1 AND f.estado='SALIDA DE MUELLE' AND f.lider=l.id AND f.turno=t.id AND f.muelle=b.muelle AND f.vehiculo=v.id AND f.canal=c.id $criterios
		ORDER BY f.registro ASC, f.turno ASC";

$resultado = $conexion->query($sql);
$tabla = "Estado" . ";" . 
		 "Registro" . ";" . 
		 utf8_decode("Líder") . ";" . 
		 "Turno" . ";" . 
		 "Muelle" . ";" . 
		 utf8_decode("Atención") . ";" . 
		 utf8_decode("Vehículo") . ";" . 
		 "Placa" . ";" . 
		 "Canal" . ";" . 
		 "Proceso responsable" . ";" . 
		 "Causal" . ";" . 
		 "Minutos" . "\n";

while($fila = $resultado->fetch_array()){
	
	$idProceso = $fila[0];
	$estado = $fila[1];
	$registro = $fila[2];
	$lider = utf8_decode($fila[3]);
	$turno = $fila[4];
	$muelle = $fila[5];
	$atencion = $fila[6];
	$vehiculo = utf8_decode($fila[7]);
	$canal = utf8_decode($fila[8]);
	$placa = $fila[9];

	$sqlTP = "SELECT c.proceso, c.causal, t.minutos
			  FROM tiempos AS t, causales AS c
			  WHERE t.sw=1 AND t.causal=c.id AND t.proceso='$idProceso'
			  ORDER BY c.proceso ASC, c.causal ASC, t.minutos DESC";
	$resultadoTP = $conexion->query($sqlTP);	

	while($filaTP = $resultadoTP->fetch_array()){

		$proceso = utf8_decode($filaTP[0]);
		$causal = utf8_decode($filaTP[1]);
		$minutos = $filaTP[2];
	
		$tabla .= $estado . ";" . 
				  $registro . ";" . 
				  $lider . ";" . 
				  $turno . ";" . 
				  $muelle . ";" . 
				  $atencion . ";" . 
				  $vehiculo . ";" . 
				  $placa . ";" . 
				  $canal . ";" . 
				  $proceso . ";" . 
				  $causal . ";" . 
				  $minutos . "\n";

	}
}

header("Content-Description: File Transfer");
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=Tiempos perdidos.csv");

echo $tabla;

?>


