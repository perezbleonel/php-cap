<!DOCTYPE html>
<html>
<head>
	<title>Paginar contenido de una tabla</title>
	<meta charset="utf-8">
	<style>
		.activo{
			background-color: orange;
		}
	</style>
	<script>
		function cambiaPagina(p){
			window.open("paginacionInicioFin.php?p="+p,"_self");
		}
	</script>
</head>
<body>
<?php  
$host = "localhost";
$usuario = "root";
$clave = "root";
$db = "escuela";
$puerto = "3308";
$conn = mysqli_connect($host, $usuario, $clave, $db, $puerto) 
or die("Error al conectar la base de datos");
//
//Variables y constantes
//
$TAMANO_PAGINA = 10;
$PAGINAS_MAXIMAS = 5;
//
if (isset($_GET["p"])) {
	$pagina = $_GET["p"];
} else {
	$pagina = 1;
}
//
//Calculamos el inicio de la pagina
//
$inicio = ($pagina-1)*$TAMANO_PAGINA;
//
$q = "SELECT COUNT(*) as reg FROM alumnos";
$r = mysqli_query($conn,$q);
$data = mysqli_fetch_assoc($r);
$num = $data["reg"];
//
//Total de páginas
//
$totalPaginas = ceil($num/$TAMANO_PAGINA);
//
//Lectura de la página
//
$q = "SELECT * FROM alumnos LIMIT ".$inicio.", ".$TAMANO_PAGINA;
$r = mysqli_query($conn,$q);
print "<h2>Tenemos en total ".$num." alumnos</h2>";
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
	print "<td>".$data["id"]."</td>";
	print "<td>".$data["nombres"]."</td>";
	print "<td>".$data["apellidos"]."</td>";
	print "<td>".$data["fechaNacimiento"]."</td>";
	print "<td>".$data["promedio"]."</td>";
	print "<td>".$data["genero"]."</td>";
	print "</tr>";
}
print "</table>";
if($totalPaginas > $PAGINAS_MAXIMAS){
	//pagina actual es la ultima
	if ($pagina== $totalPaginas) {
		$inicio = $pagina-$PAGINAS_MAXIMAS;
		$fin = $totalPaginas;
	} else {
		$inicio = $pagina;
		$fin = $inicio-1 + $PAGINAS_MAXIMAS;
	}
	if ($inicio!=1) {
		print "<button type='button' onclick='cambiaPagina(1)'>Inicio</button>";
		print "<button type='button' onclick='cambiaPagina(".($pagina-1).")'>Anterior</button>";
	}
} else {
	$inicio = 1;
	$fin = $totalPaginas;
}
for($i=$inicio; $i<=$fin; $i++){
	print "<button type='button' ";
	if($i==$pagina) print " class='activo' ";
	print " onclick='cambiaPagina(".$i.")'>".$i."</button>";
}
if ($totalPaginas > $PAGINAS_MAXIMAS && $pagina!=$totalPaginas) {
		print "<button type='button' onclick='cambiaPagina(".($pagina+1).")'>Siguiente</button>";
		print "<button type='button' onclick='cambiaPagina(".$totalPaginas.")'>Fin</button>";
	}
?>
</body>
</html>