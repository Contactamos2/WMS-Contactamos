<?php

session_start();
error_reporting(0);

$id = $_SESSION["id"];
$url_base = $_SESSION["url_base"];

if(!isset($id)){
	
	hader("Location:" . $url_base . "login.php");
	
	die();
	
}

?>

<header class="capa2">		
	
</header>