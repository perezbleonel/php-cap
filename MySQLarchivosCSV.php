<?php require("conn.php");

$archivo = fopen("prueba.csv","r");

$inicio = true;

while (!feof($archivo)) {

  //Leemos el registro en fromato CSV
  $data = fgetcsv($archivo);

  if ($inicio) {
    $inicio = false;
    continue;
  }
  $sql= "SELECT id FROM preguntas WHERE pregunta = '".$data[1]."'";

  // dQL Data Query Language
  $r = mysqli_query($conn,$sql);
  $num = mysqli_num_rows($r); 


  if($num == 0){
    $sql = "INSERT INTO preguntas VALUES(0,";
    $sql.= "'".$data[1]."', ";
    $sql.= "'".$data[2]."', ";
    $sql.= "'".$data[3]."', ";
    $sql.= "'".$data[4]."', ";
    $sql.= "'".$data[5]."', ";
    $sql.= $data[6].", ";
    $sql.= "'".$data[7]."')";

    //DML
    if (mysqli_query($conn, $sql)) {
      $id = mysqli_insert_id($conn);
      print "<p>Se insertó correctamente el registro con el id ".$id."</p>";
    } else {
      print "<p>Error al insertar el registro</p>";
    }
  }else{
    print"<p>Pregunta Duplicada".$data[1]. "</p>";
  }
}
fclose($archivo);
?>