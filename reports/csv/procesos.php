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

$sql = "SELECT f.id, f.estado, f.registro, l.nick, t.turno, b.muelle, v.vehiculo, c.canal, p.procedencia, d.destino, f.tras_rem, f.transporteS, f.e1, f.e2, f.e3, f.e4, f.toneladas, f.observaciones, f.atencion, f.placa, f.carga, f.estibas, f.operario1, f.operario2, f.operario3, f.cajas
		FROM procesos AS f, lideres AS l, vehiculos AS v, turnos AS t, muelles AS b, procedencias AS p, destinos AS d, canales AS c
		WHERE f.sw=1 AND f.lider=l.id AND f.turno=t.id AND f.muelle=b.muelle AND f.vehiculo=v.id AND f.procedencia=p.id AND f.destino=d.id AND f.canal=c.id $criterios
		ORDER BY f.registro ASC, f.turno ASC, f.e1 ASC";

$resultado = $conexion->query($sql);
$tabla = "Estado" . ";" . 
		 "Registro" . ";" . 
		 utf8_decode("Líder") . ";" . 
		 "Turno" . ";" . 
		 "Muelle" . ";" . 
		 utf8_decode("Atención") . ";" . 
		 utf8_decode("Vehículo") . ";" . 
		 "Placa" . ";" . 
		 "Tran. / Rem." . ";" . 
		 "Trans. Salida" . ";" . 
		 "Procedencia" . ";" . 
		 "Destino" . ";" . 
		 "Canal / Negocio" . ";" . 
		 "Carga" . ";" . 
		 "Estibas" . ";" . 
		 "Kilogramos" . ";" . 
		 "Cajas" . ";" . 
		 "Operador logístico 1" . ";" . 
		 "Operador logístico 2" . ";" . 
		 "Operador logístico 3" . ";" . 
		 "E1" . ";" . 
		 "E2" . ";" . 
		 "E3" . ";" . 
		 "E4" . ";" . 
		 "Des/cargue (min)" . ";" . 
		 utf8_decode("En muelle (min)") . ";" . 
		 "Tiempo perdido (min)" . ";" . 
		 "Observaciones" . "\n";

while($fila = $resultado->fetch_array()){
	
	$idProceso = $fila[0];
	$estado = $fila[1];
	$registro = date("d/m/Y",strtotime($fila[2]));
	$lider = utf8_decode($fila[3]);
	$turno = $fila[4];
	$muelle = $fila[5];
	$vehiculo = utf8_decode($fila[6]);
	$canal = utf8_decode($fila[7]);
	$procedencia = utf8_decode($fila[8]);
	$destino = utf8_decode($fila[9]);
	$tras_rem = $fila[10] == "" ? "NO APLICA" : utf8_decode($fila[10]);
	$transporteS = $fila[11] == "" ? "NO APLICA" : utf8_decode($fila[11]);
	$e1 = date("H:i",strtotime($fila[12]));
	$e2 = date("H:i",strtotime($fila[13]));
	$e3 = date("H:i",strtotime($fila[14]));
	$e4 = date("H:i",strtotime($fila[15]));
	$toneladas = str_replace(".", ",", $fila[16]);

	$arr = array("$n\r\n", "$n\n", "$n\r");
	$observaciones = utf8_decode(str_replace($arr, " // ", $fila[17]));
	
	$atencion = $fila[18];
	$placa = $fila[19];
	$carga = utf8_decode($fila[20]);
	$estibas = $fila[21];
	$operario1 = utf8_decode($fila[22]);
	$operario2 = utf8_decode($fila[23]);
	$operario3 = utf8_decode($fila[24]);
	$cajas = $fila[25];

	$sqlTP = "SELECT SUM(t.minutos)
			  FROM tiempos AS t
			  WHERE t.sw=1 AND t.proceso='$idProceso'";
	$resultadoTP = $conexion->query($sqlTP);	
	$filaTP = $resultadoTP->fetch_array();
	$tp = $filaTP[0];

	if($tp == ""){ $tp = 0; }

	if($estado == "CARGADO" || $estado == "SALIDA DE MUELLE"){

	$start_date = new DateTime($fila[13]);
	$since_start = $start_date->diff(new DateTime($fila[14]));
	$horas = $since_start->h;
	$minutos =  $since_start->i;
	$tiempoDesCargue = $horas*60 + $minutos;

	} else{

		$tiempoDesCargue = "...";

	}	

	if($estado == "SALIDA DE MUELLE"){

		$start_date = new DateTime($fila[12]);
		$since_start = $start_date->diff(new DateTime($fila[15]));
		$horas = $since_start->h;
		$minutos =  $since_start->i;
		$tiempoAnden = $horas*60 + $minutos;

	} else{

		$tiempoAnden = "...";

	}
	
	$tabla .= $estado . ";" . 
			  $registro . ";" . 
			  $lider . ";" . 
			  $turno . ";" . 
			  $muelle . ";" . 
			  $atencion . ";" . 
			  $vehiculo . ";" . 
			  $placa . ";" . 
			  $tras_rem . ";" . 
			  $transporteS . ";" . 
			  $procedencia . ";" . 
			  $destino . ";" . 
			  $canal . ";" . 
			  $carga . ";" . 
			  $estibas . ";" . 
			  $toneladas . ";" . 
			  $cajas . ";" . 
			  $operario1 . ";" . 
			  $operario2 . ";" . 
			  $operario3 . ";" . 
			  $e1 . ";" . 
			  $e2 . ";" . 
			  $e3 . ";" . 
			  $e4 . ";" . 
			  $tiempoDesCargue . ";" . 
			  $tiempoAnden . ";" . 
			  $tp . ";" . 
			  $observaciones . "\n";

}

header("Content-Description: File Transfer");
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=Procesos.csv");

echo $tabla;

?>


