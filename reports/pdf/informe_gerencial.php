<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$nombre = $_SESSION["nombre"];
$correo = $_SESSION["correo"];

if(!isset($id) || ($tipo != "ADMINISTRADOR" && $tipo != "BASÍCO" && $tipo != "FLETEO" && $tipo != "CLIENTE")){
	
	header("Location:https://wms.contactamos.co/login.php");
	
	die();
	
}

$inicio = $_POST["inicio"];
$fin = $_POST["fin"];
$turno = $_POST["turno"];
$criterios = "";
$tablaTP = "";
$tablaCausas = "";

if($inicio != ""){ $criterios .= "AND p.registro>='$inicio'"; }
if($fin != ""){ $criterios .= "AND p.registro<='$fin'"; }
if($turno != ""){ $criterios .= "AND t.turno='$turno'"; }

include "../../conexion.php";

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<table style="font-size:15px">
	<tr>
		<td colspan="7" style="text-align: center;font-size: 27px;font-weight: bold;color:#0f9d58">CONTACTAMOS OUTSOURCING S.A.S.</td>
	</tr>
	<tr>
		<td colspan="7" style="text-align: center;font-size: 21px;font-weight: bold;color:#0f9d58">INFORME GERENCIAL - COMERCIAL NUTRESA BOGOTÁ</td>
	</tr>
	<tr>
		<td colspan="7">&nbsp</td>
	</tr>
	<tr>
		<td style="font-weight: bold">FECHA INICIO:</td>
		<td><?php if($inicio == ""){ echo ""; } else{ echo date("d/m/Y",strtotime($inicio)); } ?></td>
		<td colspan="5"></td>
	</tr>
	<tr>
		<td style="font-weight: bold">FECHA FIN:</td>
		<td><?php if($fin == ""){ echo ""; } else{ echo date("d/m/Y",strtotime($fin)); } ?></td>
		<td colspan="5"></td>
	</tr>
	<tr>
		<td style="font-weight: bold">TURNO:</td>
		<td><?php echo $turno; ?></td>
		<td colspan="5"></td>
	</tr>
	<tr>
		<td colspan="7">&nbsp</td>
	</tr>
	<tr>
		<th style="width: 280px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Canal / Negocio</th>
		<th style="width: 180px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Vehículos descargados</th>
		<th style="width: 180px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Vehículos cargados</th>
		<th style="width: 180px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Vehículos total</th>
		<th style="width: 180px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Tiempo de atención - Descargue (min/veh)</th>
		<th style="width: 180px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Tiempo de atención - Cargue (min/veh)</th>
		<th style="width: 180px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Tiempo de atención - En muelle (min/veh)</th>
		<th style="width: 180px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Estibas movidas</th>
		<th style="width: 180px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Toneladas Descargue</th>
		<th style="width: 180px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Productividad Descargue (ton/oper/hora)</th>
		<th style="width: 180px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Toneladas Cargue</th>
		<th style="width: 180px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Productividad Cargue (ton/oper/hora)</th>
		<th style="width: 180px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Cajas Descargue</th>
		<th style="width: 180px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Productividad Descargue (cajas/oper/hora)</th>
		<th style="width: 180px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Cajas Cargue</th>
		<th style="width: 180px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Productividad Cargue (cajas/oper/hora)</th>
	</tr>
	<?php 

		//TOTALES
		$vehiculos_total = 0;
		$tiempoCD_total = 0;
		$tiempoMuelle_total = 0;
		$estibas_total = 0;
		$toneladas_total = 0;
		$operarios_total = 0;

		$sql1 = "SELECT c.id, c.canal
				 FROM canales AS c
				 WHERE c.sw=1
				 ORDER BY c.canal";

		$resultado1 = $conexion->query($sql1);

		while($fila1 = $resultado1->fetch_array()){

			$id_canal = $fila1[0];
			$canal = $fila1[1];
			$vehiculosDescargue = 0;
			$vehiculosCargue = 0;
			$vehiculosTotal = 0;
			$tiempoDescargue = 0;
			$tiempoCargue = 0;
			$tiempoMuelle = 0;
			$estibas = 0;
			$toneladasDescargue = 0;
			$toneladasCargue = 0;
			$toneladasTotal = 0;
			$cajasDescargue = 0;
			$cajasCargues = 0;
			$cajasTotal = 0;
			$operariosDescargue = 0;
			$operariosCargue = 0;
			$operariosTotal = 0;

			$sql2 = "SELECT p.id, p.atencion, p.operario1, p.operario2, p.operario3, p.e1, p.e2, p.e3, p.e4, p.estibas, p.toneladas
					 FROM procesos AS p, turnos AS t
					 WHERE p.sw=1 AND p.estado='SALIDA DE MUELLE' AND p.turno=t.id AND p.canal='$id_canal' $criterios";

			$resultado2 = $conexion->query($sql2);

			while($fila2 = $resultado2->fetch_array()){

				$id_proceso = $fila2[0];
				$atencion = $fila2[1];
				$operario1 = $fila2[2];
				$operario2 = $fila2[3];
				$operario3 = $fila2[4];
				$e1 = $fila2[5];
				$e2 = $fila2[6];
				$e3 = $fila2[7];
				$e4 = $fila2[8];
				$estibas += $fila2[9];
				$toneladas += $fila2[10]/1000;				

				if($operario1 != ""){ $operarios++; }
				if($operario2 != ""){ $operarios++; }
				if($operario3 != ""){ $operarios++; }

				//TIEMPO DES/CARGUE

				if($atencion == "DESCARGUE"){

					$start_date = new DateTime($e2);
					$since_start = $start_date->diff(new DateTime($e3));
					$horas = $since_start->h;
					$minutos =  $since_start->i;
					$tiempoDescargue += $horas*60 + $minutos;

					$vehiculosDescargue++;
						
				}

				if($atencion == "CARGUE"){

					$start_date = new DateTime($e2);
					$since_start = $start_date->diff(new DateTime($e3));
					$horas = $since_start->h;
					$minutos =  $since_start->i;
					$tiempoCargue += $horas*60 + $minutos;

					$vehiculosCargue++;
						
				}

				//TIEMPO MUELLE
				$start_date = new DateTime($e1);
				$since_start = $start_date->diff(new DateTime($e4));
				$horas = $since_start->h;
				$minutos =  $since_start->i;
				$tiempoMuelle += $horas*60 + $minutos;

				$vehiculos++;

			}

			if($vehiculos > 0){ 

				echo "<tr style='height:32px'>";
					echo "<td style='border:1px solid #000;background-color:#eee'>" . $canal . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $vehiculoDescargue . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $vehiculosCargue . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $vehiculosTotal . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($tiempoDescargue/$vehiculosDescargue,2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($tiempoCargue/$vehiculosCargue,2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($tiempoMuelle/$vehiculosTotal,2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $estibas . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($toneladas,2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($toneladas/$operarios/($tiempoDescargue/60),2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($toneladas/$operarios/($tiempoCargue/60),2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $cajas . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($cajas/$operarios/($tiempoDescargue/60),2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($cajas/$operarios/($tiempoCargue/60),2)) . "</td>";
				echo "</tr>";

				$vehiculos_total += $vehiculos;
				$tiempoCD_total += $tiempoCD;
				$tiempoMuelle_total += $tiempoMuelle;
				$estibas_total += $estibas;
				$toneladas_total += $toneladas;
				$operarios_total += $operarios;

			}
		}
	
	?>
	<tr>
		<td style="border:1px solid #000;background-color:#eee;text-align: center;font-weight: bold">TOTALES</td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo $vehiculos_total; ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($tiempoCD_total/$vehiculos_total,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($tiempoMuelle_total/$vehiculos_total,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo $estibas_total; ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($toneladas_total,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($toneladas_total/$operarios_total/($tiempoCD_total/60),2)); ?></td>
	</tr>
</table>
<p style="text-align:right;font-size:9px">Creado por <?php echo $nombre . " [" . $correo . "]"; ?> - WMS Contactamos v2.0</p>


