<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = $_SESSION["url_base"];

if(!isset($id)){
	
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

?> 

<div>		
	<div class="caja-form-header">
		<a href="javascript:void()" onClick="seccionHide()" title="Salir"><i class="fas fa-times"></i></a>
		<h2><i class="fas fa-file-alt"></i>Informes</h2>
	</div>
	<div class="caja-form-section fondo-tabla">	
		<div class="caja-fila-informes">
			<?php if($tipo == "ADMINISTRADOR" || $tipo == "BÁSICO" || $tipo == "PROCESO" || $tipo == "CLIENTE"){ ?>	
			<div class="informe-gris">
				<img src="public/img/fleteos.png" alt="procesos">
				<p>HISTORIAL DE PROCESOS<br>					
				<input type="date" id="inicioF1" onchange="criteriosF1()">
				<input type="date" id="finF1" onchange="criteriosF1()">
				<select id="turnoF1" onchange="criteriosF1()">
					<option value="">Turno</option>
					<?php

						include "../conexion.php";

						$sql = "SELECT * 
								FROM turnos
								WHERE sw=1";
						$resultado = $conexion->query($sql);

						if($resultado == true){

							while($fila = $resultado->fetch_assoc()){
								echo "<option>" . $fila["turno"] . "</option>";
							}	

							$resultado->free();

						} else{
							echo "Error al agregar turnos: " . $conexion->error;
						}

						$conexion->close();

					?>
				</select>
				</p>
				<p>
					<a id="xlsF1" href="" target="_blank">.xls</a>
					<a id="csvF1" href="" target="_blank">.csv</a>
				</p>
			</div>
			<div class="informe-gris">
				<img src="public/img/informe.png" alt="gerencial">
				<p>INFORME GERENCIAL<br>					
				<input type="date" id="inicioF2" onchange="criteriosF2()">
				<input type="date" id="finF2" onchange="criteriosF2()">
				<select id="turnoF2" onchange="criteriosF2()">
					<option value="">Turno</option>
					<?php

						include "../conexion.php";

						$sql = "SELECT * 
								FROM turnos
								WHERE sw=1";
						$resultado = $conexion->query($sql);

						if($resultado == true){

							while($fila = $resultado->fetch_assoc()){
								echo "<option>" . $fila["turno"] . "</option>";
							}	

							$resultado->free();

						} else{
							echo "Error al agregar turnos: " . $conexion->error;
						}

						$conexion->close();

					?>
				</select>
				</p>
				<p>
					<a id="xlsF2" href="" target="_blank">.xls</a>
					<!--<a id="pdfF2" href="javascript:void()" onClick="pdfF2()">.pdf</a>-->
				</p>
			</div>
			<div class="informe-gris">
				<img src="public/img/tiempo.png" alt="tiempos">
				<p>TIEMPOS PERDIDOS<br>					
				<input type="date" id="inicioF3" onchange="criteriosF3()">
				<input type="date" id="finF3" onchange="criteriosF3()">
				<select id="turnoF3" onchange="criteriosF3()">
					<option value="">Turno</option>
					<?php

						include "../conexion.php";

						$sql = "SELECT * 
								FROM turnos
								WHERE sw=1";
						$resultado = $conexion->query($sql);

						if($resultado == true){

							while($fila = $resultado->fetch_assoc()){
								echo "<option>" . $fila["turno"] . "</option>";
							}	

							$resultado->free();

						} else{
							echo "Error al agregar turnos: " . $conexion->error;
						}

						$conexion->close();

					?>
				</select>
				</p>
				<p>
					<a id="xlsF3" href="" target="_blank">.xls</a>
					<a id="csvF3" href="" target="_blank">.csv</a>
				</p>
			</div>
			<?php } ?>
		</div>		
	</div>

	<script>

		//PROCESOS

		function criteriosF1(){
		
			var turno = document.getElementById("turnoF1").value;
			var inicio = document.getElementById("inicioF1").value;
			var fin = document.getElementById("finF1").value;
			var url = "procesos.php?inicio=" + inicio + "&fin=" + fin + "&turno=" + turno;

			document.getElementById("xlsF1").href = "reports/xls/" + url;
			document.getElementById("csvF1").href = "reports/csv/" + url;

		}

		criteriosF1();

		function criteriosF2(){
		
			var turno = document.getElementById("turnoF2").value;
			var inicio = document.getElementById("inicioF2").value;
			var fin = document.getElementById("finF2").value;
			var url = "informe_gerencial.php?inicio=" + inicio + "&fin=" + fin + "&turno=" + turno;

			document.getElementById("xlsF2").href = "reports/xls/" + url;
			//document.getElementById("csvF2").href = "reports/csv/" + url;

		}
		
		criteriosF2();

		function criteriosF3(){
		
			var turno = document.getElementById("turnoF3").value;
			var inicio = document.getElementById("inicioF3").value;
			var fin = document.getElementById("finF3").value;
			var url = "tiempos_perdidos.php?inicio=" + inicio + "&fin=" + fin + "&turno=" + turno;

			document.getElementById("xlsF3").href = "reports/xls/" + url;
			document.getElementById("csvF3").href = "reports/csv/" + url;

		}
		
		criteriosF3();

		function pdfF2(){

			var turno = document.getElementById("turnoF2").value;
			var inicio = document.getElementById("inicioF2").value;
			var fin = document.getElementById("finF2").value;

			$.ajax({
				url: "reports/pdf/informe_gerencial.php",
				type: "POST",
				dataType: "HTML",
				data: {inicio: inicio, fin: fin, turno: turno}
			})
			.done(function(tabla){

				var mywindow = window.open("", "new div", "height=400,width=700");

				mywindow.document.write("<html>");
				mywindow.document.write("<head><title>Informe Gerencial</title></head>");
			    mywindow.document.write("<body style='font-family:arial'>");	
			    mywindow.document.write(tabla);
			    mywindow.document.write("</body>");
			    mywindow.document.write("</html>");
			    mywindow.document.close();
			    mywindow.focus();

				//setTimeout(function(){mywindow.print();},1000);

			});

		}

	</script>
</div>