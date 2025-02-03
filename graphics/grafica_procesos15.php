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
$canal = $_POST["canal"];
$criterios = "";

if($canal != ""){ $criterios = "AND f.canal='$canal'"; }

$sql1 = "SELECT f.registro
		 FROM procesos AS f
		 WHERE f.sw=1 AND f.atencion='CARGUE' AND f.registro between '$inicio' AND '$fin'
		 GROUP BY f.registro";
$resultado1 = $conexion->query($sql1);

if($resultado1 == true){

	while($fila1 = $resultado1->fetch_array()){
		
		$registro = $fila1[0];	
		$sumaDesCargue = 0;
		$sumaAnden = 0;
		$cuentaDesCargue = 0;
		$cuentaAnden = 0;
		$promedioDesCargue = 0;
		$promedioAnden = 0;

		$sql2 = "SELECT f.e1, f.e2, f.e3, f.e4
				 FROM procesos AS f, vehiculos AS v
				 WHERE f.sw=1 AND f.vehiculo=v.id AND f.estado='SALIDA DE MUELLE' AND f.registro='$registro' $criterios";
		$resultado2 = $conexion->query($sql2);

		if($resultado2 == true){

			while($fila2 = $resultado2->fetch_array()){

				$e1 = $fila2[0];
				$e2 = $fila2[1];
				$e3 = $fila2[2];
				$e4 = $fila2[3];

				$start_date = new DateTime($e2);
				$since_start = $start_date->diff(new DateTime($e3));
				$horas = $since_start->h;
				$minutos =  $since_start->i;
				$tiempoDesCargue = $horas*60 + $minutos;

				$sumaDesCargue += $tiempoDesCargue;
				$cuentaDesCargue++;

				$start_date = new DateTime($e1);
				$since_start = $start_date->diff(new DateTime($e4));
				$horas = $since_start->h;
				$minutos =  $since_start->i;
				$tiempoAnden = $horas*60 + $minutos;

				$sumaAnden += $tiempoAnden;
				$cuentaAnden++;

			}
		}

		if($cuentaDesCargue > 0){ $promedioDesCargue = round($sumaDesCargue/$cuentaDesCargue,2); }	
		if($cuentaAnden > 0){ $promedioAnden = round($sumaAnden/$cuentaAnden,2); }
		
		$registro = date("d/m",strtotime($registro));	
		$arreglo[] = array("registro"=>$registro,
				   		   "des_cargue"=>$promedioDesCargue,
				   		   "enanden"=>$promedioAnden);
		
	}
}

echo json_encode($arreglo);

$resultado1->free();
$resultado2->free();
$conexion->close();

?>