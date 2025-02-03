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
$inicio = $_POST["anio"] . "-01-01";
$criterios = "";

$hoy = date("Y-m-d");
$meses = ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];

$instaladaCargue = 24.17*6.5*4*3;
$instaladaDescargue = 24.17*6.5*4*3;

for($i = 0; $i <= count($meses); $i++){

	$m = $i ? 1 : 0;
	$inicio = date("Y-m-d", strtotime($inicio . "+" . $m . " months"));
	$fin = date("Y-m-d", strtotime($inicio . "+1 months"));
	$fin = date("Y-m-d", strtotime($fin . "-1 days"));
	$mes = $meses[date("n",strtotime($inicio))-1];

	if($inicio <= $hoy){

		$sumaCargue = 0;
		$operariosCargue = array();
		$cuentaCargue = 0;
		$ocupacionCargue = 0;
		$registrosCargue = array();
		
		$sumaDescargue = 0;
		$operariosDescargue = array();
		$cuentaDescargue = 0;
		$ocupacionDescargue = 0;
		$registrosDescargue = array();

		$sql = "SELECT f.e1, f.e2, f.e3, f.e4, f.operario1, f.operario2, f.operario3, f.atencion, f.registro
				FROM procesos AS f
				WHERE f.sw=1 AND f.estado='SALIDA DE MUELLE' AND f.registro between '$inicio' AND '$fin' $criterios";
		$resultado = $conexion->query($sql);

		if($resultado == true){

			while($fila = $resultado->fetch_array()){

				$e1 = $fila[0];
				$e2 = $fila[1];
				$e3 = $fila[2];
				$e4 = $fila[3];
				$operario1 = $fila[4];
				$operario2 = $fila[5];
				$operario3 = $fila[6];
				$atencion = $fila[7];
				$registro = $fila[8];

				//MINUTOS
				$start_date = new DateTime($e2);
				$since_start = $start_date->diff(new DateTime($e3));
				$horas = $since_start->h;
				$minutos =  $since_start->i;
				$tiempo = $horas*60 + $minutos;		

				//OPERARIOS
				$operarios = array();				

				//ATENCIÓN
				if($atencion == "CARGUE"){

					$sumaCargue += $tiempo;
					$cuentaCargue++;

					array_push($operariosCargue, $operario1);
					array_push($operariosCargue, $operario2);
					array_push($operariosCargue, $operario3);
					array_push($registrosCargue, $registro);

				}

				if($atencion == "DESCARGUE"){

					$sumaDescargue += $tiempo;
					$cuentaDescargue++;

					array_push($operariosDescargue, $operario1);
					array_push($operariosDescargue, $operario2);
					array_push($operariosDescargue, $operario3);
					array_push($registrosDescargue, $registro);

				}
			}
		}

		if($cuentaCargue > 0){ 
			
			$horas_hombreCargue = ($sumaCargue/60)*(count(array_unique($operariosCargue))/count(array_unique($registrosCargue)));
			$ocupacionCargue = round(($horas_hombreCargue/$instaladaCargue)*100,2);
		
		}

		if($cuentaDescargue > 0){ 
			
			$horas_hombreDescargue = ($sumaDescargue/60)*(count(array_unique($operariosDescargue))/count(array_unique($registrosDescargue)));
			$ocupacionDescargue = round(($horas_hombreDescargue/$instaladaDescargue)*100,2);
		
		}
		
		$arreglo[] = array("mes"=>$mes,
						   "cargue"=>$ocupacionCargue,
						   "descargue"=>$ocupacionDescargue);
		
	}
}

echo json_encode($arreglo);

$resultado->free();
$conexion->close();

?>