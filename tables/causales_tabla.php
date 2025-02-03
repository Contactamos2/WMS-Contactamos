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

	$sql = "SELECT c.id, c.causal, c.proceso, c.cargue, c.muelle
			FROM causales AS c
			WHERE c.sw=1
			ORDER BY c.proceso ASC, c.causal ASC LIMIT $limite OFFSET $offset";
	
} else{
	
	$sql = "SELECT c.id, c.causal, c.proceso, c.cargue, c.muelle
			FROM causales AS c
			WHERE c.sw=1
			AND (
				POSITION('$consulta' IN c.causal) OR
				POSITION('$consulta' IN c.proceso) OR
				POSITION('$consulta' IN c.cargue) OR
				POSITION('$consulta' IN c.muelle)
			)
			ORDER BY c.proceso ASC, c.causal ASC LIMIT $limite OFFSET $offset";
	
}

$resultado = $conexion->query($sql);
$conteo = 0;

if($resultado == true){

	while($fila = $resultado->fetch_array()){

		++$conteo;

		echo "<tr class='fila'>";
			echo "<td>";
				echo "<a href='Javascript:void()' data-id='$fila[0]' data-elemento='Causal $fila[1]' data-tabla='vehiculos' onClick='eliminar(this)' class='delete'><i class='fas fa-trash'></i>Eliminar</a>";
				echo "<a href='Javascript:void()' data-id='$fila[0]' onClick='editar(this)' class='edit'><i class='fas fa-pen'></i>Editar</a>";
			echo "</td>";
			echo "<td class='left'>" . $fila[2] . "</td>";
			echo "<td class='left'>" . $fila[1] . "</td>";
			echo "<td>" . $fila[3] . "</td>";
			echo "<td>" . $fila[4] . "</td>";
		echo "</tr>";
	}	

	$resultado->free();

} else{
	echo "Error al cargar vehículos: " . $conexion->error;
}

$conexion->close();

?>