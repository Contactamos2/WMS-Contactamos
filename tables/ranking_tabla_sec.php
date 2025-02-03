<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = $_SESSION["url_base"];

if(!isset($id)){
	
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

include "../conexion.php";

$ranking = null;

$sql = "SELECT o.nombre1, o.nombre2, o.apellido1, o.apellido2
		FROM operarios AS o
		WHERE o.sw=1 AND o.estado='Activo'
		ORDER BY o.apellido1, o.apellido2, o.nombre1, o.nombre2";

$resultado = $conexion->query($sql);

if($resultado == true){

	while($fila = $resultado->fetch_array()){

		$nombre1 = $fila[0];
		$nombre2 = $fila[1];
		$apellido1 = $fila[2];
		$apellido2 = $fila[3];
		$operario = trim($apellido1 . " " . $apellido2 . " " . $nombre1 . " " . $nombre2);
		$toneladasTotal = 0;
		$horasTotal = 0;

		$sqlP = "SELECT f.id, f.estado, f.e1, f.e2, f.e3, f.e4, f.toneladas, f.operario1, f.operario2, f.operario3
				 FROM procesos AS f
				 WHERE f.sw=1 AND f.carga='ARRUME NEGRO' AND (f.operario1='$operario' OR f.operario2='$operario' OR f.operario3='$operario')";

		$resultadoP = $conexion->query($sqlP);

		if($resultadoP == true){

			while($filaP = $resultadoP->fetch_array()){

				$idProceso = $filaP[0];
				$estado = $filaP[1];
				$e1 = $filaP[2];
				$e2 = $filaP[3];
				$e3 = $filaP[4];
				$e4 = $filaP[5];
				$toneladas = $filaP[6];
				$operario1 = $filaP[7];
				$operario2 = $filaP[8];
				$operario3 = $filaP[9];
				$operarios = 0;
				$tpDesCargue = 0;

				if($operario1 != ""){ $operarios++; }
				if($operario2 != ""){ $operarios++; }
				if($operario3 != ""){ $operarios++; }

				$sqlTP = "SELECT t.minutos, c.cargue
						  FROM tiempos AS t, causales AS c
						  WHERE t.sw=1 AND t.causal=c.id AND t.proceso='$idProceso'";
				$resultadoTP = $conexion->query($sqlTP);	

				if($resultadoTP == true){

					while($filaTP = $resultadoTP->fetch_array()){

						$minutos = $filaTP[0];
						$des_cargue = $filaTP[1];

						if($des_cargue == "SI"){ $tpDesCargue += $minutos/60; }

					}
				}

				if($estado == "DES/CARGADO" || $estado == "SALIDA DE MUELLE"){

					$start_date = new DateTime($e2);
					$since_start = $start_date->diff(new DateTime($e3));
					$horas = $since_start->h;
					$minutos =  $since_start->i;
					$tiempoDesCargue = $horas + $minutos/60;

					$toneladasTotal += $toneladas/$operarios;
					$horasTotal += ($tiempoDesCargue - $tpDesCargue)/$operarios;
			
				}
			}
		} else{
			echo "Error al cargar procesos: " . $conexion->error;
		}

		if($toneladasTotal > 0 && $horasTotal > 0){

			$productividad = $toneladasTotal/$horasTotal;

			$ranking[] = ["operario" => $operario, "toneladas" => $toneladasTotal, "horas" => $horasTotal, "productividad" => $productividad];

		}
	}
} else{
	echo "Error al cargar ranking: " . $conexion->error;
}

if($ranking != null){

	$n = 1;
	$orden = array();

	foreach ($ranking as $key => $row)
	{
	    $orden[$key] = $row['productividad'];    
	}

	array_multisort($orden, SORT_DESC, $ranking);

	foreach ($ranking as $key => $value) {

		echo "<tr class='fila'>";	
			echo "<td>" . $n++ . "</td>";
			echo "<td class='left'>" . $value["operario"] . "</td>";
			echo "<td>" . number_format($value["toneladas"], 2, ",", ".") . "</td>";
			echo "<td>" . number_format($value["horas"], 2, ",", ".") . "</td>";
			echo "<td>" . number_format($value["productividad"], 2, ",", ".") . "</td>";
		echo "</tr>";

	}
}

$resultado->free();
$resultadoP->free();
$resultadoTP->free();
$conexion->close();

?>