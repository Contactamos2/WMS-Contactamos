<?php

// class Database {
//     public $conexion;

//     public function __construct() {
//         $this->conexion = new mysqli("localhost", "root", "", "wms_comercialnutresa");
//         $this->conexion->set_charset("utf8");

//         if ($this->conexion->connect_error) {
//             echo "Error en la conexión: " . $this->conexion->connect_error;
//             die();
//         }
//     }

// }
$servidor = "localhost";
$usuario = "root";
$clave = "";
$bd = "wms_comercialnutresabogota";

$conexion = new mysqli($servidor, $usuario, $clave, $bd);
$conexion->set_charset("utf8");

if ($conexion->connect_error) {
	
    echo "Error en la conexión: " . $conexion->connect_error;
	
	die();
}
// adminportal1*

?>