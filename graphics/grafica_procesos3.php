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
$inicio = $_POST["inicio"];
$fin = $_POST["fin"];
$turno = $_POST["turno"];
$canal = $_POST["canal"];
$vehiculo = $_POST["vehiculo"];
$criterios = "";

if($turno != ""){ $criterios = "AND f.turno='$turno'"; }
if($canal != ""){ $criterios = "AND f.canal='$canal'"; }
if($vehiculo != ""){ $criterios = "AND f.vehiculo='$vehiculo'"; }

$sql1 = "SELECT f.registro
		FROM procesos AS f
		WHERE f.sw=1 AND f.registro between '$inicio' AND '$fin'
		GROUP BY f.registro";
		$resultado1 = $conexion->query($sql1);

if($resultado1 == true){

	while($fila1 = $resultado1->fetch_array()){

		$registro = $fila1[0];	
		$cargues = 0;
		$descargues = 0;

		$sql2 = "SELECT f.atencion
				 FROM procesos AS f
				 WHERE f.sw=1 AND f.registro='$registro' $criterios";
		$resultado2 = $conexion->query($sql2);

		if($resultado2 == true){

			while($fila2 = $resultado2->fetch_array()){

				$atencion = $fila2[0];

				if($atencion == "CARGUE"){ $cargues++; }
				if($atencion == "DESCARGUE"){ $descargues++; }

			}
		}

		$registro = date("d/m",strtotime($registro));	
		$arreglo[] = array("registro"=>$registro,
						   "cargue"=>$cargues,
						   "descargue"=>$descargues);

	}
}

echo json_encode($arreglo);

$resultado1->free();
$resultado2->free();
$conexion->close();

?>