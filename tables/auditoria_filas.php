<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$url_base = $_SESSION["url_base"];

if (!isset($id)) {

    header("Location:" . $url_base . "login.php");

    die();
}

include "../conexion.php";

$consulta = $_POST["consulta"];

if ($consulta == "") {
    $sql = "SELECT COUNT(f.id_auditoria)
                FROM auditoria AS f, responsable AS r, zona AS z, agente AS ag, verificador AS ver, materiales 
                WHERE f.id_responsable = r.id_responsable AND f.id_zona = z.id_zona AND f.id_agente = ag.id_agente AND f.id_verificador = ver.id_verificador
                AND f.id_materiales = mat.id_materiales";

    } else {

        $sql = "SELECT COUNT(f.id_auditoria)
                FROM auditoria AS f, responsable AS r, zona AS z, agente AS ag, verificador AS ver, materiales 
                WHERE f.id_responsable = r.id_responsable AND f.id_zona = z.id_zona AND f.id_agente = ag.id_agente AND f.id_verificador = ver.id_verificador
                AND f.id_materiales = mat.id_materiales
                AND (
                    POSITION('$consulta' IN f.fecha_auditoria) OR
                    POSITION('$consulta' IN r.nombre_responsable) OR
                    POSITION('$consulta' IN ag.nombre_agente) OR
                    POSITION('$consulta' IN z.No_zona ) OR
                    POSITION('$consulta' IN f.No_transporte) OR
                    POSITION('$consulta' IN f.placa) OR
                    POSITION('$consulta' IN f.faltante) OR
                    POSITION('$consulta' IN f.sobrante) OR
                    POSITION('$consulta' IN f.cruce) OR
                    POSITION('$consulta' IN f.averia) OR
                    POSITION('$consulta' IN f.tab_121) OR
                    POSITION('$consulta' IN f.tab_402) OR
                    POSITION('$consulta' IN f.tab_405) OR
                    POSITION('$consulta' IN f.tab_401) OR
                    POSITION('$consulta' IN mat.codigo_material) OR
                    POSITION('$consulta' IN mat.descripcion) OR
                    POSITION('$consulta' IN mat.cantidad) OR
                    POSITION('$consulta' IN mat.valor_total) OR
                    POSITION('$consulta' IN mat.No_serial_contenedor) OR
                    POSITION('$consulta' IN f.tipo_contenedor) OR
                    POSITION('$consulta' IN f.tipo_canastilla) OR
                    POSITION('$consulta' IN f.tipo_masivo) OR
                    POSITION('$consulta' IN f.novedad_nutresa) OR
                    POSITION('$consulta' IN f.novedad_contactamos) OR
                    POSITION('$consulta' IN f.nombre_verificador) OR
                    POSITION('$consulta' IN f.observaciones) OR
                    POSITION('$consulta' IN f.url_drive)
                 )";
}

$resultado = $conexion->query($sql);
$datos = $resultado->fetch_array();
$filas = $datos[0];

echo $filas;

$conexion->close();


