<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar correo HTML</title>
</head>
<body>
    <?php
        $to="correo@misitio.com, correo2@misitio.com";
        $subject="Recordatorio de cumpleaños";
        $message=
        "<html>
            <head>
                <title>
                    Recordatorio de los cumpleaños del mes de Abril
                </title>
            </head>
            <body>
                <h4>Estas son las personas que cumplen años en Abril</h4>
                <table>
                    <thead>
                        <tr>
                            <th>
                                Empleado
                            </th>
                            <th>
                                Día
                            </th>
                            <th>
                                Mes
                            </th>
                            <th>
                                Año
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Juanita Perez</td><td>1</td><td>Abril</td><td>1990</td></tr>
                        <tr><td>Juan Perez</td><td>30</td><td>Mayo</td><td>2005</td></tr>
                        <tr><td>Jorge Martín</td><td>15</td><td>Julio</td><td>1995</td></tr>
                        <tr><td>Rodrigo Rodriguez</td><td>12</td><td>Enero</td><td>2000</td></tr>
                    </tbody>
                </table>
            </body>
        </html>";

        //Cabeceras
        $header = "MIME-Version: 1.0" ."\r\n";
        $header .= "Content-type: text/html; charset=iso-8859-1"."\r\n";

        //Otras cabeceras
        $header .= "To: Mary <recursoshumanos@misitio.com>, Direccion <correo2@misitio.com>"."\r\n";
        $header .= "From: Leonel <cumples@misitio.com>"."\r\n";
        $header .= "Cc: pepito@misitio.com"."\r\n";
        $header .= "Bcc: juanito@misitio.com"."\r\n";

        mail($to,  $subject, $message, $header);

    ?>
</body>
</html>