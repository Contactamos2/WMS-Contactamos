<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = $_SESSION["url_base"];

if(!isset($id) || ($tipo != "ADMINISTRADOR" && $tipo != "PROCESO")){
	
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

include "../conexion.php";

$usuario = $_SESSION["usuario"];
$idREG = $_POST["id"];
$registro = $_POST["registro"];
$lider = $_POST["lider"];
$turno = $_POST["turno"];
$muelle = $_POST["muelle"];
$atencion = $_POST["atencion"];
$vehiculo = $_POST["vehiculo"];
$placa = $_POST["placa"];
$procedencia = $_POST["procedencia"];
$destino = $_POST["destino"];
$tras_rem = trim($_POST["tras_rem"]);
$transporteS = trim($_POST["transporteS"]);
$canal = $_POST["canal"];
$carga = $_POST["carga"];
$estibas = $_POST["estibas"];
$toneladas = $_POST["toneladas"];
$cajas = $_POST["cajas"];
$operario1 = $_POST["operario1"];
$operario2 = $_POST["operario2"];
$operario3 = $_POST["operario3"];
$e1 = $_POST["e1"];
$e2 = $_POST["e2"];
$e3 = $_POST["e3"];
$e4 = $_POST["e4"];
$observaciones = $_POST["observaciones"];
$sms = "";

if($usuario != "" && $muelle != "" && $registro != "" && $lider != "" && $turno != "" && $vehiculo != "" && $placa != "" && $canal != "" && $carga != "" && (($atencion == "DESCARGUE Y CARGUE" && $tras_rem != "" && $transporteS != "" && $destino != "" && $procedencia != "") || ($atencion == "DESCARGUE" && $tras_rem != "" && $procedencia != "") || ($atencion == "CARGUE" && $transporteS != "" && $destino != "")) && $e1 != ""){

	if($e4 == "" || ($operario1 != "" && $e2 != "" && $e3 != "" && $e4 != "" && $estibas != "" && $toneladas != "" && $cajas > 0)){

		if($procedencia == ""){ $procedencia = 69; }
		if($destino == ""){ $destino = 53; }

		$estado = "EN MUELLE";

		if($e2 != ""){ $estado = "EN PROCESO DE DES/CARGUE"; } else{ $e2 = "0000-00-00 00:00:00"; } 
		if($e3 != ""){ $estado = "DES/CARGADO"; } else{ $e3 = "0000-00-00 00:00:00"; }
		if($e4 != ""){ $estado = "SALIDA DE MUELLE"; } else{ $e4 = "0000-00-00 00:00:00"; }

		$sqlB = "SELECT f.estado
			 	 FROM procesos AS f, muelles AS b
			 	 WHERE f.sw=1 AND f.muelle=b.id AND b.muelle='$muelle' AND f.estado<>'SALIDA DE MUELLE'";
		$resultadoB = $conexion->query($sqlB);
		$filasB = $resultadoB->num_rows;
		$sw = false;
		
		if($idREG == ""){

			if($filasB == 0){

				$sql = "INSERT INTO procesos(estado, registro, lider, turno, muelle, atencion, vehiculo, placa, procedencia, destino, tras_rem, transporteS, canal, carga, estibas, toneladas, cajas, operario1, operario2, operario3, e1, e2, e3, e4, observaciones, usuario)
						VALUES ('$estado', '$registro', '$lider', '$turno', '$muelle', '$atencion', '$vehiculo', '$placa', '$procedencia', '$destino', '$tras_rem', '$transporteS', '$canal', '$carga', '$estibas', '$toneladas', '$cajas', '$operario1', '$operario2', '$operario3', '$e1', '$e2', '$e3', '$e4', '$observaciones', '$usuario')";

				$sms = "Proceso creado exitosamente.";
				$sw = true;

			} else{

				$sms = "El Muelle #" . $muelle . " ya se encuentra ocupado.";

			}

		} else{

			if($filasB == 1 || ($filasB >= 0 && $tipo == "ADMINISTRADOR")){

				$sql = "UPDATE procesos
						SET estado='$estado', registro='$registro', lider='$lider', turno='$turno', muelle='$muelle', atencion='$atencion', vehiculo='$vehiculo', placa='$placa', procedencia='$procedencia', destino='$destino', tras_rem='$tras_rem', transporteS='$transporteS', canal='$canal', carga='$carga', estibas='$estibas', toneladas='$toneladas', cajas='$cajas', operario1='$operario1', operario2='$operario2', operario3='$operario3', e1='$e1', e2='$e2', e3='$e3', e4='$e4', observaciones='$observaciones', usuario='$usuario'
						WHERE id='$idREG'";

				$sms = "Proceso actualizado exitosamente.";
				$sw = true;

			} else{

				if($filasB > 1){

					$sms = "Error: Se encuentran dos procesos abiertos en el Muelle #" . $muelle;

				} else{

					$sms = "El proceso ya ha sido cerrado, solo puede ser gestionado por un Administrador.";

				}
			}
		}

		$resultado = $conexion->query($sql);

		if($sw){

			if($resultado === true) {

				echo $sms;

			} else{

				echo "El proceso no pudo ser completado.<br><br>" . $conexion->error;

			}
		} else{

			echo $sms;

		}
	} else{

		echo "Para cerrar el proceso debe completar volúmenes, operario(s) y horas por etapa.";

	}
} else{

	echo "Completar campos obligatorios e internar nuevamente.";

}

$conexion->close();

?>