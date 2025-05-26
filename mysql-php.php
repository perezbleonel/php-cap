<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    $host="localhost";
    $password="";
    $usuario="root";
    $db="quiz";
    $puerto="3306";

    $conn =  mysqli_connect($host, $usuario, $password, $db, $puerto) or die ("Error al conectar");
    print"Conexion exitosa";

    $q = "SELECT * FROM preguntas";
    $r = mysqli_query($conn, $q);
    $n = mysqli_num_rows($r);

?>
</head>
<body>
    <?php
        print "<h2> Tabla de datos" .$n . "</h2>";
        print "<table border = '1'>";
        while($data = mysqli_fetch_assoc($r)){
            print "<tr>";
                print"<td>" .$data["pregunta"]. "</td>";
                print"<td>" .$data["op1"]. "</td>";
                print"<td>" .$data["op2"]. "</td>";
                print"<td>" .$data["op3"]. "</td>";
                print"<td>" .$data["op4"]. "</td>";
                print"<td>" .$data["buena"]. "</td>";
                print"<td>" .$data["examen"]. "</td>";
            print "</tr>";
        }
         print "</table>";
    ?>
    
</body>
</html>