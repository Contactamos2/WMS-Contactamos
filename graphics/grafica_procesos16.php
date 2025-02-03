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

$sql1 = "SELECT f.registro
		 FROM procesos AS f
		 WHERE f.sw=1 AND f.registro between '$inicio' AND '$fin'
		 GROUP BY f.registro";
$resultado1 = $conexion->query($sql1);

if($resultado1 == true){

	while($fila1 = $resultado1->fetch_array()){
		
		$registro = $fila1[0];		
		$descargues = 0;		
		$cargues = 0;

		$sql2 = "SELECT f.atencion, f.cajas
				 FROM procesos AS f
				 WHERE f.sw=1 AND f.registro='$registro'";
		$resultado2 = $conexion->query($sql2);

		if($resultado2 == true){

			while($fila2 = $resultado2->fetch_array()){

				$atencion = $fila2[0];
				$cajas = $fila2[1];

				if($atencion == "DESCARGUE"){ $descargues += $cajas; }
				if($atencion == "CARGUE"){ $cargues += $cajas; }

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