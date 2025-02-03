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

<nav id="nav1" class="caja-scroll capa2">
	<div>
		<a href="Javascript:void()" onClick="cambioNav(2)">
			<img src="public/img/logo.png" alt="Logo" title="Contactamos">
		</a>	
		<p class="p-wms">WMS</p>
	</div>
	<hr>
	<div>
		<ul>
				<a class="aUSU" href="Javascript:void()" title="Usuario"><li><i class="fas fa-user-circle"></i></li></a>
			<?php if($tipo != "" && $tipo != "CLIENTE" && $tipo != "TV"){ ?>
				<!--<a class="aAYU" href="Javascript:void()" title="Ayuda"><li><i class="fas fa-question-circle"></i></li></a>-->
			<?php } ?>
				<a class="aCER" href="Javascript:void()" title="Cerrar sesión"><li><i class="fas fa-power-off"></i></li></a>
			<br>
			<?php if($tipo == "ADMINISTRADOR" || $tipo == "PROCESO" || $tipo == "CLIENTE"){ ?>
				<a class="aFLE" href="Javascript:void()" title="Procesos"><li><i class="fas fa-truck"></i></li></a>
			<?php } ?>			
			<?php if($tipo == "ADMINISTRADOR" || $tipo == "PROCESO" || $tipo == "CLIENTE"){ ?>
				<a class="aADI" href="Javascript:void()" title="Auditoria"><li><i class="fas fa-users"></i></li></a>
			<?php } ?>
			<?php if($tipo == "ADMINISTRADOR" || $tipo == "PROCESO" || $tipo == "CLIENTE"){ ?>
				<!--<a class="aESTprocesos" href="Javascript:void()" title="Estadísticas"><li><i class="fas fa-chart-line"></i></li></a>-->
				<a class="aESTprocesosBeta" href="Javascript:void()" title="Estadísticas"><li><i class="fas fa-chart-line"></i></li></a>
				<a class="aINF" href="Javascript:void()" title="Informes"><li><i class="fas fa-file-alt"></i></li></a>
			<?php } ?>			
			<?php if($tipo == "ADMINISTRADOR"){ ?>
				<a class="aRANprocesos" href="Javascript:void()" title="Ranking"><li><i class="fas fa-medal"></i></li></a>
			<?php } ?>
			<?php if($tipo == "ADMINISTRADOR" || $tipo == "CLIENTE" || $tipo == "TV"){ ?>
				<a class="aPANprocesos" href="Javascript:void()" title="Pantalla"><li><i class="fas fa-desktop"></i></li></a>
			<?php } ?>		
			<br>
			<?php if($tipo == "ADMINISTRADOR"){ ?>
				<a class="aPAN" href="Javascript:void()" title="Panel"><li><i class="fas fa-cog"></i></li></a>
			<?php } ?>
		</ul>
	</div>
</nav>

<nav id="nav2" class="caja-scroll capa2">
	<div>
		<a href="Javascript:void()" onClick="cambioNav(1)">
			<img src="public/img/logo.png" alt="Logo" title="Contactamos">
		</a>		
		<p class="p-wms">Warehouse Management System</p>
	</div>
	<hr>
	<div>
		<ul>
			<label>CUENTA</label>
				<a class="aUSU" href="Javascript:void()"><li><i class="fas fa-user-circle"></i>Usuario</li></a>
			<?php if($tipo != "" && $tipo != "CLIENTE" && $tipo != "TV" && $tipo != "DESPACHOS" && $tipo != "SEDIAL"){ ?>
				<!--<a class="aAYU" href="Javascript:void()"><li><i class="fas fa-question-circle"></i>Ayuda</li></a>-->
			<?php } ?>
				<a class="aCER" href="Javascript:void()"><li><i class="fas fa-power-off"></i>Cerrar sesión</li></a>
			<br>
			<?php if($tipo == "ADMINISTRADOR" || $tipo == "PROCESO" || $tipo == "CLIENTE" || $tipo == "TV"){ ?>
			<label>SISTEMA DE CONTROL</label>
			<?php } ?>
			<?php if($tipo == "ADMINISTRADOR" || $tipo == "PROCESO" || $tipo == "CLIENTE"){ ?>
				<a class="aFLE" href="Javascript:void()"><li><i class="fas fa-truck"></i>Procesos</li></a>
			<?php } ?>
			<?php if($tipo == "ADMINISTRADOR" || $tipo == "PROCESO" || $tipo == "CLIENTE"){ ?>
				<a class="aADI" href="Javascript:void()"><li><i class="fas fa-users"></i>Auditoria</li></a>
			<?php } ?>
			<?php if($tipo == "ADMINISTRADOR" || $tipo == "PROCESO" || $tipo == "CLIENTE"){ ?>
				<!--<a class="aESTprocesos" href="Javascript:void()"><li><i class="fas fa-chart-line"></i>Estadísticas</li></a>-->
				<a class="aESTprocesosBeta" href="Javascript:void()"><li><i class="fas fa-chart-line"></i>Estadísticas</li></a>
				<a class="aINF" href="Javascript:void()"><li><i class="fas fa-file-alt"></i>Informes</li></a>
			<?php } ?>
			<?php if($tipo == "ADMINISTRADOR"){ ?>
				<a class="aRANprocesos" href="Javascript:void()"><li><i class="fas fa-medal"></i>Ranking</li></a>
			<?php } ?>
			<?php if($tipo == "ADMINISTRADOR" || $tipo == "CLIENTE" || $tipo == "TV"){ ?>
				<a class="aPANprocesos" href="Javascript:void()"><li><i class="fas fa-desktop"></i>Pantalla</li></a>
			<?php } ?>
			<br>
			<?php if($tipo == "ADMINISTRADOR"){ ?>
			<label>ADMINISTRACIÓN</label>
				<a class="aPAN" href="Javascript:void()"><li><i class="fas fa-cog"></i>Panel</li></a>
			<?php } ?>
		</ul>
	</div>
	<hr>
	<div>
		<p>&copy; 2019 - <?php echo date("o"); ?> CONTACTAMOS</p>
		<p>Todos los derechos reservados.</p>	
	</div>
</nav>
