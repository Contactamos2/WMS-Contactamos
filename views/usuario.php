<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$nombre = $_SESSION["nombre"];
$cargo = $_SESSION["cargo"];
$usuario = $_SESSION["usuario"];
$correo = $_SESSION["correo"];
$tipo = $_SESSION["tipo"];
$creacion = $_SESSION["creacion"];
$sesiones = $_SESSION["sesiones"];
$ultima = $_SESSION["ultima"];
$url_base = $_SESSION["url_base"];

if(!isset($id)){
	
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

?>

<div>
	<div class="caja-form-header">
		<a href="javascript:void()" onClick="seccionHide()" title="Salir"><i class="fas fa-times"></i></a>
		<h2><i class="fas fa-user-circle"></i>Usuario</h2>
	</div>
	<div class="caja-form-section">
		<div class="caja-fila-inputs">
			<div class="caja-inputs">
				<label>Nombre</label>
				<input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" readonly>
			</div>
			<div class="caja-inputs">
				<label>Cargo</label>
				<input type="text" id="cargo" name="cargo" value="<?php echo $cargo; ?>" readonly>
			</div>
			<div class="caja-inputs">
				<label>Usuario</label>
				<input type="text" id="usuario" name="usuario" value="<?php echo $usuario; ?>" readonly>
			</div>
			<div class="caja-inputs">
				<label>Correo electrónico</label>
				<input type="text" id="correo" name="correo" value="<?php echo $correo; ?>" readonly>
			</div>
		</div>		
		<div class="caja-fila-inputs">
			<div class="caja-inputs">
				<label>Tipo de usuario</label>
				<input type="text" id="tipo" name="tipo" value="<?php echo $tipo; ?>" readonly>
			</div>	
			<div class="caja-inputs">
				<label>Fecha de creación</label>
				<input type="text" id="creacion" name="creacion" value="<?php echo $creacion; ?>" readonly>
			</div>
			<div class="caja-inputs">
				<label>Número de sesiones</label>
				<input type="text" id="sesiones" name="sesiones" value="<?php echo $sesiones; ?>" readonly>
			</div>
			<div class="caja-inputs">
				<label>Última sesión</label>
				<input type="text" id="ultima" name="ultima" value="<?php echo $ultima; ?>" readonly>
			</div>
		</div>	
	</div>
	<div class="caja-form-footer"></div>
</div>