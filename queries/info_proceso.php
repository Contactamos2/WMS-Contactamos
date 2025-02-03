<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$url_base = $_SESSION["url_base"];

if(!isset($id)){
	
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

include "../conexion.php";

$arreglo = array();
$idEDI = $_POST["id"];

$sql = "SELECT f.estado, f.registro, f.lider, f.turno, f.muelle, f.vehiculo, f.canal, f.procedencia, f.destino, f.tras_rem, f.transporteS, f.e1, f.e2, f.e3, f.e4, f.toneladas, f.observaciones, f.atencion, f.placa, f.carga, f.estibas, f.operario1, f.operario2, f.operario3, f.cajas
		FROM procesos AS f
		WHERE f.id='$idEDI' AND f.sw=1";
$resultado = $conexion->query($sql);						
$datos = $resultado->fetch_array();
$estado = $datos[0];
$registro = $datos[1];
$lider = $datos[2];
$turno = $datos[3];
$muelle = $datos[4];
$vehiculo = $datos[5];
$canal = $datos[6];
$procedencia = $datos[7];
$destino = $datos[8];
$tras_rem = $datos[9];
$transporteS = $datos[10];
$e1 = date("Y-m-d\TH:i", strtotime($datos[11]));
$e2 = date("Y-m-d\TH:i", strtotime($datos[12]));
$e3 = date("Y-m-d\TH:i", strtotime($datos[13]));
$e4 = date("Y-m-d\TH:i", strtotime($datos[14]));
$toneladas = $datos[15];
$observaciones = $datos[16];
$atencion = $datos[17];
$placa = $datos[18];
$carga = $datos[19];
$estibas = $datos[20];
$operario1 = $datos[21];
$operario2 = $datos[22];
$operario3 = $datos[23];
$cajas = $datos[24];

$arreglo[] = array("estado"=>$estado,
				   "registro"=>$registro,
				   "lider"=>$lider,
				   "turno"=>$turno,
				   "muelle"=>$muelle,
				   "atencion"=>$atencion,
				   "vehiculo"=>$vehiculo,
				   "placa"=>$placa,
				   "procedencia"=>$procedencia,
				   "destino"=>$destino,
				   "tras_rem"=>$tras_rem,
				   "transporteS"=>$transporteS,
				   "canal"=>$canal,
				   "carga"=>$carga,
				   "estibas"=>$estibas,
				   "toneladas"=>$toneladas,
				   "cajas"=>$cajas,
				   "operario1"=>$operario1,
				   "operario2"=>$operario2,
				   "operario3"=>$operario3,
				   "e1"=>$e1,
				   "e2"=>$e2,
				   "e3"=>$e3,
				   "e4"=>$e4,
				   "observaciones"=>$observaciones);

echo json_encode($arreglo);

$resultado->free();
$conexion->close();

?>