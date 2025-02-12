<?php
header('Content-Type: application/json');
session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = $_SESSION["url_base"];

if (!isset($id) || ($tipo != "ADMINISTRADOR" && $tipo != "BÁSICO" && $tipo != "PROCESO" && $tipo != "CLIENTE")) {

	header("Location:" . $url_base . "login.php");

	die();
}

?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" rel="noopener"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
	function crono(b) {

		var proceso = document.getElementById("finicioB" + b).innerHTML;
		var estado = document.getElementById("festadoB" + b).innerHTML;
		var etapa = document.getElementById("einicioB" + b).innerHTML;
		var max = document.getElementById("emaxB" + b).innerHTML;
		var clase = document.getElementById("anclaB" + b).className;
		var clases = "parpadea estado" + estado;

		if (proceso != "") {

			var now = new Date().getTime();
			//TIEMPO PROCESO
			var tiempoProceso = new Date(proceso).getTime();
			var distanceF = now - tiempoProceso;
			var daysF = Math.floor(distanceF / (1000 * 60 * 60 * 24));
			var hoursF = Math.floor((distanceF % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutesF = Math.floor((distanceF % (1000 * 60 * 60)) / (1000 * 60));
			var secondsF = Math.floor((distanceF % (1000 * 60)) / 1000);

			if (hoursF < 10) {
				hoursF = "0" + hoursF;
			}
			if (minutesF < 10) {
				minutesF = "0" + minutesF;
			}
			if (secondsF < 10) {
				secondsF = "0" + secondsF;
			}

			document.getElementById("fcronoB" + b).innerHTML = hoursF + ":" + minutesF;

			//TIEMPO ETAPA
			var tiempoEtapa = new Date(etapa).getTime();
			var distanceE = now - tiempoEtapa;
			var daysE = Math.floor(distanceE / (1000 * 60 * 60 * 24));
			var hoursE = Math.floor((distanceE % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutesE = Math.floor((distanceE % (1000 * 60 * 60)) / (1000 * 60));
			var secondsE = Math.floor((distanceE % (1000 * 60)) / 1000);

			if (hoursE < 10) {
				hoursE = "0" + hoursE;
			}
			if (minutesE < 10) {
				minutesE = "0" + minutesE;
			}
			if (secondsE < 10) {
				secondsE = "0" + secondsE;
			}

			var minutosE = Number(hoursE) * 60 + Number(minutesE);

			document.getElementById("ecronoB" + b).innerHTML = hoursE + ":" + minutesE + " (" + minutosE + ")";

			if (max > 0 && minutosE > max && clase != clases) {

				document.getElementById("anclaB" + b).className = "parpadea " + clase;

			}
		}
	}

	function timer(b) {

		try {

			crono(b);

		} catch (e) {}

		setInterval(function() {

			try {

				crono(b);

			} catch (e) {}

		}, 60000);

	}
</script>

<div>
	<div class="caja-form-header">
		<a href="javascript:void()" onClick="seccionHide()" title="Salir"><i class="fas fa-times"></i></a>
		<h2><i class="fas fa-truck"></i>Auditoria</h2>
	</div>
	<div class="caja-form-section fondo-tabla">
		<?php if ($tipo == "ADMINISTRADOR" || $tipo == "BÁSICO" || $tipo == "PROCESO") { ?>
			<div id="nuevo" class="caja-fixed left0 caja-scroll capa3">
				<div class="caja-min caja-form animatetop">
					<form id="form" method="POST" enctype="multipart/form-data">
						<input type="hidden" placeholder="ID" id="id" name="id" required>
						<div class="caja-form-header">
							<a href="javascript:void()" onClick="this.parentNode.parentNode.parentNode.parentNode.style.display='none'" title="Salir"><i class="fas fa-times"></i></a>
							<h2><i class="fas fa-truck"></i>Crear Auditoría</h2>
						</div>
						<div class="caja-form-section" style="background-color:rgb(225, 247, 231)">
							<div class="caja-fila-inputs">
								<div class="caja-inputs">
									<label>Fecha</label>
									<input type="date" class="form-control" name="fecha" value="<?php echo date("Y-m-d"); ?>" required>
								</div>
								<div class="caja-inputs ">
									<label>Responsable Reporte</label>
									<select id="procedencia" class="form-control" name="res_reporte" required>
										<option value="">Elige una opción...</option>
										<?php
										include "../conexion.php";

										$sql = "SELECT * 
													FROM responsable";
										$resultado = $conexion->query($sql);

										if ($resultado == true) {

											while ($fila = $resultado->fetch_assoc()) {
												echo "<option value='" . $fila["id_responsable"] . "'>" . $fila["nombre_responsable"] . "</option>";
											}

											$resultado->free();
										} else {
											echo "Error al agregar procedencias: " . $conexion->error;
										}

										$conexion->close();

										?>
									</select>
								</div>
								<div class="caja-inputs">
									<label>Agente</label>
									<select class="form-control" name="agente" required>
										<option value="">Elige una opción...</option>
										<?php
										include "../conexion.php";

										$sql = "SELECT * 
														FROM agente";
										$resultado = $conexion->query($sql);

										if ($resultado == true) {

											while ($fila = $resultado->fetch_assoc()) {
												echo "<option value='" . $fila["id_agente"] . "'>" . $fila["nombre_agente"] . "</option>";
											}

											$resultado->free();
										} else {
											echo "Error al agregar procedencias: " . $conexion->error;
										}

										$conexion->close();

										?>
									</select>
								</div>
								<div class="caja-inputs">
									<label>No Zona</label>
									<select id="procedencia" class="form-control" name="No_zona" required>
										<option value="">Elige una opción...</option>
										<?php
										include "../conexion.php";

										$sql = "SELECT * 
													FROM zona";
										$resultado = $conexion->query($sql);

										if ($resultado == true) {

											while ($fila = $resultado->fetch_assoc()) {
												echo "<option value='" . $fila["id_zona"] . "'>" . $fila["No_zona"] . "</option>";
											}

											$resultado->free();
										} else {
											echo "Error al agregar procedencias: " . $conexion->error;
										}

										$conexion->close();

										?>
									</select>
								</div>
							</div>
							<div class="caja-fila-inputs">
								<div class="caja-inputs">
									<label>No Transporte</label>
									<input type="number" class="form-control" name="No_transporte" required>
								</div>
								<div class="caja-inputs">
									<label>Placa</label>
									<input type="text" class="form-control" name="placa" required>
								</div>
								<div class="caja-inputs">
									<label>Código del Material</label>
									<select class="js-example-basic-single form-control" name="id_materiales" required>
										<option value="">Elige una opción...</option>
										<?php
										include "../conexion.php";
										$sql = "SELECT id_material, descripcion FROM materiales";
										$resultado = $conexion->query($sql);

										if ($resultado) {
											while ($fila = $resultado->fetch_assoc()) {
												echo "<option value='" . $fila["id_material"] . "'>" . $fila["descripcion"] . "</option>";
											}
											$resultado->free();
										} else {
											echo "<option>Error al cargar</option>";
										}
										?>
									</select>
								</div>

								<div class="caja-inputs">
									<label>Url del Drive</label>
									<input type="file" class="form-control" name="UrlDrive">
								</div>
							</div>
							<div class="caja-fila-inputs">
								<div class="form-check">
									<label><input type="checkbox" class="form-check-input"
											value="X" name="faltante"> Faltante</label>

									<label style="padding-left: 30px;"><input type="checkbox" class="form-check-input"
											value="X" name="sobrante"> Sobrante</label>

									<label style="padding-left: 30px;"><input type="checkbox" class="form-check-input"
											value="X" name="cruce"> Cruce</label>

									<label style="padding-left: 30px;"><input type="checkbox" class="form-check-input"
											value="X" name="averia"> Averia</label>

									<label style="padding-left: 30px;"><input type="checkbox" class="form-check-input"
											value="X" name="tab_121"> 121</label>

									<label style="padding-left: 30px;"><input type="checkbox" class="form-check-input"
											value="X" name="tab_402"> 402</label>

									<label style="padding-left: 30px;"><input type="checkbox" class="form-check-input"
											value="X" name="tab_405"> 405</label>

									<label style="padding-left: 30px;"><input type="checkbox" class="form-check-input"
											value="X" name="tab_401">401</label>
								</div>
							</div>
							<div class="caja-fila-inputs">
								<div class="caja-inputs">
									<label>Cantidad</label>
									<input type="text" class="form-control" name="cantidad" required>
								</div>
								<div class="caja-inputs">
									<label>Valor Total</label>
									<input type="number" class="form-control" name="valor_total" required>
								</div>
								<div class="caja-inputs">
									<label>No de Serial del Contenedor</label>
									<input type="number" class="form-control" name="No_serial_contenedor" required>
								</div>
								<div class="caja-inputs">
									<label>Novedad Nutresa</label>
									<textarea class="form-control" name="novedad_nutresa"></textarea>
								</div>
							</div>
							<div class="caja-fila-inputs">
								<div class="form-check" id="caja-e1">
									<label class="form-check-label"><input type="checkbox" class="form-check-input"
											value="X" name="tipo_contenedor"> Tipo Contenedor</label>

									<label class="form-check-label" style="padding-left: 30px;"><input type="checkbox" class="form-check-input"
											value="X" name="tipo_canastilla"> Tipo Canastilla</label>

									<label class="form-check-label" style="padding-left: 30px;"><input type="checkbox" class="form-check-input"
											value="X" name="tipo_masivo"> Tipo Masivo</label>
								</div>

							</div>
							<div class="caja-fila-inputs">
								<div class="caja-inputs">
									<label>Novedad Contactamos</label>
									<input class="form-control" name="novedad_contactamos">
								</div>
								<div class="caja-inputs">
									<label>Verificador</label>
									<select class="form-control" name="idVerificador" required>
										<option value="">Elige una opción...</option>
										<?php
										include "../conexion.php";

										$sql = "SELECT * 
													FROM verificador";
										$resultado = $conexion->query($sql);

										if ($resultado == true) {

											while ($fila = $resultado->fetch_assoc()) {
												echo "<option value='" . $fila["id_verificador"] . "'>" . $fila["nombre_verificador"] . "</option>";
											}

											$resultado->free();
										} else {
											echo "Error al agregar procedencias: " . $conexion->error;
										}

										$conexion->close();

										?>
									</select>
								</div>
								<div class="caja-inputs">
									<label>Observaciones</label>
									<textarea class="form-control" name="observaciones"></textarea>
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
		<?php } ?>
		<div class="caja-tabla">
			<div class="caja-tabla-filtro">
				<div>
					<input type="search" id="consulta" placeholder="¿Qué quieres buscar?" oninput="tablear()">
					<button class="btn btn-success" type="submit" onClick="nuevaAuditoria(this)">Crear</button>

				</div>
			</div>
			<div class="caja-tabla-tabla">
				<div class="caja-scroll" style="width: 4000px">
					<table id="tabla">
						<thead>
							<tr>
								<th><a>Fecha de auditoría</a></th>
								<th><a>Responsable Reporte</a></th>
								<th><a>Agente</a></th>
								<th><a>Zona No.</a></th>
								<th><a>No de transporte</a></th>
								<th><a>Placa</a></th>
								<th><a>Faltante</a></th>
								<th><a>Sobrante</a></th>
								<th><a>Cruce</a></th>
								<th><a>Averia</a></th>
								<th><a>121</a></th>
								<th><a>402</a></th>
								<th><a>405</a></th>
								<th><a>401</a></th>
								<th><a>Cod de Material</a></th>
								<th>Descripción del Material</th>
								<th><a>Cant</a></th>
								<th><a>Valor Total</a></th>
								<th><a>No. de Serial de Contenedor</a></th>
								<th><a>Tipo Contenedor</a></th>
								<th><a>Tipo Canastilla</a></th>
								<th><a>Tipo Masivo</a></th>
								<th><a>Novedad Nutresa</a></th>
								<th><a>Novedad Contactamos</a></th>
								<th><a>Verificador</a></th>
								<th><a>Observaciones</a></th>
								<th><a>URL de Drive</a></th>
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
			<button onClick="siguiente()" title="Siguiente"><i class="fas fa-chevron-right"></i></button>
		</div>
	</div>
</div>
<script>
	tablear();

	function tablear() {

		var limite = document.getElementById("limite").value;
		var pagina = document.getElementById("pagina").value;
		var consulta = document.getElementById("consulta").value;

		$.ajax({
				url: "tables/auditoria_filas.php",
				type: "POST",
				dataType: "HTML",
				data: {
					limite: limite,
					consulta: consulta
				}
			})
			.done(function(maximo) {
				$("#maximo").val(maximo);
			});

		$.ajax({
				url: "tables/auditoria_tabla.php",
				type: "POST",
				dataType: "HTML",
				data: {
					limite: limite,
					pagina: pagina,
					consulta: consulta
				}
			})
			.done(function(tabla) {
				$("#tabla tbody").html(tabla);
			});

	}

	function anterior() {

		var pagina = Number(document.getElementById("pagina").value);

		if (pagina > 1) {

			pagina -= 1;

		}

		document.getElementById("pagina").value = pagina;

		tablear();

	}

	function siguiente() {

		var pagina = Number(document.getElementById("pagina").value);
		var maximo = Number(document.getElementById("maximo").value);

		if (pagina < maximo) {

			pagina += 1;

		}

		document.getElementById("pagina").value = pagina;

		tablear();

	}


	function cargarModal() {
		// Obtiene el contenido de la vista oculta
		let contenido = document.getElementById('form').innerHTML;

		// Inserta el contenido dentro del modal
		document.getElementById('modal-body').innerHTML = contenido;
	}

	//GUARDAR PROCESO
	$("#form").on("submit", function(e) {

		e.preventDefault();

		var formData = new FormData(document.getElementById("form"));

		$.ajax({
			url: "models/guardar_auditoria.php",
			type: "POST",
			dataType: "html",
			data: formData,
			cache: false,
			contentType: false,
			processData: false
		})
	});

	//NUEVO PROCESO

	function nuevaAuditoria(a) {
		w3.show("#nuevo");
	}

	function Guardar() {

	}
</script>