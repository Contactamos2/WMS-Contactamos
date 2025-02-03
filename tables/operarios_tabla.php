<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = $_SESSION["url_base"];

if(!isset($id) || $tipo != "ADMINISTRADOR"){
	
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

include "../conexion.php";

$limite = $_POST["limite"];
$pagina = $_POST["pagina"];
$offset = $limite*$pagina - $limite;
$consulta = $_POST["consulta"];

if($consulta == ""){

	$sql = "SELECT o.id, o.nombre1, o.nombre2, o.apellido1, o.apellido2, o.ndi, o.estado
			FROM operarios AS o
			WHERE o.sw=1
			ORDER BY o.apellido1, o.apellido2, o.nombre1, o.nombre2 LIMIT $limite OFFSET $offset";
	
} else{
	
	$sql = "SELECT o.id, o.nombre1, o.nombre2, o.apellido1, o.apellido2, o.ndi, o.estado
			FROM operarios AS o
			WHERE o.sw=1
			AND (
				POSITION('$consulta' IN o.nombre1) OR
				POSITION('$consulta' IN o.nombre2) OR
				POSITION('$consulta' IN o.apellido1) OR
				POSITION('$consulta' IN o.apellido2) OR
				POSITION('$consulta' IN o.ndi) OR
				POSITION('$consulta' IN o.estado)
			)
			ORDER BY o.apellido1, o.apellido2, o.nombre1, o.nombre2 LIMIT $limite OFFSET $offset";
	
}

$resultado = $conexion->query($sql);
$conteo = 0;

if($resultado == true){

	while($fila = $resultado->fetch_array()){

		$nombre_completo = trim($fila[3] . " " . $fila[4] . " " . $fila[1] . " " . $fila[2]);

		++$conteo;

		echo "<tr class='fila'>";
			echo "<td>";
				echo "<a href='Javascript:void()' data-id='$fila[0]' data-elemento='Operario $nombre_completo' data-tabla='operarios' onClick='eliminar(this)' class='delete'><i class='fas fa-trash'></i>Eliminar</a>";
				echo "<a href='Javascript:void()' data-id='$fila[0]' onClick='editar(this)' class='edit'><i class='fas fa-pen'></i>Editar</a>";
			echo "</td>";
			echo "<td class='left'>" . $nombre_completo . "</td>";
			echo "<td class='right'>" . $fila[5] . "</td>";
			echo "<td>" . $fila[6] . "</td>";
		echo "</tr>";
	}	

	$resultado->free();

} else{
	echo "Error al cargar líderes: " . $conexion->error;
}

$conexion->close();

?>