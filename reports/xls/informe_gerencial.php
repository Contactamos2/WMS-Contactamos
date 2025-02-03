<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$nombre = $_SESSION["nombre"];
$correo = $_SESSION["correo"];

if(!isset($id) || ($tipo != "ADMINISTRADOR" && $tipo != "BÁSICO" && $tipo != "FLETEO" && $tipo != "CLIENTE")){
	
	header("Location:https://wms.contactamos.co/login.php");
	
	die();
	
}

header("Content-Type: application/vnd.ms-excel charset=utf-8");
header("Content-Disposition: attachment; filename=Informe Gerencial.xls");

$inicio = $_GET["inicio"];
$fin = $_GET["fin"];
$turno = $_GET["turno"];
$criterios = "";
$tablaTP = "";
$tablaCausas = "";

if(isset($inicio) && isset($fin) && isset($turno)){

	if($inicio != ""){ $criterios .= " AND p.registro>='$inicio'"; }
	if($fin != ""){ $criterios .= " AND p.registro<='$fin'"; }
	if($turno != ""){ $criterios .= " AND t.turno='$turno'"; }

} else{

	header("Location:https://wms.contactamos.co/login.php");
	
	die();

}

include "../../conexion.php";

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<table style="font-size:20px">
	<tr>
		<td colspan="17" style="text-align: center;font-size: 32px;font-weight: bold;color:#0f9d58">CONTACTAMOS OUTSOURCING S.A.S.</td>
	</tr>
	<tr>
		<td colspan="17" style="text-align: center;font-size: 26px;font-weight: bold;color:#0f9d58">INFORME GERENCIAL - COMERCIAL NUTRESA BOGOTÁ</td>
	</tr>
	<tr>
		<td colspan="17"></td>
	</tr>
	<tr>
		<td style="font-weight: bold">FECHA INICIO:</td>
		<td><?php echo $inicio; ?></td>
		<td colspan="15"></td>
	</tr>
	<tr>
		<td style="font-weight: bold">FECHA FIN:</td>
		<td><?php echo $fin; ?></td>
		<td colspan="15"></td>
	</tr>
	<tr>
		<td style="font-weight: bold">TURNO:</td>
		<td><?php echo $turno; ?></td>
		<td colspan="15"></td>
	</tr>
	<tr>
		<td colspan="17"></td>
	</tr>
	<tr>
		<th style="width: 280px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Canal / Negocio</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Veh&iacute;culos descargados</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Veh&iacute;culos cargados</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Veh&iacute;culos total</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#A9D08E;color:#000">Tiempo de atenci&oacute;n - Descargue (min/veh)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#A9D08E;color:#000">Tiempo de atenci&oacute;n - Cargue (min/veh)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#92D050;color:#000">Tiempo de atenci&oacute;n - General (min/veh)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#92D050;color:#000">Tiempo en Muelle (min/veh)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#595959;color:#fff">Estibas movidas</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#2F75B5;color:#fff">Toneladas descargadas</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#2F75B5;color:#fff">Productividad Descargue (ton/hora)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#2F75B5;color:#fff">Toneladas cargadas</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#2F75B5;color:#fff">Productividad Cargue (ton/hora)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#CC0000;color:#fff">Cajas descargadas</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#CC0000;color:#fff">Productividad Descargue (cajas/hora)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#CC0000;color:#fff">Cajas cargadas</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#CC0000;color:#fff">Productividad Cargue (cajas/hora)</th>
	</tr>
	<?php 

		//TOTALES
		$vehiculosDescargueTotal = 0;
		$vehiculosCargueTotal = 0;
		$vehiculosTotalTotal = 0;

		$tiempoDescargueTotal = 0;
		$tiempoCargueTotal = 0;
		$tiempoGeneralTotal = 0;
		$tiempoMuelleTotal = 0;

		$operariosDescargueTotal = 0;
		$operariosCargueTotal = 0;

		$estibasTotal = 0;

		$toneladasDescargueTotal = 0;
		$toneladasCargueTotal = 0;
		
		$cajasDescargueTotal = 0;
		$cajasCargueTotal = 0;

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
			$tiempoGeneral = 0;
			$tiempoMuelle = 0;
			$estibas = 0;
			$toneladasDescargue = 0;
			$toneladasCargue = 0;
			$toneladasTotal = 0;
			$cajasDescargue = 0;
			$cajasCargue = 0;
			$cajasTotal = 0;
			$operariosDescargue = 0;
			$operariosCargue = 0;
			$operariosTotal = 0;

			$sql2 = "SELECT p.id, p.atencion, p.operario1, p.operario2, p.operario3, p.e1, p.e2, p.e3, p.e4, p.estibas, p.toneladas, p.cajas
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

				$start_date = new DateTime($e2);
				$since_start = $start_date->diff(new DateTime($e3));
				$horas = $since_start->h;
				$minutos =  $since_start->i;

				//TIEMPO DES/CARGUE

				if($atencion == "DESCARGUE"){

					$tiempoDescargue += $horas*60 + $minutos;					
					$toneladasDescargue += $fila2[10]/1000;	
					$cajasDescargue += $fila2[11];	

					$vehiculosDescargue++;

					if($operario1 != ""){ $operariosDescargue++; }
					if($operario2 != ""){ $operariosDescargue++; }
					if($operario3 != ""){ $operariosDescargue++; }
						
				}

				if($atencion == "CARGUE"){

					$tiempoCargue += $horas*60 + $minutos;					
					$toneladasCargue += $fila2[10]/1000;
					$cajasCargue += $fila2[11];		

					$vehiculosCargue++;

					if($operario1 != ""){ $operariosCargue++; }
					if($operario2 != ""){ $operariosCargue++; }
					if($operario3 != ""){ $operariosCargue++; }
						
				}

				$tiempoGeneral += $horas*60 + $minutos;

				//TIEMPO MUELLE
				$start_date = new DateTime($e1);
				$since_start = $start_date->diff(new DateTime($e4));
				$horas = $since_start->h;
				$minutos =  $since_start->i;

				$tiempoMuelle += $horas*60 + $minutos;
				$toneladasTotal += $fila2[10]/1000;
				$cajasTotal += $fila2[11];

				$vehiculosTotal++;
				$operariosTotal++;

			}

			if($vehiculosTotal > 0){ 
				
				$tiempoDescargueR = $tiempoDescargue ? str_replace(".",",",round($tiempoDescargue/$vehiculosDescargue,2)) : "";
				$tiempoCargueR = $tiempoCargue ? str_replace(".",",",round($tiempoCargue/$vehiculosCargue,2)) : "";
				$toneladasDescargueR = $toneladasDescargue ? str_replace(".",",",round($toneladasDescargue/($tiempoDescargue/60),2)) : "";
				$toneladasCargueR = $toneladasCargue ?  str_replace(".",",",round($toneladasCargue/($tiempoCargue/60),2)) : "";
				$cajasDescargueR = $cajasDescargue ? str_replace(".",",",round($cajasDescargue/($tiempoDescargue/60),2)) : "";
				$cajasCargueR = $cajasCargue ? str_replace(".",",",round($cajasCargue/($tiempoCargue/60),2)) : "";

				echo "<tr style='height:32px'>";
					echo "<td style='border:1px solid #000;background-color:#eee'>" . $canal . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $vehiculosDescargue . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $vehiculosCargue . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $vehiculosTotal . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $tiempoDescargueR . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $tiempoCargueR . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($tiempoGeneral/$vehiculosTotal,2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($tiempoMuelle/$vehiculosTotal,2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $estibas . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($toneladasDescargue,2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $toneladasDescargueR . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($toneladasCargue,2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $toneladasCargueR . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $cajasDescargue . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $cajasDescargueR . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $cajasCargue . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $cajasCargueR . "</td>";
				echo "</tr>";

				$vehiculosDescargueTotal += $vehiculosDescargue;
				$vehiculosCargueTotal += $vehiculosCargue;
				$vehiculosTotalTotal += $vehiculosTotal;

				$tiempoDescargueTotal += $tiempoDescargue;
				$tiempoCargueTotal += $tiempoCargue;
				$tiempoGeneralTotal += $tiempoGeneral;
				$tiempoMuelleTotal += $tiempoMuelle;

				$operariosDescargueTotal += $operariosDescargue;
				$operariosCargueTotal +=  $operariosCargue;

				$estibasTotal += $estibas;

				$toneladasDescargueTotal += $toneladasDescargue;
				$toneladasCargueTotal += $toneladasCargue;
				
				$cajasDescargueTotal += $cajasDescargue;
				$cajasCargueTotal += $cajasCargue;

			}
		}
	
	?>
	<tr>
		<td style="border:1px solid #000;background-color:#eee;text-align: center;font-weight: bold">TOTALES</td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo $vehiculosDescargueTotal; ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo $vehiculosCargueTotal; ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo $vehiculosTotalTotal; ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($tiempoDescargueTotal/$vehiculosDescargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($tiempoCargueTotal/$vehiculosCargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($tiempoGeneralTotal/$vehiculosTotalTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($tiempoMuelleTotal/$vehiculosTotalTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo $estibasTotal; ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($toneladasDescargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($toneladasDescargueTotal/($tiempoDescargueTotal/60),2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($toneladasCargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($toneladasCargueTotal/($tiempoCargueTotal/60),2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($cajasDescargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($cajasDescargueTotal/($tiempoDescargueTotal/60),2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($cajasCargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($cajasCargueTotal/($tiempoCargueTotal/60),2)); ?></td>
	</tr>
	<tr>
		<td colspan="17"></td>
	</tr>
	<tr>
		<td colspan="17"></td>
	</tr>
	<tr>
		<th style="width: 280px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Tipo de vehículo</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Veh&iacute;culos descargados</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Veh&iacute;culos cargados</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Veh&iacute;culos total</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#A9D08E;color:#000">Tiempo de atenci&oacute;n - Descargue (min/veh)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#A9D08E;color:#000">Tiempo de atenci&oacute;n - Cargue (min/veh)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#92D050;color:#000">Tiempo de atenci&oacute;n - General (min/veh)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#92D050;color:#000">Tiempo en Muelle (min/veh)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#595959;color:#fff">Estibas movidas</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#2F75B5;color:#fff">Toneladas descargadas</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#2F75B5;color:#fff">Productividad Descargue (ton/hora)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#2F75B5;color:#fff">Toneladas cargadas</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#2F75B5;color:#fff">Productividad Cargue (ton/hora)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#CC0000;color:#fff">Cajas descargadas</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#CC0000;color:#fff">Productividad Descargue (cajas/hora)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#CC0000;color:#fff">Cajas cargadas</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#CC0000;color:#fff">Productividad Cargue (cajas/hora)</th>
	</tr>
	<?php 

		//TOTALES
		$vehiculosDescargueTotal = 0;
		$vehiculosCargueTotal = 0;
		$vehiculosTotalTotal = 0;

		$tiempoDescargueTotal = 0;
		$tiempoCargueTotal = 0;
		$tiempoGeneralTotal = 0;
		$tiempoMuelleTotal = 0;

		$operariosDescargueTotal = 0;
		$operariosCargueTotal = 0;

		$estibasTotal = 0;

		$toneladasDescargueTotal = 0;
		$toneladasCargueTotal = 0;
		
		$cajasDescargueTotal = 0;
		$cajasCargueTotal = 0;

		$sql1 = "SELECT v.id, v.vehiculo
				 FROM vehiculos AS v
				 WHERE v.sw=1
				 ORDER BY v.vehiculo";

		$resultado1 = $conexion->query($sql1);

		while($fila1 = $resultado1->fetch_array()){

			$id_vehiculo = $fila1[0];
			$vehiculo = $fila1[1];
			$vehiculosDescargue = 0;
			$vehiculosCargue = 0;
			$vehiculosTotal = 0;
			$tiempoDescargue = 0;
			$tiempoCargue = 0;
			$tiempoGeneral = 0;
			$tiempoMuelle = 0;
			$estibas = 0;
			$toneladasDescargue = 0;
			$toneladasCargue = 0;
			$toneladasTotal = 0;
			$cajasDescargue = 0;
			$cajasCargue = 0;
			$cajasTotal = 0;
			$operariosDescargue = 0;
			$operariosCargue = 0;
			$operariosTotal = 0;

			$sql2 = "SELECT p.id, p.atencion, p.operario1, p.operario2, p.operario3, p.e1, p.e2, p.e3, p.e4, p.estibas, p.toneladas, p.cajas
					 FROM procesos AS p, turnos AS t
					 WHERE p.sw=1 AND p.estado='SALIDA DE MUELLE' AND p.turno=t.id AND p.vehiculo='$id_vehiculo' $criterios";

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

				$start_date = new DateTime($e2);
				$since_start = $start_date->diff(new DateTime($e3));
				$horas = $since_start->h;
				$minutos =  $since_start->i;

				//TIEMPO DES/CARGUE

				if($atencion == "DESCARGUE"){

					$tiempoDescargue += $horas*60 + $minutos;					
					$toneladasDescargue += $fila2[10]/1000;	
					$cajasDescargue += $fila2[11];	

					$vehiculosDescargue++;

					if($operario1 != ""){ $operariosDescargue++; }
					if($operario2 != ""){ $operariosDescargue++; }
					if($operario3 != ""){ $operariosDescargue++; }
						
				}

				if($atencion == "CARGUE"){

					$tiempoCargue += $horas*60 + $minutos;					
					$toneladasCargue += $fila2[10]/1000;
					$cajasCargue += $fila2[11];		

					$vehiculosCargue++;

					if($operario1 != ""){ $operariosCargue++; }
					if($operario2 != ""){ $operariosCargue++; }
					if($operario3 != ""){ $operariosCargue++; }
						
				}

				$tiempoGeneral += $horas*60 + $minutos;

				//TIEMPO MUELLE
				$start_date = new DateTime($e1);
				$since_start = $start_date->diff(new DateTime($e4));
				$horas = $since_start->h;
				$minutos =  $since_start->i;

				$tiempoMuelle += $horas*60 + $minutos;
				$toneladasTotal += $fila2[10]/1000;
				$cajasTotal += $fila2[11];

				$vehiculosTotal++;
				$operariosTotal++;

			}

			if($vehiculosTotal > 0){ 
				
				$tiempoDescargueR = $tiempoDescargue ? str_replace(".",",",round($tiempoDescargue/$vehiculosDescargue,2)) : "";
				$tiempoCargueR = $tiempoCargue ? str_replace(".",",",round($tiempoCargue/$vehiculosCargue,2)) : "";
				$toneladasDescargueR = $toneladasDescargue ? str_replace(".",",",round($toneladasDescargue/($tiempoDescargue/60),2)) : "";
				$toneladasCargueR = $toneladasCargue ?  str_replace(".",",",round($toneladasCargue/($tiempoCargue/60),2)) : "";
				$cajasDescargueR = $cajasDescargue ? str_replace(".",",",round($cajasDescargue/($tiempoDescargue/60),2)) : "";
				$cajasCargueR = $cajasCargue ? str_replace(".",",",round($cajasCargue/($tiempoCargue/60),2)) : "";

				echo "<tr style='height:32px'>";
					echo "<td style='border:1px solid #000;background-color:#eee'>" . $vehiculo . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $vehiculosDescargue . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $vehiculosCargue . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $vehiculosTotal . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $tiempoDescargueR . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $tiempoCargueR . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($tiempoGeneral/$vehiculosTotal,2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($tiempoMuelle/$vehiculosTotal,2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $estibas . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($toneladasDescargue,2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $toneladasDescargueR . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($toneladasCargue,2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $toneladasCargueR . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $cajasDescargue . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $cajasDescargueR . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $cajasCargue . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $cajasCargueR . "</td>";
				echo "</tr>";

				$vehiculosDescargueTotal += $vehiculosDescargue;
				$vehiculosCargueTotal += $vehiculosCargue;
				$vehiculosTotalTotal += $vehiculosTotal;

				$tiempoDescargueTotal += $tiempoDescargue;
				$tiempoCargueTotal += $tiempoCargue;
				$tiempoGeneralTotal += $tiempoGeneral;
				$tiempoMuelleTotal += $tiempoMuelle;

				$operariosDescargueTotal += $operariosDescargue;
				$operariosCargueTotal +=  $operariosCargue;

				$estibasTotal += $estibas;

				$toneladasDescargueTotal += $toneladasDescargue;
				$toneladasCargueTotal += $toneladasCargue;
				
				$cajasDescargueTotal += $cajasDescargue;
				$cajasCargueTotal += $cajasCargue;

			}
		}
	
	?>
	<tr>
		<td style="border:1px solid #000;background-color:#eee;text-align: center;font-weight: bold">TOTALES</td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo $vehiculosDescargueTotal; ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo $vehiculosCargueTotal; ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo $vehiculosTotalTotal; ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($tiempoDescargueTotal/$vehiculosDescargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($tiempoCargueTotal/$vehiculosCargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($tiempoGeneralTotal/$vehiculosTotalTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($tiempoMuelleTotal/$vehiculosTotalTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo $estibasTotal; ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($toneladasDescargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($toneladasDescargueTotal/($tiempoDescargueTotal/60),2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($toneladasCargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($toneladasCargueTotal/($tiempoCargueTotal/60),2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($cajasDescargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($cajasDescargueTotal/($tiempoDescargueTotal/60),2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($cajasCargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($cajasCargueTotal/($tiempoCargueTotal/60),2)); ?></td>
	</tr>
	<tr>
		<td colspan="17"></td>
	</tr>
	<tr>
		<td colspan="17"></td>
	</tr>
	<tr>
		<th style="width: 280px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Tipo de carga</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Veh&iacute;culos descargados</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Veh&iacute;culos cargados</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Veh&iacute;culos total</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#A9D08E;color:#000">Tiempo de atenci&oacute;n - Descargue (min/veh)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#A9D08E;color:#000">Tiempo de atenci&oacute;n - Cargue (min/veh)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#92D050;color:#000">Tiempo de atenci&oacute;n - General (min/veh)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#92D050;color:#000">Tiempo en Muelle (min/veh)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#595959;color:#fff">Estibas movidas</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#2F75B5;color:#fff">Toneladas descargadas</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#2F75B5;color:#fff">Productividad Descargue (ton/hora)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#2F75B5;color:#fff">Toneladas cargadas</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#2F75B5;color:#fff">Productividad Cargue (ton/hora)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#CC0000;color:#fff">Cajas descargadas</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#CC0000;color:#fff">Productividad Descargue (cajas/hora)</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#CC0000;color:#fff">Cajas cargadas</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#CC0000;color:#fff">Productividad Cargue (cajas/hora)</th>
	</tr>
	<?php 

		//TOTALES
		$vehiculosDescargueTotal = 0;
		$vehiculosCargueTotal = 0;
		$vehiculosTotalTotal = 0;

		$tiempoDescargueTotal = 0;
		$tiempoCargueTotal = 0;
		$tiempoGeneralTotal = 0;
		$tiempoMuelleTotal = 0;

		$operariosDescargueTotal = 0;
		$operariosCargueTotal = 0;

		$estibasTotal = 0;

		$toneladasDescargueTotal = 0;
		$toneladasCargueTotal = 0;
		
		$cajasDescargueTotal = 0;
		$cajasCargueTotal = 0;

		$opciones = ["ARRUME NEGRO", "ESTIBADO"];

		for($i = 0; $i < count($opciones); $i++){

			$carga = $opciones[$i];
			$vehiculosDescargue = 0;
			$vehiculosCargue = 0;
			$vehiculosTotal = 0;
			$tiempoDescargue = 0;
			$tiempoCargue = 0;
			$tiempoGeneral = 0;
			$tiempoMuelle = 0;
			$estibas = 0;
			$toneladasDescargue = 0;
			$toneladasCargue = 0;
			$toneladasTotal = 0;
			$cajasDescargue = 0;
			$cajasCargue = 0;
			$cajasTotal = 0;
			$operariosDescargue = 0;
			$operariosCargue = 0;
			$operariosTotal = 0;

			$sql2 = "SELECT p.id, p.atencion, p.operario1, p.operario2, p.operario3, p.e1, p.e2, p.e3, p.e4, p.estibas, p.toneladas, p.cajas
					 FROM procesos AS p, turnos AS t
					 WHERE p.sw=1 AND p.estado='SALIDA DE MUELLE' AND p.turno=t.id AND p.carga='$carga' $criterios";

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

				$start_date = new DateTime($e2);
				$since_start = $start_date->diff(new DateTime($e3));
				$horas = $since_start->h;
				$minutos =  $since_start->i;

				//TIEMPO DES/CARGUE

				if($atencion == "DESCARGUE"){

					$tiempoDescargue += $horas*60 + $minutos;					
					$toneladasDescargue += $fila2[10]/1000;	
					$cajasDescargue += $fila2[11];	

					$vehiculosDescargue++;

					if($operario1 != ""){ $operariosDescargue++; }
					if($operario2 != ""){ $operariosDescargue++; }
					if($operario3 != ""){ $operariosDescargue++; }
						
				}

				if($atencion == "CARGUE"){

					$tiempoCargue += $horas*60 + $minutos;					
					$toneladasCargue += $fila2[10]/1000;
					$cajasCargue += $fila2[11];		

					$vehiculosCargue++;

					if($operario1 != ""){ $operariosCargue++; }
					if($operario2 != ""){ $operariosCargue++; }
					if($operario3 != ""){ $operariosCargue++; }
						
				}

				$tiempoGeneral += $horas*60 + $minutos;

				//TIEMPO MUELLE
				$start_date = new DateTime($e1);
				$since_start = $start_date->diff(new DateTime($e4));
				$horas = $since_start->h;
				$minutos =  $since_start->i;

				$tiempoMuelle += $horas*60 + $minutos;
				$toneladasTotal += $fila2[10]/1000;
				$cajasTotal += $fila2[11];

				$vehiculosTotal++;
				$operariosTotal++;

			}

			if($vehiculosTotal > 0){ 
				
				$tiempoDescargueR = $tiempoDescargue ? str_replace(".",",",round($tiempoDescargue/$vehiculosDescargue,2)) : "";
				$tiempoCargueR = $tiempoCargue ? str_replace(".",",",round($tiempoCargue/$vehiculosCargue,2)) : "";
				$toneladasDescargueR = $toneladasDescargue ? str_replace(".",",",round($toneladasDescargue/($tiempoDescargue/60),2)) : "";
				$toneladasCargueR = $toneladasCargue ?  str_replace(".",",",round($toneladasCargue/($tiempoCargue/60),2)) : "";
				$cajasDescargueR = $cajasDescargue ? str_replace(".",",",round($cajasDescargue/($tiempoDescargue/60),2)) : "";
				$cajasCargueR = $cajasCargue ? str_replace(".",",",round($cajasCargue/($tiempoCargue/60),2)) : "";

				echo "<tr style='height:32px'>";
					echo "<td style='border:1px solid #000;background-color:#eee'>" . $carga . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $vehiculosDescargue . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $vehiculosCargue . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $vehiculosTotal . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $tiempoDescargueR . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $tiempoCargueR . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($tiempoGeneral/$vehiculosTotal,2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($tiempoMuelle/$vehiculosTotal,2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $estibas . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($toneladasDescargue,2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $toneladasDescargueR . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($toneladasCargue,2)) . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $toneladasCargueR . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $cajasDescargue . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $cajasDescargueR . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $cajasCargue . "</td>";
					echo "<td style='text-align:center;border:1px solid #000'>" . $cajasCargueR . "</td>";
				echo "</tr>";

				$vehiculosDescargueTotal += $vehiculosDescargue;
				$vehiculosCargueTotal += $vehiculosCargue;
				$vehiculosTotalTotal += $vehiculosTotal;

				$tiempoDescargueTotal += $tiempoDescargue;
				$tiempoCargueTotal += $tiempoCargue;
				$tiempoGeneralTotal += $tiempoGeneral;
				$tiempoMuelleTotal += $tiempoMuelle;

				$operariosDescargueTotal += $operariosDescargue;
				$operariosCargueTotal +=  $operariosCargue;

				$estibasTotal += $estibas;

				$toneladasDescargueTotal += $toneladasDescargue;
				$toneladasCargueTotal += $toneladasCargue;
				
				$cajasDescargueTotal += $cajasDescargue;
				$cajasCargueTotal += $cajasCargue;

			}
		}
	
	?>
	<tr>
		<td style="border:1px solid #000;background-color:#eee;text-align: center;font-weight: bold">TOTALES</td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo $vehiculosDescargueTotal; ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo $vehiculosCargueTotal; ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo $vehiculosTotalTotal; ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($tiempoDescargueTotal/$vehiculosDescargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($tiempoCargueTotal/$vehiculosCargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($tiempoGeneralTotal/$vehiculosTotalTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($tiempoMuelleTotal/$vehiculosTotalTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo $estibasTotal; ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($toneladasDescargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($toneladasDescargueTotal/($tiempoDescargueTotal/60),2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($toneladasCargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($toneladasCargueTotal/($tiempoCargueTotal/60),2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($cajasDescargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($cajasDescargueTotal/($tiempoDescargueTotal/60),2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($cajasCargueTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($cajasCargueTotal/($tiempoCargueTotal/60),2)); ?></td>
	</tr>
	<tr>
		<td colspan="17"></td>
	</tr>
	<tr>
		<td colspan="17"></td>
	</tr>
	<tr>
		<th style="width: 280px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Tipo de atención</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Capacidad instalada al mes</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Horas de atención efectiva</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Head count promedio</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Horas-hombre efectivas</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#595959;color:#fff">Ocupación</th>
	</tr>
	<?php 

	//TOTALES
	$tiempoTotal = 0;
	$operariosTotal = 0;
	$cuentaTotal = 0;
	$instalada = $turno ? 24.17*6.5*4 : 24.17*6.5*4*3;

	$opciones = ["CARGUE", "DESCARGUE"];

	for($i = 0; $i < count($opciones); $i++){

		$atencion = $opciones[$i];
		$tiempo = 0;
		$operarios = array();
		$registros = array();
		$cuenta = 0;

		$sql2 = "SELECT p.id, p.atencion, p.operario1, p.operario2, p.operario3, p.e1, p.e2, p.e3, p.e4, p.estibas, p.toneladas, p.cajas, p.registro
				 FROM procesos AS p, turnos AS t
				 WHERE p.sw=1 AND p.estado='SALIDA DE MUELLE' AND p.turno=t.id AND p.atencion='$atencion' $criterios";

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
			$registro = $fila2[12];

			$start_date = new DateTime($e2);
			$since_start = $start_date->diff(new DateTime($e3));
			$horas = $since_start->h;
			$minutos =  $since_start->i;

			$tiempo += $horas + $minutos/60;

			array_push($operarios, $operario1);
			array_push($operarios, $operario2);
			array_push($operarios, $operario3);

			array_push($registros, $registro);

			$cuenta++;

		}

		if($cuenta > 0){ 		

			$operarios = count(array_unique($operarios))/count(array_unique($registros));

			echo "<tr style='height:32px'>";
				echo "<td style='border:1px solid #000;background-color:#eee'>" . $atencion . "</td>";
				echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($instalada,2)) . "</td>";
				echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($tiempo,2)) . "</td>";
				echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($operarios,2)) . "</td>";
				echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round($tiempo*$operarios,2)) . "</td>";
				echo "<td style='text-align:center;border:1px solid #000'>" . str_replace(".",",",round((($tiempo*$operarios)/$instalada)*100,2)) . "%</td>";
			echo "</tr>";

			$tiempoTotal += $tiempo;
			$operariosTotal += $operarios;
			$cuentaTotal += $cuenta;

		}
	}
	
	?>
	<tr>
		<td style="border:1px solid #000;background-color:#eee;text-align: center;font-weight: bold">TOTALES</td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($instalada,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($tiempoTotal,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($operariosTotal/2,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round($tiempoTotal*$operariosTotal/2,2)); ?></td>
		<td style="text-align:center;border:1px solid #000;font-weight: bold"><?php echo str_replace(".",",",round((($tiempoTotal*$operariosTotal/2)/$instalada)*100,2)); ?>%</td>
	</tr>
	<tr>
		<td colspan="17"></td>
	</tr>
	<tr>
		<th style="width: 280px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">Productividad</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">ton/hora</th>
		<th style="width: 160px;text-align:center;border:1px solid #000;background-color:#0f9d48;color:#fff">cajas/horas</th>
	</tr>
	<tr>
		<td style="border:1px solid #000;background-color:#eee">CARGUE</td>
		<td style="text-align:center;border:1px solid #000"><?php echo str_replace(".",",",round($toneladasCargueTotal/($tiempoCargueTotal/60),2)); ?></td>
		<td style="text-align:center;border:1px solid #000"><?php echo str_replace(".",",",round($cajasCargueTotal/($tiempoCargueTotal/60),2)); ?></td>
	</tr>
	<tr>
		<td style="border:1px solid #000;background-color:#eee">DESCARGUE</td>
		<td style="text-align:center;border:1px solid #000"><?php echo str_replace(".",",",round($toneladasDescargueTotal/($tiempoDescargueTotal/60),2)); ?></td>
		<td style="text-align:center;border:1px solid #000"><?php echo str_replace(".",",",round($cajasDescargueTotal/($tiempoDescargueTotal/60),2)); ?></td>
	</tr>
	<tr>
		<td colspan="17"></td>
	</tr>
	<tr>
		<td colspan="17" style="text-align:right;font-size:14px">Creado por <?php echo $nombre . " [" . $correo . "]"; ?> - WMS Contactamos v2.0</td>
	</tr>
</table>
