<!DOCTYPE html>
<html>
<head>
	<title>Formulario</title>
	<style>
		.error{ color:red; margin:0; padding: 0;}
	</style>
<?php
$error = array();
$idiomas_array = array("Selecciona un idioma","Español","Inglés","Francés","Alemán");
$estados_array = array("","Soltero","Casado","Viudo");
if(isset($_POST["bandera"])){
	/********************
	 * Recibir los datos
	 * ******************/
	$nombre = isset($_POST["nombre"])?$_POST["nombre"]:"";
	$clave = isset($_POST["clave"])?$_POST["clave"]:"";
	$comentarios = isset($_POST["comentarios"])?$_POST["comentarios"]:"";
	$estado = isset($_POST["estado"])?$_POST["estado"]:"";
	$idioma = isset($_POST["idioma"])?$_POST["idioma"]:"";
	$pasatiempos = isset($_POST["pasatiempos"])?$_POST["pasatiempos"]:[];
	$pasteles = isset($_POST["pasteles"])?$_POST["pasteles"]:[];
	var_dump($estado);
	/********************
	 * Validar los datos
	 * ******************/
	if($nombre==""){
		$error[0] = "Error: el nombre del usuario no puede estar vacío";
	} 
	if($clave==""){
		$error[1] = "Error: la clave de acceso no puede ser vacía";
	} 
	if($comentarios==""){
		$error[2] = "Error: los comentarios son requeridos";
	} 
	if($idioma=="0"){
		$error[3] = "Error: el idioma es requerido";
	}
	if($estado==""){
		$error[4] = "Error: el estado civil es requerido";
	} 
	if(isset($pasatiempos)){ 
		if(count($pasatiempos)==0){
			$error[5] = "Error: debe de seleccionar al menos un pasatiempo";
		}
	} else {
		$error[6] = "Error: debe de seleccionar al menos un pasatiempo";
	}
	if(isset($pasteles)){ 
		if(count($pasteles)==0){
			$error[7] = "Error: debe de seleccionar al menos un sabor de pastel";
		}
	} else {
		$error[8] = "Error: debe de seleccionar al menos un sabor de pastel";
	} 
} 
?>
</head>
<body>
	<?php  
	if(count($error)==0 && isset($_POST["bandera"])){
		print "<h1>Bienvenido, ".$nombre." a nuestra página</h1>";
		print "<p>Clave de usuario: ".$clave."</p>";
		print "<p>Comentarios     : ".$comentarios."</p>";
		print "<p>Estado Civil    : ".$estado."</p>";
		print "<p>Idioma          : ".$idioma."</p>";
		print "<p>Num. pasatiempos: ".count($pasatiempos)."</p>";
		print "<ol>";
		foreach ($pasatiempos as $key => $value) {
			print "<li>".$value."</li>";
		}
		print "</ol>";
		print "<p>Sabor de pasteles: ".count($pasteles)."</p>";
		print "<ol>";
		foreach ($pasteles as $key => $value) {
			print "<li>".$value."</li>";
		}
		print "</ol>";
	} else {
	?>
	<form action="formulario.php" method="POST">
		<label for="nombre">* Nombre:</label><br>
		<input type="text" name="nombre" id="nombre" value="<?php print isset($nombre)?$nombre:'';?>"  /><br>
		<?php  if(isset($error[0])) print "<p class='error'>".$error[0]."</p>";?>
		<label for="clave">* Clave:</label><br>
		<input type="password" name="clave" id="clave"/><br>
		<?php  
		if(isset($error[1])) print "<p class='error'>".$error[1]."</p>";
		?>
		<label for="comentarios">Comentarios:</label><br>
		<textarea id="comentarios" name="comentarios"><?php print isset($comentarios)?$comentarios:'';?></textarea><br>
		<?php  
		if(isset($error[2])) print "<p class='error'>".$error[2]."</p>";
		?>
		<label for="idioma">Idioma:</label><br>
		<select id="idioma" name="idioma">
			<?php
			for ($i=0; $i < count($idiomas_array); $i++) { 
				print "<option value='";
				print $i."'";
				if (isset($idioma)) {
					if ($idioma==$i) {
						print " selected";
					}
				}
				print ">";
				print $idiomas_array[$i]."</option>";
			}
			?>
		</select><br>
		<?php  
		if(isset($error[3])) print "<p class='error'>".$error[3]."</p>";
		?>
		<label for="estado">Estado:</label><br>
		<?php
		for ($i=0; $i < count($estados_array); $i++) {
			if ($estados_array[$i]!="") {
			 	print '<input type="radio" name="estado" ';
			 	print 'id="'.$estados_array[$i].'" ';
			 	if(isset($estado) && $estado==$i){
			 		print " checked ";
			 	}
			 	print 'value="'.$i.'">';
			 	print '<label for="'.$estados_array[$i].'">';
			 	print $estados_array[$i].'</label><br>';
			 } 
		}
 
		if(isset($error[4])) print "<p class='error'>".$error[4]."</p>";
		?>
		<label>Pasatiempos:</label><br>
		<label><input type="checkbox" name="pasatiempos[]" value="leer" id="leer">Leer</label><br>
		<label><input type="checkbox" name="pasatiempos[]" value="dormir" id="dormir">Dormir</label><br>
		<label><input type="checkbox" name="pasatiempos[]" value="ajedrez" id="ajedrez">Ajedrez</label><br><br>
		<?php  
		if(isset($error[5])) print "<p class='error'>".$error[5]."</p>";
		if(isset($error[6])) print "<p class='error'>".$error[6]."</p>";
		?>
		<label for="pasteles">Sabor de pasteles preferidos:</label><br>
		<select multiple="multiple" name="pasteles[]" id="pasteles">
			<option value="chocolate">Chocolate</option>
			<option value="fresa">Fresa</option>
			<option value="vainilla">Vainilla</option>
			<option value="coco">Coco</option>
			<option value="napolitano">Napolitano</option>
		</select><br>
		<?php  
		if(isset($error[7])) print "<p class='error'>".$error[7]."</p>";
		if(isset($error[8])) print "<p class='error'>".$error[8]."</p>";
		?>
		<input type="hidden" name="bandera" id="bandera" value="bandera">
		<input type="submit" value="Enviar datos"/>
	</form>
	<?php } ?>
</body>
</html>