	<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = $_SESSION["url_base"];

if(!isset($id) || ($tipo != "ADMINISTRADOR" && $tipo != "PROCESO" && $tipo != "CLIENTE")){
	
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

?>

<div>		
	<div class="caja-form-header">
		<a href="javascript:void()" onClick="seccionHide()" title="Salir"><i class="fas fa-times"></i></a>
		<h2><i class="fas fa-chart-line"></i>Estadísticas</h2>
	</div>
	<div class="caja-form-section fondo-tabla">	
		<div class="caja-fila-graficas">
			<!-- GRÁFICA 3: ATENCIONES POR DÍA -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG3" name="inicioG3" value="<?php $dias = -10; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica3()">
						<input type="date" id="finG3" name="finG3" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica3()">
						<select id="turnoG3" name="turnoG3" onChange="verGrafica3()">
							<option value="">Turno</option>
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
						<select id="canalG3" name="canalG3" onChange="verGrafica3()" style="max-width: 140px">
							<option value="">Canal / Negocio</option>
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
						<select id="vehiculoG3" name="vehiculoG3" onChange="verGrafica3()">
							<option value="">Vehículo</option>
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
				</div>
				<div class="caja-graficas-graficas caja-scroll">
					<div id="grafica3" class="caja-grafica"></div>
				</div>
			</div>
			<!-- GRÁFICA 13: TIEMPO PROMEDIO DE ATENCIÓN CARGUE Y DESCARGUE -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG13" name="inicioG13" value="<?php $dias = -10; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica13()">
						<input type="date" id="finG13" name="finG13" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica13()">
						<select id="canalG13" name="canalG13" onChange="verGrafica13()" style="max-width: 140px">
							<option value="">Canal / Negocio</option>
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
				</div>
				<div class="caja-graficas-graficas caja-scroll">
					<div id="grafica13" class="caja-grafica"></div>
				</div>
			</div>	
			<!-- GRÁFICA 15: TIEMPO PROMEDIO DE ATENCIÓN Y EN MUELLE -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG15" name="inicioG15" value="<?php $dias = -10; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica15()">
						<input type="date" id="finG15" name="finG15" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica15()">
						<select id="canalG15" name="canalG15" onChange="verGrafica15()" style="max-width: 140px">
							<option value="">Canal / Negocio</option>
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
				</div>
				<div class="caja-graficas-graficas caja-scroll">
					<div id="grafica15" class="caja-grafica"></div>
				</div>
			</div>	
			<!-- GRÁFICA 12: ESTIBAS DES/CARGADAS -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG12" name="inicioG12" value="<?php $dias = -10; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica12()">
						<input type="date" id="finG12" name="finG12" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica12()">
					</div>
				</div>
				<div class="caja-graficas-graficas caja-scroll">
					<div id="grafica12" class="caja-grafica"></div>
				</div>
			</div>	
			<!-- GRÁFICA 10: TONELADAS DES/CARGADAS -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG10" name="inicioG10" value="<?php $dias = -10; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica10()">
						<input type="date" id="finG10" name="finG10" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica10()">
					</div>
				</div>
				<div class="caja-graficas-graficas caja-scroll">
					<div id="grafica10" class="caja-grafica"></div>
				</div>
			</div>	
			<!-- GRÁFICA 16: CAJAS DES/CARGADAS -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG16" name="inicioG16" value="<?php $dias = -10; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica16()">
						<input type="date" id="finG16" name="finG16" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica16()">
					</div>
				</div>
				<div class="caja-graficas-graficas caja-scroll">
					<div id="grafica16" class="caja-grafica"></div>
				</div>
			</div>	
			<!-- GRÁFICA 11: PRODUCTIVIDAD DE DES/CARGUE - TONELADAS -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<select id="anioG11" onchange="verGrafica11()" title="Año">
							<?php

							$anio1 = 2021;
							$anio2 = date("Y");

							for($i = $anio1; $i <= $anio2; $i++){

								if($i != $anio2){

									echo "<option>" . $i . "</option>";

								} else{

									echo "<option selected>" . $i . "</option>";
								
								}
							}

							?>
						</select>	
						<select id="turnoG11" name="turnoG11" onChange="verGrafica11()">
							<option value="">Turno</option>
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
						<select id="vehiculoG11" name="vehiculoG11" onChange="verGrafica11()">
							<option value="">Vehículo</option>
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
						<select id="cargaG11" name="cargaG11" onChange="verGrafica11()">
							<option value="">Tipo de carga</option>
							<option>ARRUME NEGRO</option>
							<option>ESTIBADO</option>
						</select>
					</div>
				</div>
				<div class="caja-graficas-graficas caja-scroll">
					<div id="grafica11" class="caja-grafica"></div>
				</div>
			</div>	
			<!-- GRÁFICA 18: PRODUCTIVIDAD DE DES/CARGUE - CAJAS -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<select id="anioG18" onchange="verGrafica18()" title="Año">
							<?php

							$anio1 = 2021;
							$anio2 = date("Y");

							for($i = $anio1; $i <= $anio2; $i++){

								if($i != $anio2){

									echo "<option>" . $i . "</option>";

								} else{

									echo "<option selected>" . $i . "</option>";
								
								}
							}

							?>
						</select>	
						<select id="turnoG18" name="turnoG18" onChange="verGrafica18()">
							<option value="">Turno</option>
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
						<select id="vehiculoG18" name="vehiculoG18" onChange="verGrafica18()">
							<option value="">Vehículo</option>
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
						<select id="cargaG18" name="cargaG18" onChange="verGrafica18()">
							<option value="">Tipo de carga</option>
							<option>ARRUME NEGRO</option>
							<option>ESTIBADO</option>
						</select>
					</div>
				</div>
				<div class="caja-graficas-graficas caja-scroll">
					<div id="grafica18" class="caja-grafica"></div>
				</div>
			</div>	
			<!-- GRÁFICA 17: OCUPACIÓN CARGUE - ATENCIÓN Y EN MUELLE -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<select id="anioG17" onchange="verGrafica17()" title="Año">
							<?php

							$anio1 = 2021;
							$anio2 = date("Y");

							for($i = $anio1; $i <= $anio2; $i++){

								if($i != $anio2){

									echo "<option>" . $i . "</option>";

								} else{

									echo "<option selected>" . $i . "</option>";
								
								}
							}

							?>
						</select>	
					</div>
				</div>
				<div class="caja-graficas-graficas caja-scroll">
					<div id="grafica17" class="caja-grafica"></div>
				</div>
			</div>			
		</div>
	</div>
	<div class="caja-form-footer">

	</div>
</div>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>

function graficaDeBarras(id, categorias, datos, titulo, unidad, serie){

	var options = {
		series: [{
			name: serie,
			data: datos
		}], 
		chart: {
			height: 360,
			type: 'bar',
		},
		colors: ['#41B883'],
		plotOptions: {
			bar: {
					dataLabels: {
						position: 'top'
					},
				}
		},
		dataLabels: {
			enabled: true,
			offsetY: -20,
			style: {
				fontSize: '12px',
				colors: ["#0c6037"]
			}
		},        
		xaxis: {
			categories: categorias,
			position: 'bottom',
			axisBorder: {
				show: false
			},
			axisTicks: {
				show: false
			},
			crosshairs: {
				fill: {
					type: 'gradient',
					gradient: {
						colorFrom: '#b3dac7',
						colorTo: '#a8e1c5',
						stops: [0, 100],
						opacityFrom: 0.4,
						opacityTo: 0.5,
					}
				}
			},
			tooltip: {
				enabled: true,
			}
		},
		yaxis: [
			{
				axisTicks: {
					show: true
				},
				axisBorder: {
					show: false
				},
				title: {
					text: unidad,
					style: {
						color: '#444',
					}
				}
			}
		],
		title: {
			text: titulo,
			floating: true,
			offsetY: 0,
			align: 'center',
			style: {
				color: '#444'
			}
		},
		legend: {
			show: true,
			position: 'top'
		}
	};

	var chart = new ApexCharts(document.querySelector("#grafica" + id), options);
	chart.render();

}

function graficaDeBarrasCombinada(datos1, datos2, titulo, metrica, categorias, serie1, serie2, id){ 
		
	var options = {
		series: [
			{
				name: serie1,
				type: 'column',
				data: datos1
			}, {
				name: serie2,
				type: 'column',
				data: datos2
			}
		],
		chart: {
			height: 350,
			type: 'line',
			stacked: false
		},
		dataLabels: {
			enabled: true,
			offsetY: -10,
			style: {
				fontSize: '11px'
			},
			background: {
				enabled: false
			}
		},
		colors: ["#41B883", "#e99f48"],
		stroke: {
			width: [1, 1]
		},
		plotOptions: {
			bar: {
				columnWidth: "70%"
			}
		},
		title: {
			text: titulo,
			align: 'center',
			offsetX: 0
		},
		xaxis: {
			categories: categorias,
		},
		yaxis: [
			{
				seriesName: serie1,
				axisTicks: {
					show: true,
				},
				axisBorder: {
					show: false
				},
				labels: {
				style: {
					colors: '#444',
				}
				},
				title: {
					text: metrica,
					style: {
						color: '#444',
					}
				},
				tooltip: {
					enabled: true
				}
			},
			{
				seriesName: serie1,
				show: false,
			}
		],
		tooltip: {
			shared: true,
			interset: true,
			x: {
				show: true
			}
		},
		legend: {
			horizontalAlign: 'center',
			offsetX: 0
		}
	};

	var chart = new ApexCharts(document.querySelector("#grafica" + id), options);
	chart.render();
	
}

function verGrafica3(){
		
	document.getElementById("grafica3").innerHTML = "";
	
	var inicio = document.getElementById("inicioG3").value;
	var fin = document.getElementById("finG3").value;
	var turno = document.getElementById("turnoG3").value;
	var canal = document.getElementById("canalG3").value;
	var vehiculo = document.getElementById("vehiculoG3").value;

	$.ajax({
		url: "graphics/grafica_procesos3.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin, turno: turno, canal: canal, vehiculo: vehiculo}
	})
	.done(function(info){

		var categorias = [];
		var datos1 = [];
		var datos2 = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var cargue = info[i].cargue;
			var descargue = info[i].descargue;

			categorias.push(String(registro));
			datos1.push(cargue);
			datos2.push(descargue);

		}

		graficaDeBarrasCombinada(datos1, datos2, "Vehículos atendidos", "# Vehículos", categorias, "Cargue", "Descargue", 3);

	});		
}

function verGrafica13(){
		
	document.getElementById("grafica13").innerHTML = "";
	
	var inicio = document.getElementById("inicioG13").value;
	var fin = document.getElementById("finG13").value;
	var canal = document.getElementById("canalG13").value;

	$.ajax({
		url: "graphics/grafica_procesos13.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin, canal: canal}
	})
	.done(function(info){

		var categorias = [];
		var datos1 = [];
		var datos2 = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var cargue = info[i].cargue;
			var descargue = info[i].descargue;

			categorias.push(String(registro));
			datos1.push(cargue);
			datos2.push(descargue);

		}

		graficaDeBarrasCombinada(datos1, datos2, "Tiempos promedio - Cargue vs Descargue", "Minutos", categorias, "Cargue", "Descargue", 13);

	});		
}

function verGrafica15(){
		
	document.getElementById("grafica15").innerHTML = "";
	
	var inicio = document.getElementById("inicioG15").value;
	var fin = document.getElementById("finG15").value;
	var canal = document.getElementById("canalG15").value;

	$.ajax({
		url: "graphics/grafica_procesos15.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin, canal: canal}
	})
	.done(function(info){

		var categorias = [];
		var datos1 = [];
		var datos2 = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var des_cargue = info[i].des_cargue;
			var enanden = info[i].enanden;

			categorias.push(String(registro));
			datos1.push(des_cargue);
			datos2.push(enanden);

		}

		graficaDeBarrasCombinada(datos1, datos2, "Tiempos promedio - Atención vs En muelle", "Minutos", categorias, "Atención", "En muelle", 15);

	});		
}

function verGrafica12(){
		
	document.getElementById("grafica12").innerHTML = "";
	
	var inicio = document.getElementById("inicioG12").value;
	var fin = document.getElementById("finG12").value;

	$.ajax({
		url: "graphics/grafica_procesos12.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin}
	})	
	.done(function(info){

		var categorias = [];
		var datos1 = [];
		var datos2 = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var cargue = info[i].cargue;
			var descargue = info[i].descargue;

			categorias.push(String(registro));
			datos1.push(cargue);
			datos2.push(descargue);

		}

		graficaDeBarrasCombinada(datos1, datos2, "Estibas movidas", "Estibas", categorias, "Cargue", "Descargue", 12);

	});	
}

function verGrafica10(){
		
	document.getElementById("grafica10").innerHTML = "";
	
	var inicio = document.getElementById("inicioG10").value;
	var fin = document.getElementById("finG10").value;

	$.ajax({
		url: "graphics/grafica_procesos10.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin}
	})	
	.done(function(info){

		var categorias = [];
		var datos1 = [];
		var datos2 = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var cargue = info[i].cargue;
			var descargue = info[i].descargue;

			categorias.push(String(registro));
			datos1.push(cargue);
			datos2.push(descargue);

		}

		graficaDeBarrasCombinada(datos1, datos2, "Toneladas movidas", "Toneladas", categorias, "Cargue", "Descargue", 10);

	});	
}

function verGrafica16(){
		
	document.getElementById("grafica16").innerHTML = "";
	
	var inicio = document.getElementById("inicioG16").value;
	var fin = document.getElementById("finG16").value;

	$.ajax({
		url: "graphics/grafica_procesos16.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin}
	})	
	.done(function(info){

		var categorias = [];
		var datos1 = [];
		var datos2 = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var cargue = info[i].cargue;
			var descargue = info[i].descargue;

			categorias.push(String(registro));
			datos1.push(cargue);
			datos2.push(descargue);

		}

		graficaDeBarrasCombinada(datos1, datos2, "Cajas movidas", "Cajas", categorias, "Cargue", "Descargue", 16);

	});	
}

function verGrafica11(){
		
	document.getElementById("grafica11").innerHTML = "";
	
	var anio = document.getElementById("anioG11").value;
	var turno = document.getElementById("turnoG11").value;
	var vehiculo = document.getElementById("vehiculoG11").value;
	var carga = document.getElementById("cargaG11").value;

	$.ajax({
		url: "graphics/grafica_procesos11.php",
		type: "POST",
		dataType: "JSON",
		data: {anio: anio, turno: turno, vehiculo: vehiculo, carga: carga}
	})
	.done(function(info){

		var categorias = [];
		var datos1 = [];
		var datos2 = [];

		for(var i = 0; i < info.length; i++){

			var mes = info[i].mes;
			var cargue = info[i].cargue;
			var descargue = info[i].descargue;

			categorias.push(mes);
			datos1.push(cargue);
			datos2.push(descargue);

		}

		graficaDeBarrasCombinada(datos1, datos2, "Productividad Toneladas (ton/hora)", "ton/hora", categorias, "Cargue", "Descargue", 11);

	});		
}

function verGrafica18(){
		
	document.getElementById("grafica18").innerHTML = "";
	
	var anio = document.getElementById("anioG18").value;
	var turno = document.getElementById("turnoG18").value;
	var vehiculo = document.getElementById("vehiculoG18").value;
	var carga = document.getElementById("cargaG18").value;

	$.ajax({
		url: "graphics/grafica_procesos18.php",
		type: "POST",
		dataType: "JSON",
		data: {anio: anio, turno: turno, vehiculo: vehiculo, carga: carga}
	})
	.done(function(info){

		var categorias = [];
		var datos1 = [];
		var datos2 = [];

		for(var i = 0; i < info.length; i++){

			var mes = info[i].mes;
			var cargue = info[i].cargue;
			var descargue = info[i].descargue;

			categorias.push(mes);
			datos1.push(cargue);
			datos2.push(descargue);

		}

		graficaDeBarrasCombinada(datos1, datos2, "Productividad Cajas (cajas/hora)", "cajas/hora", categorias, "Cargue", "Descargue", 18);

	});		
}

function verGrafica17(){
		
	document.getElementById("grafica17").innerHTML = "";
	
	var anio = document.getElementById("anioG17").value;

	$.ajax({
		url: "graphics/grafica_procesos17.php",
		type: "POST",
		dataType: "JSON",
		data: {anio: anio}
	})
	.done(function(info){

		var categorias = [];
		var datos1 = [];
		var datos2 = [];

		for(var i = 0; i < info.length; i++){

			var mes = info[i].mes;
			var cargue = info[i].cargue;
			var descargue = info[i].descargue;

			categorias.push(mes);
			datos1.push(cargue);
			datos2.push(descargue);

		}

		graficaDeBarrasCombinada(datos1, datos2, "% Ocupación - Cargue vs Descargue", "Porcentaje", categorias, "Cargue", "Descargue", 17);

	});		
}

verGrafica3();
verGrafica13();	
verGrafica15();		
verGrafica12();	
verGrafica10();	
verGrafica16();	
verGrafica11();	
verGrafica18();	
verGrafica17();	
	
</script>