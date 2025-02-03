<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];

if(!isset($id) || $tipo != "ADMINISTRADOR"){
	
	header("Location:https://wms.contactamos.co/login.php");
	
	die();
	
}

?>

<div>		
	<div class="caja-form-header">
		<a href="javascript:void()" onClick="seccionHide()" title="Salir"><i class="fas fa-times"></i></a>
		<h2><i class="fas fa-medal"></i>Ranking</h2>
	</div>
	<div class="caja-form-section fondo-tabla">	
		<div class="caja-tabla">
			<div class="caja-tabla-filtro">
				<div>

				</div>
			</div>
			<div class="caja-tabla-tabla">
				<div class="caja-scroll">
					<table id="tabla">
						<thead>
							<tr>
								<th><a>#</a></th>
								<th><a>Operador logístico</a></th>
								<th><a>Kilogramos</a></th>
								<th><a>Horas</a></th>
								<th><a>Rendimiento (kg/hora)</a></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="caja-form-footer paginador">

	</div>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" rel="noopener"></script>
	<script>

	function cargarRanking(){

		$.ajax({
			url: "tables/ranking_tabla_sec.php",
			type: "POST",
			dataType: "HTML"
		})
		.done(function(tabla){
			$("#tabla tbody").html(tabla);
		});

	}

	cargarRanking();
		
	</script>
</div>