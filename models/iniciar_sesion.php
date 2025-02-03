<?php

if(isset($_POST["submitLOG"])){
	include "conexion.php";
	$usuarioLOG = $_POST["usuario"];
	$contrasenaLOG = $_POST["contrasena"];
	try {
		
		$sql1 = "SELECT * 
				 FROM usuarios
				 WHERE sw=1 AND (usuario='$usuarioLOG' OR correo='$usuarioLOG')";
		$resultado1 = $conexion->query($sql1);
		
		if($resultado1->num_rows > 0){
						
			while($fila1 = $resultado1->fetch_assoc()){
	
				if(password_verify($contrasenaLOG, $fila1['contrasena'])) {
					
					$id = $fila1["id"];
					$tipo = $fila1["tipo"];
					
					$sql2 = "INSERT INTO sesiones (usuario, tipo) 
							 VALUES ('$id', '$tipo')";
					$resultado2 = $conexion->query($sql2);
	
					$nombre = $fila1["nombre"];
					$cargo = $fila1["cargo"];
					$usuario = $fila1["usuario"];
					$correo = $fila1["correo"];		
					$creacion = date("d/m/Y",strtotime($fila1["creacion"]));
					
					$sql3 = "SELECT COUNT(usuario) AS sesiones, MAX(marca) AS ultima
							 FROM sesiones
							 WHERE usuario='$id'";		
					$resultado3 = $conexion->query($sql3);
					$fila3 = $resultado3->fetch_assoc();
	
					$sesiones = $fila3["sesiones"];
					$ultima = date("d/m/Y h:i:s A",strtotime($fila3["ultima"]));
					
					session_start();
	
					$_SESSION["id"] = $id;
					$_SESSION["nombre"] = $nombre;
					$_SESSION["cargo"] = $cargo;
					$_SESSION["usuario"] = $usuario;
					$_SESSION["correo"] = $correo;
					$_SESSION["tipo"] = $tipo;
					$_SESSION["creacion"] = $creacion;
					$_SESSION["sesiones"] = $sesiones;
					$_SESSION["ultima"] = $ultima;	
					$_SESSION["url_base"] = "http://localhost/comercialnutresa/";	
					
					//echo "<script>location.reload();</script>";
					header("Location:" . $_SESSION["url_base"] . "index.php");
					//header("Location:http://vefers.000webhostapp.com/wms/index.php");
					//header("Location:http://localhost/wms/index");
					//header("Location:https://9697db89.ngrok.io/wms/index");
					
				} else{
	
					echo "<p class='retorno'>Contraseña incorrecta</p>";
	
				}
			}
		} else{
	
			echo "<p class='retorno'>Usuario o correo electrónico no válidos</p>";
	
		}
	
		$conexion->close();
	} catch (exception $e) {
		echo $e->getMessage();
	}
	
}

?>