<?php
//require '../vendor/autoload.php';

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = $_SESSION["url_base"];

// var_dump($_POST);
if (!isset($id) || ($tipo != "ADMINISTRADOR" && $tipo != "PROCESO")) {

	header("Location:" . $url_base . "login.php");

	die();
}
/ Crear un objeto DateTime a partir de la fecha recibida
    $date = DateTime::createFromFormat('Y-m-d', $fecha);
    
    // Formatear la fecha a otro formato, por ejemplo, 'd/m/Y'
    $fecha_formateada = $date->format('Y-m-d');
$fecha = $_POST["fecha"];
$agente = $_POST["agente"];
$No_zona = $_POST["No_zona"];
$No_transporte = $_POST["No_transporte"];
$responsable = $_POST["res_reporte"];
$id_materiales = $_POST["id_materiales"];
$placa = $_POST["placa"];
$faltante = $_POST["faltante"];
$sobrante = $_POST["sobrante"];
$cruce = $_POST["cruce"];
$averia = $_POST["averia"];
$tab121 = $_POST["tab_121"];
$tab402 = $_POST["tab_402"];
$tab405 = $_POST["tab_405"];
$tab401 = $_POST["tab_401"];
$cantidad = $_POST["cantidad"];
$valorTotal = $_POST["valor_total"];
$NoSerialContenedor = $_POST["No_serial_contenedor"];
$TipoContenedor = $_POST["tipo_contenedor"];
$TipoCanastilla = $_POST["tipo_canastilla"];
$TipoMasivo = $_POST["tipo_masivo"];
$NovedadNutresa = $_POST["novedad_nutresa"];
$NovedadContactamos = $_POST["novedad_contactamos"];
$Verificador = $_POST["idVerificador"];
$observaciones = $_POST["observaciones"];
$UrlDrive = $_FILES["UrlDrive"];


if (!empty($agente)) {
	
	if ($id != "") {
		
		try {
			include "../conexion.php";


			// Preparar la consulta con placeholders "?"
			$sql = "INSERT INTO auditoria (id_zona, id_agente, id_verificador, id_responsable, id_material, fecha_auditoria, 
                                   No_transporte, placa, faltante, sobrante, cruce, averia, tab_121, tab_402, tab_405, 
                                   tab_401, cantidad, valor_total, No_serial_contenedor, tipo_contenedor, tipo_canastilla, 
                                   tipo_masivo, novedad_nutresa, novedad_contactamos, observaciones, url_drive) 
            VALUES ($No_zona,
				$agente,
				$Verificador,
				$responsable,
				$id_materiales,
				$fecha,
				$No_transporte,
				'$placa',
				'$faltante',
				'$sobrante',
				'$cruce',
				'$averia',
				'$tab121',
				'$tab402',
				'$tab405',
				'$tab401',
				$cantidad,
				$valorTotal,
				$NoSerialContenedor,
				'$TipoContenedor',
				'$TipoCanastilla',
				'$TipoMasivo',
				'$NovedadNutresa',
				'$NovedadContactamos',
				'$observaciones',
				'$UrlDrive')";

			// Preparar la sentencia
			$stmt = $conexion->prepare($sql);
			$stmt->execute();

			if (!$stmt) {
				throw new Exception("Error al preparar la consulta: " . $conexion->error);
			}

			if ($stmt->affected_rows > 0) {
				var_dump($UrlDrive);
				// Si se actualizó correctamente, puedes devolver alguna respuesta, como el nuevo conteo
				echo "Registro insertado correctamente.";
				return true;
			} else {
				echo "error             ";
				var_dump($stmt);
				// Si no se actualizó (por ejemplo, si el id_usuario no existe), puedes manejar el error
				return false;
			}
			// Cerrar sentencia y conexión
			$stmt->close();
			$conexion->close();
		} catch (Exception $e) {
			echo "Error al insertar proceso: " . $e->getMessage();
		}
	} else {
		echo "Error al insertar proceso: " . $this->conexion->error;
	}
} else {

	echo "Completar campos obligatorios e internar nuevamente.";
}
