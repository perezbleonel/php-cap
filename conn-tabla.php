<?php require_once("conn.php"); ?>
<!DOCTYPE html>>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    $pregunta="¿Cual es la capital de España";
    $op1="Barcelona";
    $op2="Madrid";
    $op3="Caracas";
    $op4="Valladolid";
    $res="2";
    $exmane="GE001";

    $q = "INSERT INTO preguntas(id,pregunta,op1,op2,op3,op4,buena,exmane)";
    //$r = mysqli_query($conn, $q);
   // $n = mysqli_num_rows($r);
    $q .="VALUES(0,'".$pregunta."','".$op1."','".$op2."','".$op3."','".$op4."','".$res."','".$exmane."')";
    print $q;
    $r = mysqli_query($conn,$q);
    if($r){
        print "<p> Se inserto correctamente el registro </p>";
    }else{
        print "<p> Error al insertar el registro </p>";
    }

?>
</head>
<body>
    
</body>
</html>