<!DOCTYPE html>
<html>

<head>
	<title>Leer tabla de MySQL con PHP</title>
	<meta charset="utf-8">
</head>

<body>
	<?php
	$host = "localhost";
	$usuario = "root";
	$clave = "root"; //en XAMPP la clave es vacía
	$db = "escuela";
	$puerto = "3308"; //en XAMPP no se necesita el puerto
	//
	$conn = mysqli_connect($host, $usuario, $clave, $db, $puerto)
		or die("Error al conectar la base de datos");
	$q = "SELECT * FROM alumnos";
	$r = mysqli_query($conn, $q);
	print "<table border='1'>";
	print "<tr>";
	print "<th>Num.</th>";
	print "<th>Nombres</th>";
	print "<th>Apellidos</th>";
	print "<th>Fecha de Nacimiento</th>";
	print "<th>Promedio</th>";
	print "<th>Género</th>";
	print "</tr>";
	while ($data = mysqli_fetch_assoc($r)) {
		print "<tr>";
		print "<td>" . $data["id"] . "</td>";
		print "<td>" . $data["nombres"] . "</td>";
		print "<td>" . $data["apellidos"] . "</td>";
		print "<td>" . $data["fechaNacimiento"] . "</td>";
		print "<td>" . $data["promedio"] . "</td>";
		print "<td>" . $data["genero"] . "</td>";
		print "</tr>";
	}
	print "</table>";
	?>
</body>

</html>