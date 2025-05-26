<?php 
include "conn.php";
$nombre = $_POST['nombre'];
$imagen = addslashes(file_get_contents($_FILES['imagen']["tmp_name"]));

$sql = "INSERT INTO imagenes(nombre,imagen) VALUES('$nombre','$imagen')";

if (mysqli_query($conn,$sql)) {
	print "Se insertó correctamente";
} else {
	print "ERROR: No se insertó correctamente";
}

?>