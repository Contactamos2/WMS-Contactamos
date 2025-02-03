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
			<!-- GRÁFICA 1: TOTAL ATENCIONES -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG1" name="inicioG1" value="<?php $dias = -30; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica1()">
						<input type="date" id="finG1" name="finG1" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica1()">
					</div>
				</div>
				<div class="caja-graficas-graficas caja-scroll">
					<div>
						<a href="Javascript:void()" onClick="verGrafica1()" class="titulo-grafica">Vehículos atendidos (Cargue)</a>
					</div>
					<div id="grafica1" class="caja-grafica"></div>
					<div>
						<a style="background-color: #099EAB"># Vehículos</a>
					</div>
				</div>
			</div>
			<!-- GRÁFICA 2: CARGUES Y DESCARGUES -->
			<!--<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG2" name="inicioG2" value="<?php $dias = -30; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica2()">
						<input type="date" id="finG2" name="finG2" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica2()">
					</div>
				</div>
				<div class="caja-graficas-graficas caja-scroll">
					<div>
						<a href="Javascript:void()" onClick="verGrafica2()" class="titulo-grafica">Descargues y Cargues</a>
					</div>
					<div id="grafica2" class="caja-grafica"></div>
					<div>
						<a style="background-color: #da878e">Descargues</a>
						<a style="background-color: #AA3C45">Cargues</a>
					</div>
				</div>
			</div>-->
			<!-- GRÁFICA 9: ATENCIONES POR CANAL -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG9" name="inicioG9" value="<?php $dias = -30; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica9()">
						<input type="date" id="finG9" name="finG9" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica9()">
						<select id="canalG9" name="canalG9" onChange="verGrafica9()" style="max-width: 140px">
							<option value="">Canal</option>
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
					<div>
						<a href="Javascript:void()" onClick="verGrafica9()" class="titulo-grafica">Vehículos atendidos por Canal</a>
					</div>
					<div id="grafica9" class="caja-grafica"></div>
					<div>
						<a style="background-color: #134f5c"># Vehículos</a>
					</div>
				</div>
			</div>	
			<!-- GRÁFICA 5: ATENCIONES POR LÍDER -->
			<!--<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG5" name="inicioG5" value="<?php $dias = -30; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica5()">
						<input type="date" id="finG5" name="finG5" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica5()">
						<select id="liderG5" name="liderG5" onChange="verGrafica5()">
							<option value="">Líder</option>
							<?php

								include "../conexion.php";

								$sql = "SELECT * 
										FROM lideres
										WHERE sw=1
										ORDER BY nick";
								$resultado = $conexion->query($sql);

								if($resultado == true){

									while($fila = $resultado->fetch_assoc()){
										if($fila["proceso"] == "PROCESO"){
											echo "<option value='" . $fila["id"] . "'>" . $fila["nick"] . "</option>";
										}
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
				<div class="caja-graficas-graficas caja-scroll">
					<div>
						<a href="Javascript:void()" onClick="verGrafica5()" class="titulo-grafica">Atenciones por Líder</a>
					</div>
					<div id="grafica5" class="caja-grafica"></div>
					<div>
						<a style="background-color: #00C968"># Vehículos</a>
					</div>
				</div>
			</div>-->
			<!-- GRÁFICA 3: ATENCIONES POR TURNO / CANAL -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG3" name="inicioG3" value="<?php $dias = -30; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica3()">
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
							<option value="">Canal</option>
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
					<div>
						<a href="Javascript:void()" onClick="verGrafica3()" class="titulo-grafica">Vehículos atendidos por Turno / Canal</a>
					</div>
					<div id="grafica3" class="caja-grafica"></div>
					<div>
						<a style="background-color: #E69138"># Vehículos</a>
					</div>
				</div>
			</div>
			<!-- GRÁFICA 4: ATENCIONES POR VEHÍCULO -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG4" name="inicioG4" value="<?php $dias = -30; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica4()">
						<input type="date" id="finG4" name="finG4" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica4()">
						<select id="vehiculoG4" name="vehiculoG4" onChange="verGrafica4()">
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
					<div>
						<a href="Javascript:void()" onClick="verGrafica4()" class="titulo-grafica">Atenciones por Tipo de vehículo</a>
					</div>
					<div id="grafica4" class="caja-grafica"></div>
					<div>
						<a style="background-color: #654587"># Vehículos</a>
					</div>
				</div>
			</div>	
			<!-- GRÁFICA 6: PROMEDIO DE TIEMPO DESCARGUE Y EN ANDÉN CON TP -->
			<!--<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG6" name="inicioG6" value="<?php $dias = -30; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica6()">
						<input type="date" id="finG6" name="finG6" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica6()">
						<select id="canalG6" name="canalG6" onChange="verGrafica6()" style="max-width: 140px">
							<option value="">Canal</option>
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
					<div>
						<a href="Javascript:void()" onClick="verGrafica6()" class="titulo-grafica">Tiempos promedio de atención con TP</a>
					</div>
					<div id="grafica6" class="caja-grafica"></div>
					<div>
						<a style="background-color: #dbce14">En muelle</a>
						<a style="background-color: #b2a700">Descargue</a>
					</div>
				</div>
			</div>-->	
			<!-- GRÁFICA 7: PROMEDIO DE TIEMPO DESCARGUE Y EN ANDÉN SIN TP -->
			<!--<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG7" name="inicioG7" value="<?php $dias = -30; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica7()">
						<input type="date" id="finG7" name="finG7" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica7()">
						<select id="canalG7" name="canalG7" onChange="verGrafica7()" style="max-width: 140px">
							<option value="">Canal</option>
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
					<div>
						<a href="Javascript:void()" onClick="verGrafica7()" class="titulo-grafica">Tiempos promedio de atención sin TP</a>
					</div>
					<div id="grafica7" class="caja-grafica"></div>
					<div>
						<a style="background-color: #dbce14">En muelle</a>
						<a style="background-color: #b2a700">Descargue</a>
					</div>
				</div>
			</div>-->
			<!-- GRÁFICA 13: PROMEDIO DE TIEMPO CARGUE Y EN ANDÉN CON TP -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG13" name="inicioG13" value="<?php $dias = -30; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica13()">
						<input type="date" id="finG13" name="finG13" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica13()">
						<select id="canalG13" name="canalG13" onChange="verGrafica13()" style="max-width: 140px">
							<option value="">Canal</option>
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
					<div>
						<a href="Javascript:void()" onClick="verGrafica13()" class="titulo-grafica">Tiempos de atención (min)</a>
					</div>
					<div id="grafica13" class="caja-grafica"></div>
					<div>
						<a style="background-color: #dbce14">En muelle</a>
						<a style="background-color: #b2a700">Cargue</a>
					</div>
				</div>
			</div>	
			<!-- GRÁFICA 14: PROMEDIO DE TIEMPO CARGUE Y EN ANDÉN SIN TP -->
			<!--<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG14" name="inicioG14" value="<?php $dias = -30; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica14()">
						<input type="date" id="finG14" name="finG14" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica14()">
						<select id="canalG14" name="canalG14" onChange="verGrafica14()" style="max-width: 140px">
							<option value="">Canal</option>
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
					<div>
						<a href="Javascript:void()" onClick="verGrafica14()" class="titulo-grafica">Tiempos promedio de atención sin TP</a>
					</div>
					<div id="grafica14" class="caja-grafica"></div>
					<div>
						<a style="background-color: #dbce14">En muelle</a>
						<a style="background-color: #b2a700">Cargue</a>
					</div>
				</div>
			</div>-->
			<!-- GRÁFICA 12: ESTIBAS DES/CARGADAS -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG12" name="inicioG12" value="<?php $dias = -30; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica12()">
						<input type="date" id="finG12" name="finG12" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica12()">
					</div>
				</div>
				<div class="caja-graficas-graficas caja-scroll">
					<div>
						<a href="Javascript:void()" onClick="verGrafica12()" class="titulo-grafica">Estibas</a>
					</div>
					<div id="grafica12" class="caja-grafica"></div>
					<div>
						<!--<a style="background-color: #b7b7b7">Descargue</a>-->
						<a style="background-color: #666">Cargue</a>
					</div>
				</div>
			</div>
			<!-- GRÁFICA 10: TONELADAS DES/CARGADAS -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG10" name="inicioG10" value="<?php $dias = -30; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica10()">
						<input type="date" id="finG10" name="finG10" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica10()">
					</div>
				</div>
				<div class="caja-graficas-graficas caja-scroll">
					<div>
						<a href="Javascript:void()" onClick="verGrafica10()" class="titulo-grafica">Kilogramos</a>
					</div>
					<div id="grafica10" class="caja-grafica"></div>
					<div>
						<!--<a style="background-color: #e263a2">Descargue</a>-->
						<a style="background-color: #741b47">Cargue</a>
					</div>
				</div>
			</div>
			<!-- GRÁFICA 11: PRODUCTIVIDAD DE DES/CARGUE -->
			<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG11" name="inicioG11" value="<?php $dias = -30; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica11()">
						<input type="date" id="finG11" name="finG11" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica11()">
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
					</div>
				</div>
				<div class="caja-graficas-graficas caja-scroll">
					<div>
						<a href="Javascript:void()" onClick="verGrafica11()" class="titulo-grafica">Productividad (ton/oper/hora)</a>
					</div>
					<div id="grafica11" class="caja-grafica"></div>
					<div>
						<!--<a style="background-color: #68d837">Descargue</a>-->
						<a style="background-color: #50a32c">Cargue</a>
					</div>
				</div>
			</div>	
			<!-- GRÁFICA 8: TIEMPOS PERDIDOS -->
			<!--<div class="caja-graficas">
				<div class="caja-tabla-filtro">
					<div>
						<input type="date" id="inicioG8" name="inicioG8" value="<?php $dias = -30; echo date("Y-m-d", strtotime("$dias days")); ?>" onChange="verGrafica8()">
						<input type="date" id="finG8" name="finG8" value="<?php echo date("Y-m-d"); ?>" onChange="verGrafica8()">
						<select id="procesoG8" name="procesoG8" onChange="verGrafica8()" style="max-width: 140px">
							<option value="">Proceso responsable</option>
							<option>Contactamos</option>
							<option>Cliente</option>
							<option>Otros</option>
						</select>
					</div>
				</div>
				<div class="caja-graficas-graficas caja-scroll">
					<a href="Javascript:void()" onClick="verGrafica8()" class="titulo-grafica">Tiempo perdido por Proceso Responsable</a>
					<div id="grafica8" class="caja-grafica"></div>
					<a style="background-color: #1155cc">Minutos</a>
				</div>
			</div>-->
		</div>
	</div>
	<div class="caja-form-footer">

	</div>
</div>

</script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<script>
	
function verGrafica1(){
		
	document.getElementById("grafica1").innerHTML = "";
	
	var inicio = document.getElementById("inicioG1").value;
	var fin = document.getElementById("finG1").value;

	$.ajax({
		url: "graphics/grafica_procesos1.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin}
	})
	.done(function(info){

		var datos = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var cantidad = info[i].cantidad;

			datos.push({
				x: String(registro),
				y: cantidad
			});
		}

		var config = {
					   data: datos,
					   xkey: 'x',
					   ykeys: ['y'],
					   labels: ['# Vehículos'],
					   parseTime: false,
					   fillOpacity: 0.6,
					   hideHover: 'auto',
					   behaveLikeLine: true,
					   resize: true,
					   pointFillColors:['#ffffff'],
					   pointStrokeColors: ['black'],
					   lineColors:['#099EAB']						
					 };

		config.element = 'grafica1';
		Morris.Area(config);

	})		
}
	
function verGrafica2(){
		
	document.getElementById("grafica2").innerHTML = "";
	
	var inicio = document.getElementById("inicioG2").value;
	var fin = document.getElementById("finG2").value;

	$.ajax({
		url: "graphics/grafica_procesos2.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin}
	})
	.done(function(info){

		var datos = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var cargues = info[i].cargues;
			var descargues = info[i].descargues;

			datos.push({
				x: String(registro),
				a: descargues,
				b: cargues
			});
		}

		var config = {
					   data: datos,
					   xkey: 'x',
				       ykeys: ['a', 'b'],
				       labels: ['Descargues', 'Cargues'],
					   parseTime: false,
					   fillOpacity: 0.6,
					   hideHover: 'auto',
					   behaveLikeLine: true,
					   resize: true,
					   pointFillColors:['#ffffff'],
					   pointStrokeColors: ['black'],
					   lineColors:['#da878e','#AA3C45']						
					 };

		config.element = 'grafica2';
		Morris.Line(config);

	})		
}

function verGrafica3(){
		
	document.getElementById("grafica3").innerHTML = "";
	
	var inicio = document.getElementById("inicioG3").value;
	var fin = document.getElementById("finG3").value;
	var turno = document.getElementById("turnoG3").value;
	var canal = document.getElementById("canalG3").value;

	$.ajax({
		url: "graphics/grafica_procesos3.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin, turno: turno, canal: canal}
	})
	.done(function(info){

		var datos = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var atenciones = info[i].atenciones;

			datos.push({
				x: String(registro),
				y: atenciones
			});
		}

		var config = {
					   data: datos,
					   xkey: 'x',
				       ykeys: ['y'],
				       labels: ['# Vehículos'],
					   parseTime: false,
					   fillOpacity: 0.6,
					   hideHover: 'auto',
					   behaveLikeLine: true,
					   resize: true,
					   pointFillColors:['#ffffff'],
					   pointStrokeColors: ['black'],
					   lineColors:['#E69138']						
					 };

		config.element = 'grafica3';
		Morris.Area(config);

	})		
}

function verGrafica4(){
		
	document.getElementById("grafica4").innerHTML = "";
	
	var inicio = document.getElementById("inicioG4").value;
	var fin = document.getElementById("finG4").value;
	var vehiculo = document.getElementById("vehiculoG4").value;

	$.ajax({
		url: "graphics/grafica_procesos4.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin, vehiculo: vehiculo}
	})
	.done(function(info){

		var datos = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var atenciones = info[i].atenciones;

			datos.push({
				x: String(registro),
				y: atenciones
			});
		}

		var config = {
					   data: datos,
					   xkey: 'x',
				       ykeys: ['y'],
				       labels: ['# Vehículos'],
					   parseTime: false,
					   fillOpacity: 0.6,
					   hideHover: 'auto',
					   behaveLikeLine: true,
					   resize: true,
					   pointFillColors:['#ffffff'],
					   pointStrokeColors: ['black'],
					   lineColors:['#654587']						
					 };

		config.element = 'grafica4';
		Morris.Area(config);

	})		
}

function verGrafica5(){
		
	document.getElementById("grafica5").innerHTML = "";
	
	var inicio = document.getElementById("inicioG5").value;
	var fin = document.getElementById("finG5").value;
	var lider = document.getElementById("liderG5").value;

	$.ajax({
		url: "graphics/grafica_procesos5.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin, lider: lider}
	})
	.done(function(info){

		var datos = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var atenciones = info[i].atenciones;

			datos.push({
				x: String(registro),
				y: atenciones
			});
		}

		var config = {
					   data: datos,
					   xkey: 'x',
				       ykeys: ['y'],
				       labels: ['# Vehículos'],
					   parseTime: false,
					   fillOpacity: 0.6,
					   hideHover: 'auto',
					   behaveLikeLine: true,
					   resize: true,
					   pointFillColors:['#ffffff'],
					   pointStrokeColors: ['black'],
					   lineColors:['#00C968']						
					 };

		config.element = 'grafica5';
		Morris.Area(config);

	})		
}

function verGrafica6(){
		
	document.getElementById("grafica6").innerHTML = "";
	
	var inicio = document.getElementById("inicioG6").value;
	var fin = document.getElementById("finG6").value;
	var canal = document.getElementById("canalG6").value;

	$.ajax({
		url: "graphics/grafica_procesos6.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin, canal: canal}
	})
	.done(function(info){

		var datos = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var des_cargue = info[i].des_cargue;
			var enanden = info[i].enanden;

			datos.push({
				x: String(registro),
				a: enanden,
				b: des_cargue 
			});
		}

		var config = {
					   data: datos,
					   xkey: 'x',
				       ykeys: ['a', 'b'],
				       labels: ['En muelle', 'Descargue'],
					   parseTime: false,
					   fillOpacity: 0.6,
					   hideHover: 'auto',
					   behaveLikeLine: true,
					   resize: true,
					   pointFillColors:['#ffffff'],
					   pointStrokeColors: ['black'],
					   lineColors:['#dbce14','#b2a700']						
					 };

		config.element = 'grafica6';
		Morris.Area(config);

	})		
}

function verGrafica7(){
		
	document.getElementById("grafica7").innerHTML = "";
	
	var inicio = document.getElementById("inicioG7").value;
	var fin = document.getElementById("finG7").value;
	var canal = document.getElementById("canalG7").value;

	$.ajax({
		url: "graphics/grafica_procesos7.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin, canal: canal}
	})
	.done(function(info){

		var datos = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var des_cargue = info[i].des_cargue;
			var enanden = info[i].enanden;

			datos.push({
				x: String(registro),
				a: enanden,
				b: des_cargue 
			});
		}

		var config = {
					   data: datos,
					   xkey: 'x',
				       ykeys: ['a', 'b'],
				       labels: ['En muelle', 'Descargue'],
					   parseTime: false,
					   fillOpacity: 0.6,
					   hideHover: 'auto',
					   behaveLikeLine: true,
					   resize: true,
					   pointFillColors:['#ffffff'],
					   pointStrokeColors: ['black'],
					   lineColors:['#dbce14','#b2a700']						
					 };

		config.element = 'grafica7';
		Morris.Area(config);

	})		
}
	
function verGrafica8(){
		
	document.getElementById("grafica8").innerHTML = "";
	
	var inicio = document.getElementById("inicioG8").value;
	var fin = document.getElementById("finG8").value;
	var proceso = document.getElementById("procesoG8").value;

	$.ajax({
		url: "graphics/grafica_procesos8.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin, proceso: proceso}
	})
	.done(function(info){

		var datos = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var t1 = info[i].t1;

			datos.push({
				x: String(registro),
				a: t1
			});
		}

		var config = {
					   data: datos,
					   xkey: 'x',
				       ykeys: ['a'],
				       labels: ['Minutos'],
					   parseTime: false,
					   fillOpacity: 0.6,
					   hideHover: 'auto',
					   behaveLikeLine: true,
					   resize: true,
					   pointFillColors:['#ffffff'],
					   pointStrokeColors: ['black'],
					   lineColors:['#1155cc']						
					 };

		config.element = 'grafica8';
		Morris.Area(config);

	})		
}

function verGrafica9(){
		
	document.getElementById("grafica9").innerHTML = "";
	
	var inicio = document.getElementById("inicioG9").value;
	var fin = document.getElementById("finG9").value;
	var canal = document.getElementById("canalG9").value;

	$.ajax({
		url: "graphics/grafica_procesos9.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin, canal: canal}
	})
	.done(function(info){

		var datos = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var atenciones = info[i].atenciones;

			datos.push({
				x: String(registro),
				y: atenciones
			});
		}

		var config = {
					   data: datos,
					   xkey: 'x',
				       ykeys: ['y'],
				       labels: ['# Vehículos'],
					   parseTime: false,
					   fillOpacity: 0.6,
					   hideHover: 'auto',
					   behaveLikeLine: true,
					   resize: true,
					   pointFillColors:['#ffffff'],
					   pointStrokeColors: ['black'],
					   lineColors:['#134f5c']						
					 };

		config.element = 'grafica9';
		Morris.Area(config);

	})		
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

		var datos = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var cargues = info[i].cargues;
			var descargues = info[i].descargues;

			datos.push({
				x: String(registro),
				//a: descargues,
				b: cargues
			});
		}

		var config = {
					   data: datos,
					   xkey: 'x',
				       ykeys: ['b'], //'a', 
				       labels: ['Cargue'], //'Descargue', 
					   parseTime: false,
					   fillOpacity: 0.6,
					   hideHover: 'auto',
					   behaveLikeLine: true,
					   resize: true,
					   pointFillColors:['#ffffff'],
					   pointStrokeColors: ['black'],
					   lineColors:['#741b47'] //'#e263a2',			
					 };

		config.element = 'grafica10';
		Morris.Line(config);

	})		
}

function verGrafica11(){
		
	document.getElementById("grafica11").innerHTML = "";
	
	var inicio = document.getElementById("inicioG11").value;
	var fin = document.getElementById("finG11").value;
	var turno = document.getElementById("turnoG11").value;

	$.ajax({
		url: "graphics/grafica_procesos11.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin, turno: turno}
	})
	.done(function(info){

		var datos = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var productividad_cargue = info[i].productividad_cargue;
			var productividad_descargue = info[i].productividad_descargue;

			datos.push({
				x: String(registro),
				//a: productividad_descargue,
				b: productividad_cargue
			});
		}

		var config = {
					   data: datos,
					   xkey: 'x',
				       ykeys: ['b'], //'a', 
				       labels: ['Cargue'], //'Descargue', 
					   parseTime: false,
					   fillOpacity: 0.6,
					   hideHover: 'auto',
					   behaveLikeLine: true,
					   resize: true,
					   pointFillColors:['#ffffff'],
					   pointStrokeColors: ['black'],
					   lineColors:['#50a32c'] //'#68d837',			
					 };

		config.element = 'grafica11';
		Morris.Line(config);

	})		
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

		var datos = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var cargues = info[i].cargues;
			var descargues = info[i].descargues;

			datos.push({
				x: String(registro),
				//a: descargues,
				b: cargues
			});
		}

		var config = {
					   data: datos,
					   xkey: 'x',
				       ykeys: ['b'], //'a', 
				       labels: ['Cargue'], //'Descargue', 
					   parseTime: false,
					   fillOpacity: 0.6,
					   hideHover: 'auto',
					   behaveLikeLine: true,
					   resize: true,
					   pointFillColors:['#ffffff'],
					   pointStrokeColors: ['black'],
					   lineColors:['#666'] //'#b7b7b7',
					 };

		config.element = 'grafica12';
		Morris.Line(config);

	})		
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

		var datos = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var des_cargue = info[i].des_cargue;
			var enanden = info[i].enanden;

			datos.push({
				x: String(registro),
				a: enanden,
				b: des_cargue 
			});
		}

		var config = {
					   data: datos,
					   xkey: 'x',
				       ykeys: ['a', 'b'],
				       labels: ['En muelle', 'Cargue'],
					   parseTime: false,
					   fillOpacity: 0.6,
					   hideHover: 'auto',
					   behaveLikeLine: true,
					   resize: true,
					   pointFillColors:['#ffffff'],
					   pointStrokeColors: ['black'],
					   lineColors:['#dbce14','#b2a700']						
					 };

		config.element = 'grafica13';
		Morris.Area(config);

	})		
}

function verGrafica14(){
		
	document.getElementById("grafica14").innerHTML = "";
	
	var inicio = document.getElementById("inicioG14").value;
	var fin = document.getElementById("finG14").value;
	var canal = document.getElementById("canalG14").value;

	$.ajax({
		url: "graphics/grafica_procesos14.php",
		type: "POST",
		dataType: "JSON",
		data: {inicio: inicio, fin: fin, canal: canal}
	})
	.done(function(info){

		var datos = [];

		for(var i = 0; i < info.length; i++){

			var registro = info[i].registro;
			var des_cargue = info[i].des_cargue;
			var enanden = info[i].enanden;

			datos.push({
				x: String(registro),
				a: enanden,
				b: des_cargue 
			});
		}

		var config = {
					   data: datos,
					   xkey: 'x',
				       ykeys: ['a', 'b'],
				       labels: ['En muelle', 'Cargue'],
					   parseTime: false,
					   fillOpacity: 0.6,
					   hideHover: 'auto',
					   behaveLikeLine: true,
					   resize: true,
					   pointFillColors:['#ffffff'],
					   pointStrokeColors: ['black'],
					   lineColors:['#dbce14','#b2a700']						
					 };

		config.element = 'grafica14';
		Morris.Area(config);

	})		
}
	
verGrafica1();
//verGrafica2();
verGrafica3();
verGrafica4();
//verGrafica5();
//verGrafica6();
//verGrafica7();
//verGrafica8();	
verGrafica9();	
verGrafica10();	
verGrafica11();	
verGrafica12();	
verGrafica13();	
//verGrafica14();	
	
</script>