<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Subir una imagen a la base de datos</title>
	<style>
		body{
			background-color: #bbd4d8;
			width: 440px;
			margin: 0 auto;
		}
		th{
			background-color: #728987;
		}
		tr:nth-child(even){ background-color:#486273; }
		tr:nth-child(odd){ background-color:#ccc; }
		table{ width:100%; }
	</style>
	<?php  
	include "conn.php";
	$msg = array();
	/******
	 * m = modo
	 * a alta
	 * b baja
	 * c cambio
	 * d eliminar
	 * s seleccionar
	 * k descargar
	 * */
	if (isset($_POST["nombre"])) {
		$nombre = $_POST['nombre'] ?? "";
		$id = $_POST['id'] ?? "";
		//
		//a alta
		//
		if ($id=="") {
			$imagen = addslashes(file_get_contents($_FILES['imagen']["tmp_name"]));
			if (!empty($imagen)) {
				$sql = "INSERT INTO imagenes(nombre,imagen) VALUES('$nombre','$imagen')";
				if (mysqli_query($conn,$sql)) {
					array_push($msg,"Se insertó correctamente");
				} else {
					array_push($msg,"ERROR: No se insertó correctamente");
				}
			}
		} else {
			// 
			//c cambio
			//
			if (isset($_FILES['imagen']["tmp_name"]) && $_FILES['imagen']["tmp_name"]!="") {
				$imagen = addslashes(file_get_contents($_FILES['imagen']["tmp_name"]));
			} else {
				$imagen = "";
			}
			if ($nombre=="") {
				array_push($msg,"El nombre de la imagen no puede estar vacío.");
			} else {
				$sql = "UPDATE imagenes SET ";
				$sql.= "nombre='".$nombre."'";
				if ($imagen!="") {
					$sql.= ", imagen='".$imagen."'";
				}
				$sql.= " WHERE id=".$id;
				if (mysqli_query($conn,$sql)) {
					array_push($msg,"Se modificó correctamente");
				} else {
					array_push($msg,"ERROR: Al modificar el registro");
				}
			}
		}
	}
	//
	//Recibimos el "modo"
	//
	if (isset($_GET["m"])) {
		$m = $_GET["m"];
	} else {
		$m = "s";
	}
	//
	// d borramos el registro
	//
	if ($m=="d") {
		$id = $_GET["id"] ?? "";
		if ($id!="") {
			$sql = "DELETE FROM imagenes WHERE id=".$id;
			if(mysqli_query($conn, $sql)){
				array_push($msg, "Registro borrado correctamente");
			} else {
				array_push($msg, "Error al borrar el registro");
			}
			$m = "s";
		}
	}
	//
	// b / c / k leer un registro registro
	//
	if ($m=="c" || $m=="b" || $m=="k") {
		$id = $_GET["id"] ?? "";
		if ($id!="") {
			$sql = "SELECT * FROM imagenes WHERE id=".$id;
			$r = mysqli_query($conn, $sql);
		}
		//
		//k descarga
		//
		if ($m=="k") {
			$data = mysqli_fetch_assoc($r);
			$imagen = $data["imagen"];
			$nombre = utf8_encode($data["nombre"]);
			$archivo = $nombre.".jpg";
			file_put_contents($archivo, $imagen);
		}
		$m="s";
	}
	//
	// s lee toda la tabla
	//
	if ($m=="s") {
		$sql = "SELECT * FROM imagenes";
		$r = mysqli_query($conn, $sql);
	}
	?>
	<script>
		window.onload=function(){
			<?php if($m=="s") { ?>
				document.getElementById("alta").onclick =function(){
					window.open("index.php?m=a","_self");
				}
			<?php } ?>

			<?php if($m=="b") { ?>
				document.getElementById("si").onclick =function(){
					let id = <?php print $id; ?>;
					window.open("index.php?m=d&id="+id,"_self");
				}
				document.getElementById("no").onclick =function(){
					window.open("index.php","_self");
				}
			<?php } ?>
		}
	</script>
</head>
<body>
	<?php
	if ($m=="s") {
	 	print "<label for='alta'></label>";
	 	print "<input type='button' name='alta' value='Subir una imagen' id='alta'/>";
	 } 
	if($m=="a" || $m=="b" || $m=="c"){
		if (count($msg)>0) {
		 	print "<div>";
		 	foreach ($msg as $key => $valor) {
		 		print "<strong>* ".$valor."</strong><br>";
		 	}
		 	print "</div>";
		 } 
	?>
	<?php 
	if($m=='a' || $m=="c"){ 
		if ($m=="c") {
			$data = mysqli_fetch_assoc($r);
		}

	?>
	<form action="index.php" method="post" enctype="multipart/form-data">
		<input type="text" required name="nombre" placeholder="Nombre del archivo en la base de datos" value="<?php if($m=="c") print $data["nombre"]; ?>">
		<?php if($m=="c") print "<br><img width='200' src='data:/image/jpg;base64,".base64_encode($data['imagen'])."'/><br>"; ?>
		<input type="file" <?php if($m=="a") print "required "; ?> name="imagen">
		<input type="hidden" value="<?php print $data['id']??""; ?>" name="id" id="id">
		<input type="submit" value="Subir archivo">
		<a href="index.php">Regresar</a>
	</form>
	<?php
	} 
	}

	if($m=="s" || $m=="b"){ 
	?>
	<table border="1">
		<thead>
			<tr>
				<th>id</th>
				<th>Nombre</th>
				<th>Imagen</th>
				<?php if($m=="s"){ ?>
					<th>Borrar</th>
					<th>Modificar</th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<?php  
			while ($data = mysqli_fetch_assoc($r)) {
				print "<tr>";
				print "<td>".$data["id"]."</td>";
				print "<td><a href='index.php?m=k&id=".$data['id']."'>".$data["nombre"]."</a></td>";
				print "<td><img width='200' src='data:/image/jpg;base64,".base64_encode($data['imagen'])."'/></td>";
				if($m=="s"){
					print "<td><a href='index.php?m=b&id=".$data['id']."'>Borrar</td>";
					print "<td><a href='index.php?m=c&id=".$data['id']."'>Modificar</td>";
				}
				print "</tr>";
			}
			?>
		</tbody>
	</table>
	<?php 
	if ($m=='b') {
		print "<label for='si'>¿Desa borrar la imagen?</label>";
	 	print "<input type='button' name='si' value='Si' id='si'/>";
	 	print "<input type='button' name='no' value='No' id='no'/>";
	 	print "<p>Una vez borrado el registro NO se podrá recuperar</p>";
	}

	} ?>
</body>
</html>