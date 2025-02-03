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

	$sql = "SELECT u.id, u.usuario, u.correo, u.tipo, u.nombre, u.cargo, u.creacion
			FROM usuarios AS u
			WHERE u.sw=1
			LIMIT $limite OFFSET $offset";
	
} else{
	
	$sql = "SELECT u.id, u.usuario, u.correo, u.tipo, u.nombre, u.cargo, u.creacion
			FROM usuarios AS u
			WHERE u.sw=1
			AND (
				POSITION('$consulta' IN u.usuario) OR
				POSITION('$consulta' IN u.correo) OR
				POSITION('$consulta' IN u.contrasena) OR
				POSITION('$consulta' IN u.tipo) OR
				POSITION('$consulta' IN u.nombre) OR
				POSITION('$consulta' IN u.cargo) OR
				POSITION('$consulta' IN u.creacion)
			)
			ORDER BY u.nombre LIMIT $limite OFFSET $offset";
	
}

$resultado = $conexion->query($sql);
$conteo = 0;

if($resultado == true){

	while($fila = $resultado->fetch_array()){

		++$conteo;
		
		$sql3 = "SELECT COUNT(usuario) AS sesiones, MAX(marca) AS ultima
				 FROM sesiones
				 WHERE usuario='$fila[0]'";		
		$resultado3 = $conexion->query($sql3);
		$fila3 = $resultado3->fetch_assoc();
		$sesiones = $fila3["sesiones"];
		$ultima = date("d/m/Y h:i:s A",strtotime($fila3["ultima"]));
			
		if($sesiones == 0){
			
			$ultima = "";
			
		}			

		echo "<tr class='fila'>";
			if($fila[0] == 1){
				echo "<td>";
					echo "";
					echo "";
				echo "</td>";				
			} else{
				echo "<td>";
					echo "<a href='Javascript:void()' data-id='$fila[0]' data-elemento='Usuario $fila[1]' data-tabla='usuarios' onClick='eliminar(this)' class='delete'><i class='fas fa-trash'></i>Eliminar</a>";
				echo "<a href='Javascript:void()' data-id='$fila[0]' onClick='editar(this)' class='edit'><i class='fas fa-pen'></i>Editar</a>";
				echo "</td>";
			}
			echo "<td class='left'>" . $fila[1] . "</td>";
			echo "<td class='left'>" . $fila[2] . "</td>";
			echo "<td class='left'>" . $fila[3] . "</td>";
			echo "<td class='left'>" . $fila[4] . "</td>";
			echo "<td class='left'>" . $fila[5] . "</td>";
			echo "<td>" . date("d/m/Y",strtotime($fila[6])) . "</td>";
			echo "<td>" . $sesiones . "</td>";
			echo "<td>" . $ultima . "</td>";
		echo "</tr>";
	}	

	$resultado->free();

} else{
	echo "Error al cargar usuarios: " . $conexion->error;
}

$conexion->close();

?>