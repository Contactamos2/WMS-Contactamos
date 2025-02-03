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

?>

<div class="caja-form-section fondo-tabla">		
	<div id="nuevo" class="caja-fixed left0 caja-scroll capa3">
		<div class="caja-min caja-form animatetop">
			<form id="form" method="post" enctype="multipart/form-data">
				<input type="text" placeholder="ID" id="id" name="id" class="hidden">
				<div class="caja-form-header">
					<a href="javascript:void()" onClick="this.parentNode.parentNode.parentNode.parentNode.style.display='none'" title="Salir"><i class="fas fa-times"></i></a>
					<h2><i class="fas fa-user-circle"></i>Gestión de Usuario</h2>
				</div>
				<div class="caja-form-section">
					<div class="caja-fila-inputs">
						<div class="caja-inputs">
							<label>Usuario</label>
							<input type="text" id="usuario" name="usuario" placeholder="@Ejemplo" required>
						</div>
						<div class="caja-inputs">
							<label>Correo electrónico</label>
							<input type="email" id="correo" name="correo" placeholder="ejemplo@gmail.com" onChange="this.value=(this.value).toLowerCase()" style="text-transform:lowercase" required>
						</div>
						<div class="caja-inputs">
							<label>Contraseña</label>
							<input type="password" id="contrasena" name="contrasena" placeholder="********">
						</div>
						<div class="caja-inputs">
							<label>Tipo</label>
							<select id="tipo" name="tipo" required>
								<option value="">Elige una opción...</option>
								<option>ADMINISTRADOR</option>
								<option>CONSULTA</option>
								<option>BÁSICO</option>
								<option>PROCESO</option>
								<option>CLIENTE</option>
							</select>
						</div>
					</div>
					<div class="caja-fila-inputs">
						<div class="caja-inputs">
							<label>Nombre</label>
							<input type="text" id="nombreapellido" name="nombreapellido" required>
						</div>
						<div class="caja-inputs">
							<label>Cargo</label>
							<input type="text" id="cargo" name="cargo" required>
						</div>
						<div class="caja-inputs">
							<label>Mostrar contraseña</label>
							<input type="checkbox" style="width:20px" onChange="verContrasena(this.checked)">
						</div>
						<div class="caja-inputs">
							<label>Recuperar contraseña</label>
							<a href="Javascript:void()" onClick="recuperarContrasena()">Enviar correo electrónico</a>
						</div>
					</div>
				</div>
				<div class="caja-form-footer">
					<input type="button" value="Cancelar" onClick="this.parentNode.parentNode.parentNode.parentNode.style.display='none'">
					<input type="submit" value="Guardar" class="der">	
				</div>
			</form>
		</div>				
	</div>
	<div class="caja-tabla">				
		<div class="caja-tabla-filtro">
			<div>
				<input type="search" id="consulta" placeholder="¿Qué quieres buscar?" oninput="tablear()">
				<a href="Javascript:void()" onClick="document.getElementById('form').reset();verContrasena(false);w3.show('#nuevo')" title="Nuevo"><i class="fas fa-plus"></i></a>
			</div>
		</div>
		<div class="caja-tabla-tabla">
			<div class="caja-scroll">
				<table id="tabla">
					<thead>
						<tr>
							<th><a>Opciones</a></th>
							<th><a href="Javascript:void()" onClick="w3.sortHTML('#tabla', '.fila', 'td:nth-child(2)')">Usuario</a></th>
							<th><a href="Javascript:void()" onClick="w3.sortHTML('#tabla', '.fila', 'td:nth-child(3)')">Correo electrónico</a></th>
							<th><a href="Javascript:void()" onClick="w3.sortHTML('#tabla', '.fila', 'td:nth-child(4)')">Tipo</a></th>
							<th><a href="Javascript:void()" onClick="w3.sortHTML('#tabla', '.fila', 'td:nth-child(5)')">Nombre</a></th>
							<th><a href="Javascript:void()" onClick="w3.sortHTML('#tabla', '.fila', 'td:nth-child(6)')">Cargo</a></th>
							<th><a href="Javascript:void()" onClick="w3.sortHTML('#tabla', '.fila', 'td:nth-child(7)')">Creación</a></th>
							<th><a href="Javascript:void()" onClick="w3.sortHTML('#tabla', '.fila', 'td:nth-child(8)')">Sesiones</a></th>
							<th><a href="Javascript:void()" onClick="w3.sortHTML('#tabla', '.fila', 'td:nth-child(9)')">Última sesión</a></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="caja-form-footer paginador">
	<div class="izq">
		<select id="limite" onChange="tablear()">
			<option>20</option>
			<option>50</option>
			<option>100</option>
		</select>
		<span>filas por página</span>
	</div>
	<div class="der">
		<button onClick="anterior()" title="Anterior"><i class="fas fa-chevron-left"></i></button>	
		<input type="text" id="pagina" value="1" readonly>
		<span>de</span>
		<input type="text" id="maximo" value="1" readonly>
		<button onClick="siguiente()"title="Siguiente"><i class="fas fa-chevron-right"></i></button>	
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" rel="noopener"></script>
<script>

tablear();
	
function tablear(){
	
	var limite = document.getElementById("limite").value;
	var pagina = document.getElementById("pagina").value;
	var consulta = document.getElementById("consulta").value;
	
	$.ajax({
		url: "tables/usuarios_filas.php",
		type: "POST",
		dataType: "HTML",
		data: {limite: limite, consulta: consulta}
	})
	.done(function(maximo){
		$("#maximo").val(maximo);
    });
		
	$.ajax({
		url: "tables/usuarios_tabla.php",
		type: "POST",
		dataType: "HTML",
		data: {limite: limite, pagina: pagina, consulta: consulta}
	})
	.done(function(tabla){
		$("#tabla tbody").html(tabla);
    });
		
}
	
function anterior(){
	
	var pagina = Number(document.getElementById("pagina").value);
	
	if(pagina > 1){
		
		pagina -= 1;
		
	}
	
	document.getElementById("pagina").value = pagina;
	
	tablear();
	
}
	
function siguiente(){
	
	var pagina = Number(document.getElementById("pagina").value);
	var maximo = Number(document.getElementById("maximo").value);
	
	if(pagina < maximo){
		
		pagina += 1;
		
	}
	
	document.getElementById("pagina").value = pagina;
	
	tablear();
	
}
	
function verContrasena(check){

	if(check){

		document.getElementById("contrasena").type = "text";

	} else{

		document.getElementById("contrasena").type = "password";

	}
}	
	
function editar(b){
	
	var id = b.dataset.id;
	
	$.ajax({
		url: "queries/info_usuario.php",
		type: "POST",
		dataType: "JSON",
		data: {id: id}
	})
	.done(function(info){
		
		var usuario = info[0].usuario;
		var correo = info[0].correo;
		var contrasena = info[0].contrasena;
		var tipo = info[0].tipo;
		var nombre = info[0].nombre;
		var cargo = info[0].cargo;
		
		$("#id").val(id);
		$("#usuario").val(usuario);
		$("#correo").val(correo);
		$("#contrasena").val("");
		$("#tipo").val(tipo);
		$("#prueba").val(nombre);
		$("#nombreapellido").val(nombre);
		$("#cargo").val(cargo);
		$("#nuevo").show();
		
    });
}
	
//GUARDAR USUARIO

$("#form").on("submit", function(e){

	e.preventDefault();

	var formData = new FormData(document.getElementById("form"));	

	$.ajax({
		url: "models/guardar_usuario.php",
		type: "POST",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	})
	.done(function(sms){

		$("#caja-confirmacion").hide();
		$("#mensaje").html(sms);
		$("#caja-mensaje").show();
		$("#caja-alert").show();
		$("#nuevo").hide();

		tablear();
	})

});
	
</script>