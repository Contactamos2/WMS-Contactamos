<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = $_SESSION["url_base"];

if(!isset($id) || ($tipo != "ADMINISTRADOR" && $tipo != "BÁSICO" && $tipo != "PROCESO" && $tipo != "CLIENTE")){
	
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" rel="noopener"></script>
<script>

function crono(b){
	
	var proceso = document.getElementById("finicioB" + b).innerHTML;
	var estado = document.getElementById("festadoB" + b).innerHTML;
	var etapa = document.getElementById("einicioB" + b).innerHTML;
	var max = document.getElementById("emaxB" + b).innerHTML;
	var clase = document.getElementById("anclaB" + b).className;
	var clases = "parpadea estado" + estado;

	if(proceso != ""){

		var now = new Date().getTime();    
		//TIEMPO PROCESO
		var tiempoProceso = new Date(proceso).getTime();				
		var distanceF = now - tiempoProceso;    
		var daysF = Math.floor(distanceF / (1000 * 60 * 60 * 24));
		var hoursF = Math.floor((distanceF % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutesF = Math.floor((distanceF % (1000 * 60 * 60)) / (1000 * 60));
		var secondsF = Math.floor((distanceF % (1000 * 60)) / 1000);

		if(hoursF < 10){ hoursF = "0" + hoursF; }
		if(minutesF < 10){ minutesF = "0" + minutesF; }
		if(secondsF < 10){ secondsF = "0" + secondsF; }
		
		document.getElementById("fcronoB" + b).innerHTML = hoursF + ":" + minutesF;

		//TIEMPO ETAPA
		var tiempoEtapa = new Date(etapa).getTime();				
		var distanceE = now - tiempoEtapa;    
		var daysE = Math.floor(distanceE / (1000 * 60 * 60 * 24));
		var hoursE = Math.floor((distanceE % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutesE = Math.floor((distanceE % (1000 * 60 * 60)) / (1000 * 60));
		var secondsE = Math.floor((distanceE % (1000 * 60)) / 1000);

		if(hoursE < 10){ hoursE = "0" + hoursE; }
		if(minutesE < 10){ minutesE = "0" + minutesE; }
		if(secondsE < 10){ secondsE = "0" + secondsE; }

		var minutosE = Number(hoursE)*60 + Number(minutesE);

		document.getElementById("ecronoB" + b).innerHTML = hoursE + ":" + minutesE + " (" + minutosE + ")";

		if(max > 0 && minutosE > max && clase != clases){

			document.getElementById("anclaB" + b).className = "parpadea " + clase;

		}
	}
}

function timer(b){

	try{

		crono(b);

	} catch(e){}

	setInterval(function() {

		try{

			crono(b);

		} catch(e){}

	}, 60000);
	
}

</script>

<div>		
	<div class="caja-form-header">
		<a href="javascript:void()" onClick="seccionHide()" title="Salir"><i class="fas fa-times"></i></a>
		<h2><i class="fas fa-truck"></i>Procesos</h2>
	</div>	
	<?php if($tipo == "ADMINISTRADOR" || $tipo == "BÁSICO" || $tipo == "PROCESO"  || $tipo == "CLIENTE"){ ?>
	<div id="caja-muelles" class="caja-form-section caja-scroll caja-bahias">			
		<?php include_once "procesos_muelles.php"; ?>
	</div>
	<?php } ?>
	<div class="caja-scroll caja-bahias-estados">	
		<div>
			<a class="estado0">disponible</a>	
			<a class="estado1">en muelle</a>		
			<a class="estado2">en proceso de des/cargue</a>	
			<a class="estado3">des/cargado</a>	
			<a class="estado4">salida de muelle</a>
		</div>
	</div>
	<div class="caja-form-section fondo-tabla">				
		<?php if($tipo == "ADMINISTRADOR" || $tipo == "BÁSICO" || $tipo == "PROCESO"){ ?>
		<div id="nuevo" class="caja-fixed left0 caja-scroll capa3">
			<div class="caja-min caja-form animatetop">		
				<form id="form" method="post" enctype="multipart/form-data">
					<input type="hidden" placeholder="ID" id="id" name="id" required>	
					<div class="caja-form-header">
						<a href="javascript:void()" onClick="this.parentNode.parentNode.parentNode.parentNode.style.display='none'" title="Salir"><i class="fas fa-times"></i></a>
						<h2><i class="fas fa-truck"></i>Gestión de Proceso</h2>
					</div>		
					<div class="caja-form-section">				
						<div class="caja-fila-inputs">
							<div class="caja-inputs">
								<label>Muelle</label>
								<input type="text" id="muelle" name="muelle" readonly required>
							</div>
							<div class="caja-inputs">
								<label>Estado</label>
								<input type="text" id="estado" name="estado" value="DISPONIBLE" class="estado0" readonly>
							</div>
							<div class="caja-inputs">
								<label>Fecha</label>
								<input type="date" id="registro" name="registro" value="<?php echo date("Y-m-d"); ?>" required>
							</div>
							<div class="caja-inputs">
								<label>Líder</label>
								<select id="lider" name="lider" required>
									<option value="">Elige una opción...</option>
									<?php

										include "../conexion.php";

										$sql = "SELECT * 
												FROM lideres
												WHERE sw=1 AND proceso='PROCESO'
												ORDER BY nick";
										$resultado = $conexion->query($sql);

										if($resultado == true){

											while($fila = $resultado->fetch_assoc()){
												echo "<option value='" . $fila["id"] . "'>" . $fila["nick"] . "</option>";
											}	

											$resultado->free();

										} else{
											echo "Error al agregar líderes: " . $conexion->error;
										}

										$conexion->close();

									?>
								</select>
							</div>
						</div>
						<div class="caja-fila-inputs">
							<div class="caja-inputs">
								<label>Turno</label>
								<select id="turno" name="turno" required>
									<option value="">Elige una opción...</option>
									<?php

										include "../conexion.php";

										$sql = "SELECT * 
												FROM turnos
												WHERE sw=1
												ORDER BY turno";
										$resultado = $conexion->query($sql);

										if($resultado == true){

											while($fila = $resultado->fetch_assoc()){
												echo "<option value='" . $fila["id"] . "'>" . $fila["turno"] . "</option>";
											}	

											$resultado->free();

										} else{
											echo "Error al agregar turnos: " . $conexion->error;
										}

										$conexion->close();

									?>
								</select>
							</div>		
							<div class="caja-inputs">
								<label>Tipo de atención</label>
								<select id="atencion" name="atencion" onchange="tipoAtencion1(this.value)" required>
									<option value="">Elige una opción...</option>
									<option>CARGUE</option>
									<option>DESCARGUE</option>
								</select>
							</div>	
							<div class="caja-inputs">
								<label>Tipo de vehículo</label>
								<select id="vehiculo" name="vehiculo" required>
									<option value="">Elige una opción...</option>
									<?php

										include "../conexion.php";

										$sql = "SELECT * 
												FROM vehiculos
												WHERE sw=1
												ORDER BY vehiculo";
										$resultado = $conexion->query($sql);

										if($resultado == true){

											while($fila = $resultado->fetch_assoc()){
												echo "<option value='" . $fila["id"] . "'>" . $fila["vehiculo"] . "</option>";
											}	

											$resultado->free();

										} else{
											echo "Error al agregar vehículos: " . $conexion->error;
										}

										$conexion->close();

									?>
								</select>
							</div>
							<div class="caja-inputs">
								<label>Placa</label>
								<input type="text" id="placa" name="placa" onChange="this.value=(this.value).toUpperCase()" style="text-transform:uppercase">
							</div>
						</div>
						<div class="caja-fila-inputs">	
							<div class="caja-inputs" id="caja-TR">
								<label>Traslado / Remisión</label>
								<input type="text" id="tras_rem" name="tras_rem" onChange="this.value=(this.value).toUpperCase()" style="text-transform:uppercase" required>
							</div>
							<div class="caja-inputs" id="caja-TS">
								<label>Transporte Salida</label>
								<input type="text" id="transporteS" name="transporteS" onChange="this.value=(this.value).toUpperCase()" style="text-transform:uppercase" required>
							</div>
							<div class="caja-inputs" id="caja-PR">
								<label>Procedencia</label>
								<select id="procedencia" name="procedencia" required>
									<option value="">Elige una opción...</option>
									<?php

										include "../conexion.php";

										$sql = "SELECT * 
												FROM procedencias
												WHERE sw=1 AND procedencia<>'NO APLICA'
												ORDER BY procedencia";
										$resultado = $conexion->query($sql);

										if($resultado == true){

											while($fila = $resultado->fetch_assoc()){
												echo "<option value='" . $fila["id"] . "'>" . $fila["procedencia"] . "</option>";
											}	

											$resultado->free();

										} else{
											echo "Error al agregar procedencias: " . $conexion->error;
										}

										$conexion->close();

									?>
								</select>
							</div>
							<div class="caja-inputs" id="caja-DE">
								<label>Destino</label>
								<select id="destino" name="destino" required>
									<option value="">Elige una opción...</option>
									<?php

										include "../conexion.php";

										$sql = "SELECT * 
												FROM destinos
												WHERE sw=1 AND destino<>'NO APLICA'
												ORDER BY destino";
										$resultado = $conexion->query($sql);

										if($resultado == true){

											while($fila = $resultado->fetch_assoc()){
												echo "<option value='" . $fila["id"] . "'>" . $fila["destino"] . "</option>";
											}	

											$resultado->free();

										} else{
											echo "Error al agregar destinos: " . $conexion->error;
										}

										$conexion->close();

									?>
								</select>
							</div>
						</div>
						<div class="caja-fila-inputs">						
							<div class="caja-inputs">
								<label>Canal / Negocio</label>
								<select id="canal" name="canal" required>
									<option value="">Elige una opción...</option>
									<?php

										include "../conexion.php";

										$sql = "SELECT * 
												FROM canales
												WHERE sw=1
												ORDER BY canal";
										$resultado = $conexion->query($sql);

										if($resultado == true){

											while($fila = $resultado->fetch_assoc()){
												echo "<option value='" . $fila["id"] . "'>" . $fila["canal"] . "</option>";
											}	

											$resultado->free();

										} else{
											echo "Error al agregar canales: " . $conexion->error;
										}

										$conexion->close();

									?>
								</select>
							</div>					
							<div class="caja-inputs">
								<label>Tipo de carga</label>
								<select id="carga" name="carga" required>
									<option value="">Elige una opción...</option>
									<option>ARRUME NEGRO</option>
									<option>ESTIBADO</option>
								</select>
							</div>
							<div class="caja-inputs">
								<label>Estibas des/cargadas</label>
								<input type="number" id="estibas" name="estibas" value="0">
							</div>	
							<div class="caja-inputs">
								<label>Kilogramos des/cargados</label>
								<input type="number" id="toneladas" name="toneladas" value="0" min="0" max="999999" step="0.01">
							</div>
						</div>
						<div class="caja-fila-inputs">
							<div class="caja-inputs">
								<label>Cajas</label>
								<input type="number" id="cajas" name="cajas" value="0" min="0">
							</div>
							<div class="caja-inputs">
								<label>Operador logístico 1</label>
								<select id="operario1" name="operario1">
									<option value="">Elige una opción...</option>
									<?php

										include "../conexion.php";

										$sql = "SELECT * 
												FROM operarios
												WHERE sw=1 AND estado='Activo'
												ORDER BY apellido1, apellido2, nombre1, nombre2";
										$resultado = $conexion->query($sql);

										if($resultado == true){

											while($fila = $resultado->fetch_assoc()){

												$nombre_completo = trim($fila["apellido1"] . " " . $fila["apellido2"] . " " . $fila["nombre1"] . " " . $fila["nombre2"]);

												echo "<option>" . $nombre_completo . "</option>";
											}	

											$resultado->free();

										} else{
											echo "Error al agregar operarios: " . $conexion->error;
										}

										$conexion->close();

									?>
								</select>
							</div>	
							<div class="caja-inputs">
								<label>Operador logístico 2</label>
								<select id="operario2" name="operario2">
									<option value="">Elige una opción...</option>
									<?php

										include "../conexion.php";

										$sql = "SELECT * 
												FROM operarios
												WHERE sw=1 AND estado='Activo'
												ORDER BY apellido1, apellido2, nombre1, nombre2";
										$resultado = $conexion->query($sql);

										if($resultado == true){

											while($fila = $resultado->fetch_assoc()){

												$nombre_completo = trim($fila["apellido1"] . " " . $fila["apellido2"] . " " . $fila["nombre1"] . " " . $fila["nombre2"]);

												echo "<option>" . $nombre_completo . "</option>";
											}	

											$resultado->free();

										} else{
											echo "Error al agregar operarios: " . $conexion->error;
										}

										$conexion->close();

									?>
								</select>
							</div>	
							<div class="caja-inputs">
								<label>Operador logístico 3</label>
								<select id="operario3" name="operario3">
									<option value="">Elige una opción...</option>
									<?php

										include "../conexion.php";

										$sql = "SELECT * 
												FROM operarios
												WHERE sw=1 AND estado='Activo'
												ORDER BY apellido1, apellido2, nombre1, nombre2";
										$resultado = $conexion->query($sql);

										if($resultado == true){

											while($fila = $resultado->fetch_assoc()){

												$nombre_completo = trim($fila["apellido1"] . " " . $fila["apellido2"] . " " . $fila["nombre1"] . " " . $fila["nombre2"]);

												echo "<option>" . $nombre_completo . "</option>";
											}	

											$resultado->free();

										} else{
											echo "Error al agregar operarios: " . $conexion->error;
										}

										$conexion->close();

									?>
								</select>
							</div>	
						</div>
						<div class="caja-fila-inputs">
							<div class="caja-inputs" id="caja-e1">
								<label>Vehículo en muelle</label>
								<input type="datetime-local" id="e1" name="e1" onChange="maxFecha(1)" required>
							</div>
							<div class="caja-inputs" id="caja-e2">
								<label>En proceso de des/cargue</label>
								<input type="datetime-local" id="e2" name="e2" onChange="maxFecha(2)">
							</div>
							<div class="caja-inputs" id="caja-e3">
								<label>Vehículo des/cargado</label>
								<input type="datetime-local" id="e3" name="e3" onChange="maxFecha(3)">
							</div>
							<div class="caja-inputs" id="caja-e4">
								<label>Salida de muelle</label>
								<input type="datetime-local" id="e4" name="e4" onChange="maxFecha(4)">
							</div>
						</div>
						<div class="caja-fila-inputs">
							<div class="caja-inputs" style="width: 100%">
								<label>Observaciones</label>
								<textarea id="observaciones" name="observaciones"></textarea>
							</div>
						</div>						
					</div>
					<div class="caja-form-footer">
						<input type="button" value="Cancelar" onClick="this.parentNode.parentNode.parentNode.parentNode.style.display='none'">
						<input type="submit" value="Guardar" class="der">	
					</div>					
				</form>
				<form id="formTiempo" method="post" enctype="multipart/form-data">
					<input type="hidden" placeholder="ID" id="idTiempo" name="idTiempo" required>	
					<div class="caja-form-section" style="border-top: 1px solid #DEDEDE;">		
						<div class="caja-fila-inputs">
							<div class="caja-inputs">
								<label>Causal</label>
								<select id="causal" name="causal" required>
									<option value="">Elige una opción...</option>
									<?php

										include "../conexion.php";

										$sql = "SELECT * 
												FROM causales
												WHERE sw=1
												ORDER BY proceso ASC, causal ASC";
										$resultado = $conexion->query($sql);

										if($resultado == true){

											while($fila = $resultado->fetch_assoc()){
												echo "<option value='" . $fila["id"] . "'>" . $fila["proceso"] . ": " . $fila["causal"] . "</option>";
											}	

											$resultado->free();

										} else{
											echo "Error al agregar causales: " . $conexion->error;
										}

										$conexion->close();

									?>
								</select>
							</div>
							<div class="caja-inputs">
								<label>Minutos</label>
								<input type="number" id="minutos" name="minutos" min="1" required>
							</div>
							<div class="caja-inputs">
								<label>&nbsp</label>
								<input type="submit" value="Agregar" style="width: auto">
							</div>
							<div class="caja-inputs" style="width: 100%">
								<label>Tiempos perdidos</label>
								<div id="tiempos" class="caja-tiempos"></div>
							</div>
						</div>
					</div>
				</form>
			</div>				
		</div>				
		<?php } ?>	
		<div class="caja-tabla">
			<div class="caja-tabla-filtro">
				<div>
					<input type="search" id="consulta" placeholder="¿Qué quieres buscar?" oninput="tablear()">
				</div>
			</div>
			<div class="caja-tabla-tabla">
				<div class="caja-scroll" style="width: 4000px">
					<table id="tabla">
						<thead>
							<tr>
								<th><a>Estado</a></th>
								<th><a>Registro</a></th>
								<th><a>Líder</a></th>
								<th><a>Turno</a></th>
								<th><a>Muelle</a></th>
								<th><a>Tipo de atención</a></th>
								<th><a>Vehículo</a></th>
								<th><a>Placa</a></th>
								<th><a>Tras. / Remis.</a></th>
								<th><a>Transp. Salida</a></th>
								<th><a>Procedencia</a></th>
								<th><a>Destino</a></th>
								<th><a>Canal / Negocio</a></th>
								<th><a>Tipo de carga</a></th>
								<th><a>Estibas</a></th>
								<th><a>Kilogramos</a></th>
								<th><a>Cajas</a></th>
								<th><a>Operador logístico 1</a></th>
								<th><a>Operador logístico 2</a></th>
								<th><a>Operador logístico 3</a></th>
								<th><a>E1</a></th>
								<th><a>E2</a></th>
								<th><a>E3</a></th>
								<th><a>E4</a></th>
								<th><a>Des/cargue (min)</a></th>
								<th><a>En muelle (min)</a></th>
								<th><a title="Tiempos perdidos">TP</a></th>
								<th><a>Observaciones</a></th>
								<th><a></a></th>
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
	
	<script>

	tablear();

	function tablear(){

		var limite = document.getElementById("limite").value;
		var pagina = document.getElementById("pagina").value;
		var consulta = document.getElementById("consulta").value;

		$.ajax({
			url: "tables/procesos_filas_sec.php",
			type: "POST",
			dataType: "HTML",
			data: {limite: limite, consulta: consulta}
		})
		.done(function(maximo){
			$("#maximo").val(maximo);
		});

		$.ajax({
			url: "tables/procesos_tabla_sec.php",
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

		document.getElementById("formTiempo").reset();	
		buscarTiempos(id);

		$.ajax({
			url: "queries/info_proceso.php",
			type: "POST",
			dataType: "JSON",
			data: {id: id}
		})
		.done(function(info){

			var estado = info[0].estado;
			var registro = info[0].registro;
			var lider = info[0].lider;
			var turno = info[0].turno;
			var muelle = info[0].muelle;
			var atencion = info[0].atencion;
			var vehiculo = info[0].vehiculo;
			var placa = info[0].placa;
			var procedencia = info[0].procedencia;
			var destino = info[0].destino;
			var tras_rem = info[0].tras_rem;
			var transporteS = info[0].transporteS;
			var canal = info[0].canal;
			var carga = info[0].carga;
			var estibas = info[0].estibas;
			var toneladas = info[0].toneladas;
			var cajas = info[0].cajas;
			var operario1 = info[0].operario1;
			var operario2 = info[0].operario2;
			var operario3 = info[0].operario3;
			var e1 = info[0].e1;
			var e2 = info[0].e2;
			var e3 = info[0].e3;
			var e4 = info[0].e4;
			var observaciones = info[0].observaciones;

			$("#id").val(id);
			$("#idTiempo").val(id);
			$("#estado").val(estado);

			cambioEstado(estado);

			$("#registro").val(registro);
			$("#lider").val(lider);
			$("#turno").val(turno);
			$("#muelle").val(muelle);
			$("#atencion").val(atencion);

			tipoAtencion2(atencion);

			$("#vehiculo").val(vehiculo);
			$("#placa").val(placa);
			$("#procedencia").val(procedencia);
			$("#destino").val(destino);
			$("#tras_rem").val(tras_rem);
			$("#transporteS").val(transporteS);
			$("#canal").val(canal);
			$("#carga").val(carga);
			$("#estibas").val(estibas);
			$("#toneladas").val(toneladas);
			$("#cajas").val(cajas);
			$("#operario1").val(operario1);
			$("#operario2").val(operario2);
			$("#operario3").val(operario3);
			$("#e1").val(e1);
			$("#e2").val(e2);
			$("#e3").val(e3);
			$("#e4").val(e4);

			minFecha();

			$("#observaciones").val(observaciones);
			$("#nuevo").show();

		});
	}
		
	//GUARDAR PROCESO

	$("#form").on("submit", function(e){

		e.preventDefault();

		var formData = new FormData(document.getElementById("form"));		

		$.ajax({
			url: "models/guardar_proceso.php",
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
			$("#caja-muelles").load("views/procesos_muelles.php");

			tablear();		
			
		})

	});
		
	//NUEVO PROCESO
		
	function nuevoProceso(a){
				
		var muelle = a.dataset.muelle;
		var lider = document.getElementById("lider").value;	
		var turno = document.getElementById("turno").value;	
		
		document.getElementById("form").reset();
		document.getElementById("formTiempo").reset();	
		document.getElementById("tiempos").innerHTML = "";	
		document.getElementById("id").value = "";	
		document.getElementById("idTiempo").value = "";	
		document.getElementById("muelle").value = muelle;	
		document.getElementById("lider").value = lider;
		document.getElementById("turno").value = turno;

		autoFecha();
		cambioEstado("");
		tipoAtencion1("");

		w3.show("#nuevo");		
		
	}

	function cambioEstado(e){

		var clase = "estado0";

		if(e == "EN MUELLE"){ clase = "estado1"; }
		if(e == "EN PROCESO DE DES/CARGUE"){ clase = "estado2"; }
		if(e == "DES/CARGADO"){ clase = "estado3"; }
		if(e == "SALIDA DE MUELLE"){ clase = "estado4"; }

		document.getElementById("estado").className = clase;

	}

	function maxFecha(e){

		var tipo = "<?php echo $tipo; ?>";
		var t = document.getElementById("e" + e).value;
		var countDownDate = new Date(t).getTime();
		var now = new Date().getTime();    
		var distance = now - countDownDate;    
		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		var tiempo = days*24*60 + hours*60 + minutes;
		var margen = 480;

		if(tipo != "ADMINISTRADOR" && (tiempo < -1 || tiempo > margen)){

			document.getElementById("e" + e).value = "";

		}

		minFecha();

	}	

	function minFecha(){

		var e1 = document.getElementById("e1").value;
		var e2 = document.getElementById("e2").value;
		var e3 = document.getElementById("e3").value;
		var e4 = document.getElementById("e4").value;

		if(e4 != ""){

			document.getElementById("e2").min = e1;
			document.getElementById("e3").min = e2;
			document.getElementById("e4").min = e3;

		} else{

			document.getElementById("e2").min = "";
			document.getElementById("e3").min = "";
			document.getElementById("e4").min = "";

		}
	}

	function tipoAtencion1(tipo){

		document.getElementById("vehiculo").value = "";

		tipoAtencion2(tipo);

	}

	function tipoAtencion2(tipo){

		document.getElementById("tras_rem").required = true;
		document.getElementById("transporteS").required = true;
		document.getElementById("procedencia").required = true;
		document.getElementById("destino").required = true;
		document.getElementById("caja-TR").style.display = "block";
		document.getElementById("caja-TS").style.display = "block";
		document.getElementById("caja-PR").style.display = "block";	
		document.getElementById("caja-DE").style.display = "block";	
		document.getElementById("caja-e1").style.display = "block";
		document.getElementById("caja-e2").style.display = "block";
		document.getElementById("caja-e3").style.display = "block";
		document.getElementById("caja-e4").style.display = "block";

		if(tipo == "DESCARGUE"){

			document.getElementById("caja-DE").style.display = "none";
			document.getElementById("destino").required = false;
			document.getElementById("destino").value = "";

			document.getElementById("caja-TS").style.display = "none";	
			document.getElementById("transporteS").required = false;
			document.getElementById("transporteS").value = "";

		}	
		if(tipo == "CARGUE"){

			document.getElementById("caja-PR").style.display = "none";	
			document.getElementById("procedencia").required = false;
			document.getElementById("procedencia").value = "";

			document.getElementById("caja-TR").style.display = "none";
			document.getElementById("tras_rem").required = false;
			document.getElementById("tras_rem").value = "";		

		}
	}

	// GUARDAR TIEMPO

	$("#formTiempo").on("submit", function(e){

		e.preventDefault();

		var formData = new FormData(document.getElementById("formTiempo"));			

		$.ajax({
			url: "models/guardar_proceso_tiempo.php",
			type: "POST",
			dataType: "html",
			data: formData,
			cache: false,
			contentType: false,
			processData: false
		})
		.done(function(sms){

			var id = document.getElementById("idTiempo").value;

			buscarTiempos(id);
			
			$("#caja-confirmacion").hide();
			$("#mensaje").html(sms);
			$("#caja-mensaje").show();
			$("#caja-alert").show();

			tablear();	
			
		});

	});

	//ELIMINAR TIEMPO

	function eliminarTiempo(a){
	
		var id = a.dataset.id;
		var elemento = a.dataset.elemento;
		var tabla = a.dataset.tabla;

		$("#caja-mensaje").hide();
		$("#mensaje").html("");
		$("#caja-alert").show();
		$("#confirmacion").html("¿Deseas eliminar el siguiente registro?<br><br>" + elemento);	
		$("#btn-confirmacion").click(function(){	  
			$.ajax({
				url: "models/eliminar_tiempo.php",
				type: "POST",
				dataType: "HTML",
				data: {id: id, tabla: tabla}
			})
			.done(function(sms){
				
				var id = document.getElementById("idTiempo").value;

				buscarTiempos(id);

				$("#mensaje").html(sms);
				$("#caja-mensaje").show();
				$("#caja-confirmacion").hide();

				tablear();	
				
			});	
		})
		$("#caja-confirmacion").show();

	}

	function buscarTiempos(proceso){

		$.ajax({
			url: "views/procesos_tiempos.php",
			type: "POST",
			dataType: "HTML",
			data: {proceso: proceso}
		})
		.done(function(caja){
			$("#tiempos").html(caja);
		});

	}

	function autoFecha(){

		var fecha = new Date();
		var hora = fecha.getHours();

		if(hora >= 0 && hora < 6){

			fecha.setDate(fecha.getDate()-1);

		}

		var dia = fecha.getDate();
		var mes = fecha.getMonth() + 1;
		var anio = fecha.getFullYear();

		if(dia < 10){ dia = "0" + dia; }
		if(mes < 10){ mes = "0" + mes; }

		document.getElementById("registro").value = anio + "-" + mes + "-" + dia;
	}

	</script>
</div>
