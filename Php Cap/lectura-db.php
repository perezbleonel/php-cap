<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $host="localhost";
    $user="root";
    $password="";
    $db="alumnos";
    $port="3306";

    $conn= mysqli_connect($host, $user, $password, $db, $port)or die ("Error al conectar con la base de datos");
    $q="SELECT * FROM alumnos";
    $r = mysqli_query($conn,$q);
    print"<table border=1>";
        print"<thead>"; 
            print"<tr>"; 
                print"<th>Num.</th>";
                print"<th>Nombres</th>";
                print"<th>Apellidos</th>";
                print"<th>Fecha de Nacimiento</th>";
                print"<th>Promedio</th>";
                print"<th>Género</th>";
            print"</tr>";
        print"</thead>";
        print"<tbody>"; 
            while($data = mysqli_fetch_assoc($r)){
               print "<tr>";
                print"<td>" .$data["id"]."</td>";
                print"<td>" .$data["nombres"]."</td>";
                print"<td>" .$data["apellidos"]."</td>";
                print"<td>" .$data["fechaNacimiento"]."</td>";
                print"<td>" .$data["promedio"]."</td>";
                print"<td>" .$data["genero"]."</td>";
               print "</tr>";
            }
        print"</tbody>";
    print"</table>";
    

    

    ?>
</body>
</html>