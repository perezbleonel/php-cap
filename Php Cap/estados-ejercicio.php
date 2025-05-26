<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    if (isset($_POST["estado"])) {
        $tc = 1145;
        $cantidad = $_POST["cantidad"];
        $tipo = $_POST["tipo"];
        if ($tipo == "1") {
            $r = $cantidad * $tc;
            $rc = number_format($r, 2);
            print "<p> Su " . $cantidad . " dolares al cambio con una tasa de " .$tc. " por cada dolar son" . $rc . "</p>";
        } else {
            $r = $cantidad / $tc;
            $rc = number_format($r, 2);
            print "<p> Su " . $cantidad . " pesos al cambio  con una tasa de " .$tc." por cada dolar es " . $rc . "</p>";
        }
    }
    ?>
</head>

<body>
<!-- La propiedad action es necesario que tenga el nombre del achivo que va a realizar la funcion -->
<!-- Existe un metodo en PHP para autollamarse a si mismo y es  print $_SERVER['PHP_SELF'];  -->

    <form action="estados-ejercicio.php" method="post">
        <label for="cantidad">Introduzca la cantidad a convertir:</label>
        <input type="text" name="cantidad">
        <br></br>
        <input type="radio" name="tipo" value="1">Dolares Americanos
        <input type="radio" name="tipo" value="2">Pesos Argentinos
        <input type="hidden" name="estado" value="1">
        <input type="submit" value="convertir">
    </form>
</body>

</html>