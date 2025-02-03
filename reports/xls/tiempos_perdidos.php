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
header("Content-Disposition: attachment; filename=Tiempos perdidos.xls");

include "../../conexion.php";

$sql = "SELECT f.id, f.estado, f.registro, l.nick, t.turno, b.muelle, f.atencion, v.vehiculo, c.canal, f.placa
		FROM procesos AS f, lideres AS l, vehiculos AS v, turnos AS t, muelles AS b, canales AS c
		WHERE f.sw=1 AND f.estado='SALIDA DE MUELLE' AND f.lider=l.id AND f.turno=t.id AND f.muelle=b.muelle AND f.vehiculo=v.id AND f.canal=c.id $criterios
		ORDER BY f.registro ASC, f.turno ASC";

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
		<th>Canal</th>
		<th>Proceso responsable</th>
		<th>Causal</th>
		<th>Minutos</th>
	</tr>
	<?php 
		while($fila = $resultado->fetch_array()){

			$idProceso = $fila[0];
			$estado = $fila[1];
			$registro = $fila[2];
			$lider = $fila[3];
			$turno = $fila[4];
			$muelle = $fila[5];
			$atencion = $fila[6];
			$vehiculo = $fila[7];
			$canal = $fila[8];
			$placa = $fila[9];
			$clase = cambioEstado($estado);

			$sqlTP = "SELECT c.proceso, c.causal, t.minutos
					  FROM tiempos AS t, causales AS c
					  WHERE t.sw=1 AND t.causal=c.id AND t.proceso='$idProceso'
					  ORDER BY c.proceso ASC, c.causal ASC, t.minutos DESC";
			$resultadoTP = $conexion->query($sqlTP);	

			while($filaTP = $resultadoTP->fetch_array()){

				$proceso = $filaTP[0];
				$causal = $filaTP[1];
				$minutos = $filaTP[2];
						
				echo "<tr>";
					echo "<td style='text-align:center;$clase'>" . $estado . "</td>";
					echo "<td style='text-align:center'>" . date("d/m/Y",strtotime($registro)) . "</td>";
					echo "<td>" . $lider . "</td>";
					echo "<td style='text-align:center'>" . $turno . "</td>";
					echo "<td style='text-align:center'>" . $muelle . "</td>";
					echo "<td>" . $atencion . "</td>";
					echo "<td>" . $vehiculo . "</td>";
					echo "<td>" . $placa . "</td>";
					echo "<td>" . $canal . "</td>";
					echo "<td>" . $proceso . "</td>";
					echo "<td>" . $causal . "</td>";
					echo "<td style='text-align:center'>" . $minutos . "</td>";
				echo "</tr>";
				
			}
		}

		function cambioEstado($e){

			if($e == "EN BAHÍA"){ $clase = "background-color: #ff0000;color: #fff"; }
			if($e == "EN PROCESO DE DES/CARGUE"){ $clase = "background-color: #a4c2f4;color: #000"; }
			if($e == "DES/CARGADO"){ $clase = "background-color: #0000ff;color: #fff"; }
			if($e == "SALIDA DE MUELLE"){ $clase = "background-color: #00ff00;color: #000"; }

			return $clase;

		}
	?>
</table>


