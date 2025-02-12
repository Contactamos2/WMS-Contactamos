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

include "../conexion.php";
$consulta = $_POST["consulta"];

if($consulta == ""){
	
	$sql = "SELECT f.id_auditoria, f.fecha_auditoria, r.nombre_responsable AS responsable, ag.nombre_agente AS agente, z.No_zona AS zona, f.No_transporte,
		f.placa, f.faltante, f.sobrante, f.cruce, f.averia, f.tab_121, f.tab_402, f.tab_405, f.tab_401, mat.codigo_material, mat.descripcion, 
		f.cantidad, f.valor_total, f.No_serial_contenedor, f.tipo_contenedor, f.tipo_canastilla, f.tipo_masivo, f.novedad_nutresa, 
		f.novedad_contactamos, ver.nombre_verificador AS verificador, f.observaciones, f.url_drive
		     FROM auditoria AS f, responsable AS r, zona AS z, agente AS ag,verificador 
		AS ver, materiales AS mat WHERE f.id_responsable = r.id_responsable AND f.id_zona = z.id_zona AND f.id_agente = ag.id_agente AND f.id_verificador = 
		ver.id_verificador AND f.id_material = mat.id_material";
	
} else{
	$sql = "SELECT f.id_auditoria, f.fecha_auditoria, r.nombre_responsable AS responsable, ag.nombre_agente AS agente, z.No_zona AS zona, f.No_transporte,
		f.placa, f.faltante, f.sobrante, f.cruce, f.averia, f.tab_121, f.tab_402, f.tab_405, f.tab_401, mat.codigo_material, mat.descripcion, 
		f.cantidad, f.valor_total, f.No_serial_contenedor, f.tipo_contenedor, f.tipo_canastilla, f.tipo_masivo, f.novedad_nutresa, 
		f.novedad_contactamos, ver.nombre_verificador AS verificador, f.observaciones, f.url_drive
		     FROM auditoria AS f, responsable AS r, zona AS z, agente AS ag,verificador 
		AS ver, materiales AS mat WHERE f.id_responsable = r.id_responsable AND f.id_zona = z.id_zona AND f.id_agente = ag.id_agente AND f.id_verificador = 
		ver.id_verificador AND f.id_material = mat.id_material
			AND (
				POSITION('$consulta' IN f.fecha_auditoria) OR
				POSITION('$consulta' IN r.nombre_responsable) OR
				POSITION('$consulta' IN ag.nombre_agente) OR
				POSITION('$consulta' IN z.No_zona ) OR
				POSITION('$consulta' IN f.No_transporte) OR
				POSITION('$consulta' IN f.placa) OR
				POSITION('$consulta' IN f.faltante) OR
				POSITION('$consulta' IN f.sobrante) OR
				POSITION('$consulta' IN f.cruce) OR
				POSITION('$consulta' IN f.averia) OR
				POSITION('$consulta' IN f.tab_121) OR
				POSITION('$consulta' IN f.tab_402) OR
				POSITION('$consulta' IN f.tab_405) OR
				POSITION('$consulta' IN f.tab_401) OR
				POSITION('$consulta' IN mat.codigo_material) OR
				POSITION('$consulta' IN mat.descripcion) OR
				POSITION('$consulta' IN mat.cantidad) OR
				POSITION('$consulta' IN mat.valor_total) OR
				POSITION('$consulta' IN mat.No_serial_contenedor) OR
				POSITION('$consulta' IN f.tipo_contenedor) OR
				POSITION('$consulta' IN f.tipo_canastilla) OR
				POSITION('$consulta' IN f.tipo_masivo) OR
				POSITION('$consulta' IN f.novedad_nutresa) OR
				POSITION('$consulta' IN f.novedad_contactamos) OR
				POSITION('$consulta' IN f.nombre_verificador) OR
				POSITION('$consulta' IN f.observaciones) OR
				POSITION('$consulta' IN f.url_drive)
			)";	
}

$resultado = $conexion->query($sql);

$conteo = 0;

if($resultado == true){

	while($fila = $resultado->fetch_array()){

		++$conteo;
		
		$fecha_auditoria = date("d/m/Y",strtotime($fila[1]));
		$nombre_responsable = $fila[2];
		$nombre_agente = $fila[3];
		$No_zona = $fila[4];
		$No_transporte = $fila[5];
		$placa = $fila[6];
		$faltante = $fila[7];
		$sobrante = $fila[8];
		$cruce = $fila[9];
		$averia = $fila[10];
		$tab_121 = $fila[11] == "" ? "NO APLICA" : $fila[11];
		$tab_402 = $fila[12] == "" ? "NO APLICA" : $fila[12];
		$tab_405 = $fila[13] == "" ? "NO APLICA" : $fila[13];
		$tab_401 = $fila[14] == "" ? "NO APLICA" : $fila[14];
		$codigo_material = $fila[15];
		$descripcion = $fila[16];
		$cantidad = $fila[17];
		$valor_total = $fila[18];
		$No_serial_contenedor = $fila[19];
		$tipo_contenedor = $fila[20];
		$tipo_canastilla = $fila[21];
		$tipo_masivo = $fila[22];
		$novedad_nutresa = $fila[23];
		$novedad_contactamos = $fila[24];
		$nombre_verificador = $fila[25];
		$observaciones = $fila[26];
		$url_drive = $fila[27];

		echo "<tr class='fila'>
			<td> $fecha_auditoria  </td>
			<td class='left'>$nombre_responsable </td>
			<td>$nombre_agente </td>
			<td> $No_zona </td>
			<td class='left'>$No_transporte </td>
			<td>$placa </td>
			<td>$faltante </td>
			<td>$sobrante </td>
			<td>$cruce </td>
			<td class='left'>$averia </td>
			<td class='left'>$tab_121 </td>
			<td class='left'> $tab_402 </td>
			<td>$tab_405</td>
			<td>$tab_401</td>
			<td class='right'> $codigo_material</td>
			<td>$descripcion </td>
			<td class='left'>$cantidad</td>
			<td class='left'>$valor_total</td>
			<td class='left'>$No_serial_contenedor</td>
			<td>$tipo_contenedor </td>
			<td>$tipo_canastilla </td>
			<td>$tipo_masivo </td>
			<td>$novedad_nutresa </td>
			<td>$novedad_contactamos </td>
			<td>$nombre_verificador </td>
			<td>$observaciones </td>
			<td>$url_drive </td>";
		
			if($tipo != "CLIENTE"){	
				
				echo "<td>";
					echo "<a href='Javascript:void()' data-id='$fila[0]' onClick='editar(this)' class='edit'><i class='fas fa-pen'></i>Editar</a>";
					echo "<a href='Javascript:void()' data-id='$fila[0]' data-elemento='$fecha_auditoria: $fila[7] en B$fila[5] por $fila[3]' data-tabla='procesos' onClick='eliminar(this)' class='delete'><i class='fas fa-trash'></i>Eliminar</a>";
				echo "</td>";
				
			} else{
				
				echo "<td></td>";
				
			}
		echo "</tr>";
	}	

	$resultado->free();

} else{
	echo "Error al cargar procesos: " . $conexion->error;
}
return $resultado;
$conexion->close();



	










?>


