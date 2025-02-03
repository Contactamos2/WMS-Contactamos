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
					<h2><i class="fas fa-user-cog"></i>Gestión de Operario</h2>
				</div>
				<div class="caja-form-section">
					<div class="caja-fila-inputs">
						<div class="caja-inputs">
							<label>Primer nombre</label>
							<input type="text" id="nombre1" name="nombre1" onChange="this.value=(this.value).toUpperCase()" style="text-transform:uppercase" required>
						</div>
						<div class="caja-inputs">
							<label>Segundo nombre</label>
							<input type="text" id="nombre2" name="nombre2" onChange="this.value=(this.value).toUpperCase()" style="text-transform:uppercase">
						</div>
						<div class="caja-inputs">
							<label>Primer apellido</label>
							<input type="text" id="apellido1" name="apellido1" onChange="this.value=(this.value).toUpperCase()" style="text-transform:uppercase" required>
						</div>
						<div class="caja-inputs">
							<label>Segundo apellido</label>
							<input type="text" id="apellido2" name="apellido2" onChange="this.value=(this.value).toUpperCase()" style="text-transform:uppercase">
						</div>
					</div>
					<div class="caja-fila-inputs">
						<div class="caja-inputs">
							<label>N° de identificación</label>
							<input type="number" id="ndi" name="ndi" min="1" required>
						</div>
						<div class="caja-inputs">
							<label>Estado</label>
							<select id="estado" name="estado" required>
								<option>Activo</option>
								<option>Retirado</option>
							</select>
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
				<a href="Javascript:void()" onClick="document.getElementById('form').reset();w3.show('#nuevo')" title="Nuevo"><i class="fas fa-plus"></i></a>		
			</div>
		</div>
		<div class="caja-tabla-tabla">
			<div class="caja-scroll">
				<table id="tabla">
					<thead>
						<tr>
							<th><a>Opciones</a></th>
							<th><a href="Javascript:void()" onClick="w3.sortHTML('#tabla', '.fila', 'td:nth-child(2)')">Nombre completo</a></th>
							<th><a href="Javascript:void()" onClick="w3.sortHTML('#tabla', '.fila', 'td:nth-child(3)')">NDI</a></th>
							<th><a href="Javascript:void()" onClick="w3.sortHTML('#tabla', '.fila', 'td:nth-child(4)')">Estado</a></th>
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
		url: "tables/operarios_filas.php",
		type: "POST",
		dataType: "HTML",
		data: {limite: limite, consulta: consulta}
	})
	.done(function(maximo){
		$("#maximo").val(maximo);
    });
		
	$.ajax({
		url: "tables/operarios_tabla.php",
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
	
function editar(b){
	
	var id = b.dataset.id;
	
	$.ajax({
		url: "queries/info_operario.php",
		type: "POST",
		dataType: "JSON",
		data: {id: id}
	})
	.done(function(info){
		
		var nombre1 = info[0].nombre1;
		var nombre2 = info[0].nombre2;
		var apellido1 = info[0].apellido1;
		var apellido2 = info[0].apellido2;
		var ndi = info[0].ndi;
		var estado = info[0].estado;
		
		$("#id").val(id);
		$("#nombre1").val(nombre1);
		$("#nombre2").val(nombre2);
		$("#apellido1").val(apellido1);
		$("#apellido2").val(apellido2);
		$("#ndi").val(ndi);
		$("#estado").val(estado);
		$("#nuevo").show();
		
    });
}
	
//GUARDAR LÍDER

$("#form").on("submit", function(e){

	e.preventDefault();

	var formData = new FormData(document.getElementById("form"));	

	$.ajax({
		url: "models/guardar_operario.php",
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