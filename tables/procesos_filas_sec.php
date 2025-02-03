<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$url_base = $_SESSION["url_base"];

if(!isset($id)){
	
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

include "../conexion.php";

$limite = $_POST["limite"];
$consulta = $_POST["consulta"];

if($consulta == ""){

	$sql = "SELECT COUNT(f.estado)
			FROM procesos AS f, lideres AS l, vehiculos AS v, turnos AS t, muelles AS b, procedencias AS p, destinos AS d, canales AS c
			WHERE f.sw=1 AND f.lider=l.id AND f.turno=t.id AND f.muelle=b.muelle AND f.vehiculo=v.id AND f.procedencia=p.id AND f.destino=d.id AND f.canal=c.id";
	
} else{
	
	$sql = "SELECT COUNT(f.estado)
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
			)";
	
}

$resultado = $conexion->query($sql);	
$datos = $resultado->fetch_array();
$filas = $datos[0];
$maximo = ceil($filas/$limite);

echo $maximo;

$conexion->close();

?>