<?php 

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = $_SESSION["url_base"];

if(!isset($id) || ($tipo != "ADMINISTRADOR" && $tipo != "PROCESO" && $tipo != "CLIENTE" && $tipo != "TV")){
	
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

include "../conexion.php";

$sql = "SELECT * 
		FROM muelles
		WHERE sw=1";
$resultado = $conexion->query($sql);

if($resultado == true){

	while($fila = $resultado->fetch_assoc()){

		$muelle = $fila["muelle"];
		$sql1 = "SELECT f.id, f.estado, f.registro, f.e1, f.e2, f.e3, f.e4, c.canal, p.procedencia, d.destino, v.vehiculo, f.vehiculo, v.e1, v.e2, v.e3, f.placa, f.transporteS
				 FROM procesos AS f, procedencias AS p, destinos AS d, vehiculos AS v, muelles AS b, canales AS c
				 WHERE f.sw=1 AND f.procedencia=p.id AND f.destino=d.id AND f.vehiculo=v.id AND f.muelle=b.muelle AND f.canal=c.id AND b.muelle='$muelle' AND f.estado<>'SALIDA DE MUELLE'";

		$resultado1 = $conexion->query($sql1);
		$fila1 = $resultado1->fetch_array();		

		if($resultado1 == true){

			if($resultado1->num_rows > 0){

				$estado = $fila1[1];
				$registro = $fila1[2];
				$e1 = $fila1[3];
				$e2 = $fila1[4];
				$e3 = $fila1[5];
				$e4 = $fila1[6];
				$canal = $fila1[7];
				$procedencia = $fila1[8];
				$destino = $fila1[9];
				$vehiculo = $fila1[10];
				$vehiculoID = $fila1[11];
				$maxe1 = $fila1[12];
				$maxe2 = $fila1[13];
				$maxe3 = $fila1[14];
				$placa = $fila1[15];
				$transporteS = $fila1[16];

				$clase = "estado0";
				
				if($estado == "EN MUELLE"){ $clase = "estado1"; $einicio = $e1; $emax = $maxe1; $festado = 1; }
				if($estado == "EN PROCESO DE DES/CARGUE"){ $clase = "estado2"; $einicio = $e2; $emax = $maxe2; $festado = 2; }
				if($estado == "DES/CARGADO"){ $clase = "estado3"; $einicio = $e3; $emax = $maxe3; $festado = 3; }

				echo "<div class='bahias'>";
					echo "<a id='anclaPantallaB$muelle' class='$clase'>$muelle</a>";
					echo "<span id='finicioPantallaB$muelle' style='display:none'>$e1</span>";	
					echo "<span id='festadoPantallaB$muelle' style='display:none'>$festado</span>";	
					echo "<span id='einicioPantallaB$muelle' style='display:none'>$einicio</span>";	
					echo "<span id='emaxPantallaB$muelle' style='display:none'>$emax</span>";	
					echo "<span id='ecronoPantallaB$muelle' style='display:none'></span>";	
					echo "<span id='fcronoPantallaB$muelle'></span>";	
					echo "<span>P: $placa</span>";

					$title = "";

					if(strlen($canal) > 13){
						
						$title = $canal;
						$canal = str_replace("Á","1",$canal);
						$canal = str_replace("É","2",$canal);
						$canal = str_replace("Í","3",$canal);
						$canal = str_replace("Ó","4",$canal);
						$canal = str_replace("Ú","5",$canal);
						$canal = substr($canal, 0, 13);	
						$canal = str_replace("1","Á",$canal);
						$canal = str_replace("2","É",$canal);
						$canal = str_replace("3","Í",$canal);
						$canal = str_replace("4","Ó",$canal);
						$canal = str_replace("5","Ú",$canal);					
						
					}

					echo "<span title='$title'>C: $canal</span>";	
					echo "<span>T: $transporteS</span>";	
					echo "<span>D: $destino</span>";	
					echo "<span>&nbsp</span>";					
				echo "</div>";
				echo "<script>timerPantalla($muelle);</script>";

			} else{

				echo "<div class='bahias'>";
					echo "<a class='estado0'>$muelle</a>";
					echo "<span>&nbsp</span>";	
					echo "<span>&nbsp</span>";	
					echo "<span>&nbsp</span>";
					echo "<span>&nbsp</span>";	
					echo "<span>&nbsp</span>";
					echo "<span>&nbsp</span>";									
				echo "</div>";

			}
		}
	}	

	$resultado->free();

} else{
	echo "Error al agregar muelles: " . $conexion->error;
}

$conexion->close();

?>