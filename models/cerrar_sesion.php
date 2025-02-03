<?php

session_start();

$url_base = $_SESSION["url_base"];

session_destroy();

header("Location:" . $url_base . "login.php");
//header("Location:http://vefers.000webhostapp.com/wms/login.php");
//header("Location:http://localhost/wms/login");
//header("Location:https://9697db89.ngrok.io/wms/login");

?>

