<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];
$url_base = $_SESSION["url_base"];

if(!isset($id) || ($tipo != "ADMINISTRADOR" && $tipo != "MULTIPAQUETES")){
	
	header("Location:" . $url_base . "login.php");
	
	die();
	
}

?>

<div>		
	<div class="caja-form-header">
		<a href="javascript:void()" onClick="seccionHide()" title="Salir"><i class="fas fa-times"></i></a>
		<h2><i class="fas fa-cog"></i>Panel de Administración</h2>
	</div>
	<div class="caja-menu-ul caja-scroll">
		<ul>
			<?php if($tipo == "ADMINISTRADOR"){ ?>
			<li id="divPS19" class="off">Canales / Negocios</li>
			<li id="divPS18" class="off">Causales</li>
			<li id="divPS17" class="off">Destinos</li>
			<li id="divPS11" class="off">Líderes</li>
			<li id="divPS13" class="off">Muelles</li>
			<li id="divPS20" class="off">Operadores logísticos</li>
			<li id="divPS16" class="off">Procedencias</li>
			<li id="divPS12" class="off">Turnos</li>
			<li id="divPS1" class="off">Usuarios</li>
			<li id="divPS14" class="off">Vehículos</li>
			<?php } ?>	
		</ul>
	</div>
	<div id="seccionPanel"></div>
</div>

<script>

//VER SUBSECCIONES EN PANEL

$(document).ready(function() {
		
    $("#divPS1").on("click", function() {
		$(".on").removeClass("on").addClass("off");
		$("#divPS1").removeClass("off").addClass("on");
		$("#seccionPanel").load("views/panel/usuarios.php"); return false;		
    });	
	$("#divPS11").on("click", function() {
		$(".on").removeClass("on").addClass("off");
		$("#divPS11").removeClass("off").addClass("on");
		$("#seccionPanel").load("views/panel/lideres.php"); return false;		
    });	
	$("#divPS12").on("click", function() {
		$(".on").removeClass("on").addClass("off");
		$("#divPS12").removeClass("off").addClass("on");
		$("#seccionPanel").load("views/panel/turnos.php"); return false;		
    });	
	$("#divPS13").on("click", function() {
		$(".on").removeClass("on").addClass("off");
		$("#divPS13").removeClass("off").addClass("on");
		$("#seccionPanel").load("views/panel/muelles.php"); return false;		
    });	
	$("#divPS14").on("click", function() {
		$(".on").removeClass("on").addClass("off");
		$("#divPS14").removeClass("off").addClass("on");
		$("#seccionPanel").load("views/panel/vehiculos.php"); return false;		
    });	
	$("#divPS16").on("click", function() {
		$(".on").removeClass("on").addClass("off");
		$("#divPS16").removeClass("off").addClass("on");
		$("#seccionPanel").load("views/panel/procedencias.php"); return false;		
    });
	$("#divPS17").on("click", function() {
		$(".on").removeClass("on").addClass("off");
		$("#divPS17").removeClass("off").addClass("on");
		$("#seccionPanel").load("views/panel/destinos.php"); return false;		
    });
	$("#divPS18").on("click", function() {
		$(".on").removeClass("on").addClass("off");
		$("#divPS18").removeClass("off").addClass("on");
		$("#seccionPanel").load("views/panel/causales.php"); return false;		
    });
	$("#divPS19").on("click", function() {
		$(".on").removeClass("on").addClass("off");
		$("#divPS19").removeClass("off").addClass("on");
		$("#seccionPanel").load("views/panel/canales.php"); return false;		
    });
	$("#divPS20").on("click", function() {
		$(".on").removeClass("on").addClass("off");
		$("#divPS20").removeClass("off").addClass("on");
		$("#seccionPanel").load("views/panel/operarios.php"); return false;		
    });
	
});

</script>