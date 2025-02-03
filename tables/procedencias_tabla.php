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

	$sql = "SELECT p.id, p.procedencia
			FROM procedencias AS p
			WHERE p.sw=1
			ORDER BY p.procedencia LIMIT $limite OFFSET $offset";
	
} else{
	
	$sql = "SELECT p.id, p.procedencia
			FROM procedencias AS p
			WHERE p.sw=1
			AND (
				POSITION('$consulta' IN p.procedencia)
			)
			ORDER BY p.procedencia LIMIT $limite OFFSET $offset";
	
}

$resultado = $conexion->query($sql);
$conteo = 0;

if($resultado == true){

	while($fila = $resultado->fetch_array()){

		if($fila[0] != 69){

			++$conteo;

			echo "<tr class='fila'>";
				echo "<td>";
					echo "<a href='Javascript:void()' data-id='$fila[0]' data-elemento='Procedencia $fila[1]' data-tabla='procedencias' onClick='eliminar(this)' class='delete'><i class='fas fa-trash'></i>Eliminar</a>";
					echo "<a href='Javascript:void()' data-id='$fila[0]' onClick='editar(this)' class='edit'><i class='fas fa-pen'></i>Editar</a>";
				echo "</td>";
				echo "<td class='left'>" . $fila[1] . "</td>";
			echo "</tr>";

		}
	}	

	$resultado->free();

} else{
	echo "Error al cargar procedencias: " . $conexion->error;
}

$conexion->close();

?>