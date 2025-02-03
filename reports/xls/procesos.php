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

header("Content-Type: application/vnd.ms-excel charset=utf-8");
header("Content-Disposition: attachment; filename=Procesos.xls");

include "../../conexion.php";

$sql = "SELECT f.id, f.estado, f.registro, l.nick, t.turno, b.muelle, v.vehiculo, c.canal, p.procedencia, d.destino, f.tras_rem, f.transporteS, f.e1, f.e2, f.e3, f.e4, f.toneladas, f.observaciones, f.atencion, f.placa, f.carga, f.estibas, f.operario1, f.operario2, f.operario3, f.cajas
		FROM procesos AS f, lideres AS l, vehiculos AS v, turnos AS t, muelles AS b, procedencias AS p, destinos AS d, canales AS c
		WHERE f.sw=1 AND f.lider=l.id AND f.turno=t.id AND f.muelle=b.muelle AND f.vehiculo=v.id AND f.procedencia=p.id AND f.destino=d.id AND f.canal=c.id $criterios
		ORDER BY f.registro ASC, f.turno ASC, f.e1 ASC";

$resultado = $conexion->query($sql);

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<table style="font-size:15px">
	<tr>
		<th>Estado</th>
		<th>Registro</th>
		<th>L&iacute;der</th>
		<th>Turno</th>
		<th>Muelle</th>
		<th>Atenci&oacute;n</th>
		<th>Veh&iacute;culo</th>
		<th>Placa</th>
		<th>Tran. / Rem.</th>
		<th>Trans. Salida</th>
		<th>Procedencia</th>
		<th>Destino</th>
		<th>Canal / Negocio</th>
		<th>Carga</th>
		<th>Estibas</th>
		<th>Kilogramos</th>
		<th>Cajas</th>
		<th>Operador logístico 1</th>
		<th>Operador logístico 2</th>
		<th>Operador logístico 3</th>
		<th>E1</th>
		<th>E2</th>
		<th>E3</th>
		<th>E4</th>
		<th>Des/cargue (min)</th>
		<th>En and&eacute;n (min)</th>
		<th>Tiempo perdido (min)</th>
		<th>Observaciones</th>
	</tr>
	<?php 
		while($fila = $resultado->fetch_array()){

			$idProceso = $fila[0];
			$estado = $fila[1];
			$registro = date("d/m/Y",strtotime($fila[2]));
			$lider = $fila[3];
			$turno = $fila[4];
			$muelle = $fila[5];
			$vehiculo = $fila[6];
			$canal = $fila[7];
			$procedencia = $fila[8];
			$destino = $fila[9];
			$tras_rem = $fila[10] == "" ? "NO APLICA" : utf8_decode($fila[10]);
			$transporteS = $fila[11] == "" ? "NO APLICA" : utf8_decode($fila[11]);
			$e1 = date("H:i",strtotime($fila[12]));
			$e2 = date("H:i",strtotime($fila[13]));
			$e3 = date("H:i",strtotime($fila[14]));
			$e4 = date("H:i",strtotime($fila[15]));
			$toneladas = str_replace(".", ",", $fila[16]);
			$observaciones = $fila[17];
			$atencion = $fila[18];
			$placa = $fila[19];
			$carga = $fila[20];
			$estibas = $fila[21];
			$operario1 = $fila[22];
			$operario2 = $fila[23];
			$operario3 = $fila[24];
			$cajas = $fila[25];
			$clase = cambioEstado($estado);

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
						
			echo "<tr>";
				echo "<td style='text-align:center;$clase'>" . $estado . "</td>";
				echo "<td style='text-align:center'>" . $registro . "</td>";
				echo "<td>" . $lider . "</td>";
				echo "<td style='text-align:center'>" . $turno . "</td>";
				echo "<td style='text-align:center'>" . $muelle . "</td>";
				echo "<td>" . $atencion . "</td>";
				echo "<td>" . $vehiculo . "</td>";
				echo "<td style='text-align:center'>" . $placa . "</td>";
				echo "<td style='text-align:center'>" . $tras_rem . "</td>";
				echo "<td style='text-align:center'>" . $transporteS . "</td>";
				echo "<td>" . $procedencia . "</td>";
				echo "<td>" . $destino . "</td>";
				echo "<td>" . $canal . "</td>";
				echo "<td>" . $carga . "</td>";
				echo "<td style='text-align:center'>" . $estibas . "</td>";
				echo "<td style='text-align:center'>" . $toneladas . "</td>";
				echo "<td style='text-align:center'>" . $cajas . "</td>";
				echo "<td>" . $operario1 . "</td>";
				echo "<td>" . $operario2 . "</td>";
				echo "<td>" . $operario3 . "</td>";
				echo "<td style='text-align:center'>" . $e1 . "</td>";
				echo "<td style='text-align:center'>" . $e2 . "</td>";
				echo "<td style='text-align:center'>" . $e3 . "</td>";
				echo "<td style='text-align:center'>" . $e4 . "</td>";
				echo "<td style='text-align:center'>" . $tiempoDesCargue . "</td>";
				echo "<td style='text-align:center'>" . $tiempoAnden . "</td>";
				echo "<td style='text-align:center'>" . $tp . "</td>";
				echo "<td>" . $observaciones . "</td>";
			echo "</tr>";
			
		}

		function cambioEstado($e){

			if($e == "EN MUELLE"){ $clase = "background-color: #ff0000;color: #fff"; }
			if($e == "EN PROCESO DE DES/CARGUE"){ $clase = "background-color: #ff9900;color: #fff"; }
			if($e == "DES/CARGADO"){ $clase = "background-color: #ffff00;color: #666"; }
			if($e == "SALIDA DE MUELLE"){ $clase = "background-color: #00ff00;color: #666"; }

			return $clase;

		}

	?>
</table>


