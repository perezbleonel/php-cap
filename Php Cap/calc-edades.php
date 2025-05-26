<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcular edades</title>
</head>

<body>
    <?php
    function edad($fecha)
    {
        $dia = date("j");
        $mes = date("n");
        $anio = date("Y");

        $aNacimiento = substr($fecha, 0, 4);
        $mNacimiento = substr($fecha, 5, 2);
        $dNacimiento = substr($fecha, 8, 2);
        //Si el mes es menor, es decir aun NO cumple años se calcula el año menos el año de nacimiento -1
        if ($mNacimiento > $mes) {
            $edad = $anio - $aNacimiento - 1;
        } else if ($mes == $mNacimiento && $dNacimiento > $dia) {
            $edad = $anio - $aNacimiento - 1;
        } else {
            $edad = $anio - $aNacimiento;
        }

        return $edad;
    }
    print "Tenemos ".edad("1995-07-30"). " años";
    ?>
    
</body>

</html>