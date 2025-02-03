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

$limite = $_POST["limite"];
$pagina = $_POST["pagina"];
$offset = $limite*$pagina - $limite;
$consulta = $_POST["consulta"];

if($consulta == ""){
	
	$sql = "SELECT f.id, f.estado, f.registro, l.nick, t.turno, b.muelle, v.vehiculo, c.canal, p.procedencia, d.destino, f.tras_rem, f.transporteS, f.e1, f.e2, f.e3, f.e4, f.toneladas, f.observaciones, f.atencion, f.placa, f.carga, f.estibas, f.operario1, f.operario2, f.operario3, f.cajas
			FROM procesos AS f, lideres AS l, vehiculos AS v, turnos AS t, muelles AS b, procedencias AS p, destinos AS d, canales AS c
			WHERE f.sw=1 AND f.lider=l.id AND f.turno=t.id AND f.muelle=b.muelle AND f.vehiculo=v.id AND f.procedencia=p.id AND f.destino=d.id AND f.canal=c.id
			ORDER BY f.registro DESC, t.turno DESC, f.e1 DESC LIMIT $limite OFFSET $offset";
	
	var_dump($consulta);
} else{
	
	$sql = "SELECT f.id, f.estado, f.registro, l.nick, t.turno, b.muelle, v.vehiculo, c.canal, p.procedencia, d.destino, f.tras_rem, f.transporteS, f.e1, f.e2, f.e3, f.e4, f.toneladas, f.observaciones, f.atencion, f.placa, f.carga, f.estibas, f.operario1, f.operario2, f.operario3, f.cajas
			FROM procesos AS f, lideres AS l, vehiculos AS v, turnos AS t, muelles AS b, procedencias AS p, destinos AS d, canales AS c
			WHERE f.sw=1 AND f.lider=l.id AND f.turno=t.id AND f.muelle=b.muelle AND f.vehiculo=v.id AND f.procedencia=p.id AND f.destino=d.id AND f.canal=c.id	
			AND (
				POSITION('$consulta' IN f.estado) OR
				POSITION('$consulta' IN f.registro) OR
				POSITION('$consulta' IN l.nick) OR
				POSITION('$consulta' IN t.turno) OR
				POSITION('$consulta' IN f.muelle) OR
				POSITION('$consulta' IN f.atencion) OR
				POSITION('$consulta' IN v.vehiculo) OR
				POSITION('$consulta' IN f.placa) OR
				POSITION('$consulta' IN p.procedencia) OR
				POSITION('$consulta' IN d.destino) OR
				POSITION('$consulta' IN f.tras_rem) OR
				POSITION('$consulta' IN f.transporteS) OR
				POSITION('$consulta' IN c.canal) OR
				POSITION('$consulta' IN f.carga) OR
				POSITION('$consulta' IN f.estibas) OR
				POSITION('$consulta' IN f.toneladas) OR
				POSITION('$consulta' IN f.cajas) OR
				POSITION('$consulta' IN f.operario1) OR
				POSITION('$consulta' IN f.operario2) OR
				POSITION('$consulta' IN f.operario3) OR
				POSITION('$consulta' IN f.e1) OR
				POSITION('$consulta' IN f.e2) OR
				POSITION('$consulta' IN f.e3) OR
				POSITION('$consulta' IN f.e4) OR
				POSITION('$consulta' IN f.observaciones)
			)
			ORDER BY f.registro DESC, t.turno DESC, f.e1 DESC LIMIT $limite OFFSET $offset";
	
}

$resultado = $conexion->query($sql);
$conteo = 0;

if($resultado == true){

	while($fila = $resultado->fetch_array()){

		++$conteo;
		
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
		$tras_rem = $fila[10] == "" ? "NO APLICA" : $fila[10];
		$transporteS = $fila[11] == "" ? "NO APLICA" : $fila[11];
		$e1 = date("H:i",strtotime($fila[12]));
		$e2 = date("H:i",strtotime($fila[13]));
		$e3 = date("H:i",strtotime($fila[14]));
		$e4 = date("H:i",strtotime($fila[15]));
		$toneladas = number_format($fila[16], 2, ",", ".");
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

		echo "<tr class='fila'>";	
			if($tipo != "CLIENTE"){	

				echo "<td class='left'>";
				if($estado == "DES/CARGADO" || $estado == "SALIDA DE MUELLE"){

					$start_date = new DateTime($fila[13]);
					$since_start = $start_date->diff(new DateTime($fila[14]));
					$horas = $since_start->h;
					$minutos =  $since_start->i;
					$tiempoDesCargue = $horas*60 + $minutos;
			
				} else{

					$tiempoDesCargue = "...";
			
				}	

				if($estado == "SALIDA DE MUELLE"){
					
					echo "<a href='Javascript:void()' class='$clase'>" . strtolower($estado) . "</a>";

					$start_date = new DateTime($fila[12]);
					$since_start = $start_date->diff(new DateTime($fila[15]));
					$horas = $since_start->h;
					$minutos =  $since_start->i;
					$tiempoAnden = $horas*60 + $minutos;
			
				} else{
			
					echo "<a href='Javascript:void()' class='$clase' data-id='$fila[0]' onClick='editar(this)'>" . strtolower($estado) . "</a>";

					$tiempoAnden = "...";
			
				}
				echo "</td>";

			} else{
				
				echo "<td><a class='$clase'>" . strtolower($estado) . "</a></td>";
				
			}
			echo "<td>" . $registro . "</td>";
			echo "<td class='left'>" . $lider . "</td>";
			echo "<td>" . $turno . "</td>";
			echo "<td>" . $muelle . "</td>";
			echo "<td class='left'>" . $atencion . "</td>";
			echo "<td>" . $vehiculo . "</td>";
			echo "<td>" . $placa . "</td>";
			echo "<td>" . $tras_rem . "</td>";
			echo "<td>" . $transporteS . "</td>";
			echo "<td class='left'>" . $procedencia . "</td>";
			echo "<td class='left'>" . $destino . "</td>";
			echo "<td class='left'>" . $canal . "</td>";
			echo "<td>" . $carga . "</td>";
			echo "<td>" . $estibas . "</td>";
			echo "<td class='right'>" . $toneladas . "</td>";
			echo "<td>" . $cajas . "</td>";
			echo "<td class='left'>" . $operario1 . "</td>";
			echo "<td class='left'>" . $operario2 . "</td>";
			echo "<td class='left'>" . $operario3 . "</td>";
			echo "<td>" . $e1 . "</td>";
			echo "<td>" . $e2 . "</td>";
			echo "<td>" . $e3 . "</td>";
			echo "<td>" . $e4 . "</td>";
			echo "<td>" . $tiempoDesCargue . "</td>";
			echo "<td>" . $tiempoAnden . "</td>";
			echo "<td>" . $tp . "</td>";
			echo "<td class='left' style='max-width:300px'>" . $observaciones . "</td>";
		
			if($tipo == "ADMINISTRADOR"){
				
				echo "<td>";
					echo "<a href='Javascript:void()' data-id='$fila[0]' onClick='editar(this)' class='edit'><i class='fas fa-pen'></i>Editar</a>";
					echo "<a href='Javascript:void()' data-id='$fila[0]' data-elemento='$registro: $fila[7] en B$fila[5] por $fila[3]' data-tabla='procesos' onClick='eliminar(this)' class='delete'><i class='fas fa-trash'></i>Eliminar</a>";
				echo "</td>";
				
			} else{
				
				echo "<td></td>";
				
			}
		echo "</tr>";
	}	

	$resultado->free();

} else{
	echo "Error al cargar procesos: " . $conexion->error;
}

$conexion->close();

function cambioEstado($e){

	$clase = "estado0";

	if($e == "EN MUELLE"){ $clase = "estado1"; }
	if($e == "EN PROCESO DE DES/CARGUE"){ $clase = "estado2"; }
	if($e == "DES/CARGADO"){ $clase = "estado3"; }
	if($e == "SALIDA DE MUELLE"){ $clase = "estado4"; }

	return $clase;

}

?>