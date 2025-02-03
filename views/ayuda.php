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
		<h2><i class="fas fa-question-circle"></i>Ayuda</h2>
	</div>
	<div class="caja-form-section">
		<div class="caja-fila-textos caja-video">
			<h3>¿Qué es WMS?</h3>
			<p>Warehouse Management System o Sistema de Gestión de Bodega. Un WMS es una aplicación de software que da soporte a las operaciones diarias de un almacén. Los programas WMS permiten la gestión centralizada de tareas, como el seguimiento de los niveles de inventario y la ubicación de existencias.</p>
			<p>Algunos de sus beneficios son:
			<ul>
				<li><i class='fas fa-check-square'></i>Mejora los niveles de servicio.</li>
				<li><i class='fas fa-check-square'></i>Mejora la exactitud del control de inventarios.</li>
				<li><i class='fas fa-check-square'></i>Utiliza de forma más eficiente cada espacio.</li>
				<li><i class='fas fa-check-square'></i>Ayuda a darle el mejor uso a cada equipo de trabajo.</li>
				<li><i class='fas fa-check-square'></i>Logra eficacia en la mano de obra.</li>
				<li><i class='fas fa-check-square'></i>Tiene un acceso apropiado a las mercancías, además de protegerlas.</li>
				<li><i class='fas fa-check-square'></i>Disminuye considerablemente los errores en cualquier fase del proceso de trabajo.</li>
				<li><i class='fas fa-check-square'></i>Permite una toma de decisiones ágil y con fundamentos.</li>
				<li><i class='fas fa-check-square'></i>Evita obsolescencias.</li>
				<li><i class='fas fa-check-square'></i>Incrementa la productividad.</li>
				<li><i class='fas fa-check-square'></i>Maximiza la capacidad de almacenamiento.</li>
			</ul>
			</p>
		</div>
		<div class="caja-fila-textos caja-video">
			<h3>Funcionamiento por sección</h3>
			<div class="caja-video-video">
				<video controls>
				  <source src="https://wms.contactamos.co/public/video/videousuario.mp4" type="video/mp4">
				  Your browser does not support HTML5 video.
				</video>
				<p style="text-align: center"><b>Usuario</b>: Texto...</p>
			</div>
			<div class="caja-video-video">
				<video controls>
				  <source src="https://wms.contactamos.co/public/video/videoayuda.mp4" type="video/mp4">
				  Your browser does not support HTML5 video.
				</video>
				<p style="text-align: center"><b>Ayuda</b>: Texto...</p>
			</div>
			<div class="caja-video-video">
				<video controls>
				  <source src="https://wms.contactamos.co/public/video/videologout.mp4" type="video/mp4">
				  Your browser does not support HTML5 video.
				</video>
				<p style="text-align: center"><b>Cerrar sesión</b>: Texto...</p>
			</div>
			<div class="caja-video-video">
				<video controls>
				  <source src="https://wms.contactamos.co/public/video/videoinventario.mp4" type="video/mp4">
				  Your browser does not support HTML5 video.
				</video>
				<p style="text-align: center"><b>Inventario</b>: Texto...</p>
			</div>
			<div class="caja-video-video">
				<video controls>
				  <source src="https://wms.contactamos.co/public/video/videoequivalencia.mp4" type="video/mp4">
				  Your browser does not support HTML5 video.
				</video>
				<p style="text-align: center"><b>Equivalencia</b>: Texto...</p>
			</div>
			<div class="caja-video-video">
				<video controls>
				  <source src="https://wms.contactamos.co/public/video/videoentradas.mp4" type="video/mp4">
				  Your browser does not support HTML5 video.
				</video>
				<p style="text-align: center"><b>Entradas</b>: Texto...</p>
			</div>
			<div class="caja-video-video">
				<video controls>
				  <source src="https://wms.contactamos.co/public/video/videosalidas.mp4" type="video/mp4">
				  Your browser does not support HTML5 video.
				</video>
				<p style="text-align: center"><b>Salidas</b>: Texto...</p>
			</div>
			<div class="caja-video-video">
				<video controls>
				  <source src="https://wms.contactamos.co/public/video/videomodulos.mp4" type="video/mp4">
				  Your browser does not support HTML5 video.
				</video>
				<p style="text-align: center"><b>Módulos</b>: Texto...</p>
			</div>
			<div class="caja-video-video">
				<video controls>
				  <source src="https://wms.contactamos.co/public/video/videoobsolescencia.mp4" type="video/mp4">
				  Your browser does not support HTML5 video.
				</video>
				<p style="text-align: center"><b>Obsolescencia</b>: Texto...</p>
			</div>
			<div class="caja-video-video">
				<video controls>
				  <source src="https://wms.contactamos.co/public/video/videoinformes.mp4" type="video/mp4">
				  Your browser does not support HTML5 video.
				</video>
				<p style="text-align: center"><b>Informes</b>: Texto...</p>
			</div>
			<div class="caja-video-video">
				<video controls>
				  <source src="https://wms.contactamos.co/public/video/videoefleteo.mp4" type="video/mp4">
				  Your browser does not support HTML5 video.
				</video>
				<p style="text-align: center"><b>Fleteo</b>: Texto...</p>
			</div>
			<div class="caja-video-video">
				<video controls>
				  <source src="https://wms.contactamos.co/public/video/videoestadisticas.mp4" type="video/mp4">
				  Your browser does not support HTML5 video.
				</video>
				<p style="text-align: center"><b>Estadísticas</b>: Texto...</p>
			</div>
		</div>
		<div class="caja-fila-textos caja-video">
			<h3>Preguntas frecuentes</h3>
			<p>¿?</p>
			<p>¿?</p>
			<p>¿?</p>
			<p>¿?</p>
			<p>¿?</p>
			<p>¿?</p>
		</div>		
	</div>
	<div class="caja-form-footer"></div>
</div>