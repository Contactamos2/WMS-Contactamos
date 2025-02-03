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

	$sql = "SELECT l.id, l.ndi, l.nombre, l.nick, l.proceso
			FROM lideres AS l
			WHERE l.sw=1
			ORDER BY l.nombre LIMIT $limite OFFSET $offset";
	
} else{
	
	$sql = "SELECT l.id, l.ndi, l.nombre, l.nick, l.proceso
			FROM lideres AS l
			WHERE l.sw=1
			AND (
				POSITION('$consulta' IN l.id) OR
				POSITION('$consulta' IN l.nombre) OR
				POSITION('$consulta' IN l.nick) OR
				POSITION('$consulta' IN l.proceso)
			)
			ORDER BY l.nombre LIMIT $limite OFFSET $offset";
	
}

$resultado = $conexion->query($sql);
$conteo = 0;

if($resultado == true){

	while($fila = $resultado->fetch_array()){

		++$conteo;

		echo "<tr class='fila'>";
			echo "<td>";
				echo "<a href='Javascript:void()' data-id='$fila[0]' data-elemento='Líder $fila[2]' data-tabla='lideres' onClick='eliminar(this)' class='delete'><i class='fas fa-trash'></i>Eliminar</a>";
				echo "<a href='Javascript:void()' data-id='$fila[0]' onClick='editar(this)' class='edit'><i class='fas fa-pen'></i>Editar</a>";
			echo "</td>";
			echo "<td class='right'>" . $fila[1] . "</td>";
			echo "<td class='left'>" . $fila[2] . "</td>";
			echo "<td class='left'>" . $fila[3] . "</td>";
			echo "<td class='left'>" . $fila[4] . "</td>";
		echo "</tr>";
	}	

	$resultado->free();

} else{
	echo "Error al cargar líderes: " . $conexion->error;
}

$conexion->close();

?>