<?php  
$host = "localhost";
$usuario = "root";
$clave = "root";
$db = "quiz";
$puerto = "3308";
//
$conn = mysqli_connect($host, $usuario, $clave, $db, $puerto) or die("Error al conectar la base de datos");
?>