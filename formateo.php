<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
     $monto = 1500;
     $tasaIVA=0.16;
     $montoIVA= $monto * $tasaIVA;
     $granTotal = $monto + $montoIVA;
     
     $retISR =0.1;
     $retIVA = 0.166667;
     $montoRetIVA = $granTotal * $retIVA;
     $montoRetISR = $granTotal * $retISR;

     $total = $granTotal - $montoRetIVA - $montoRetISR;

     $sTotal = sprintf("<p> Total: $%6.2f<p>" , $total);
     print $sTotal;

    ?>
</body>
</html>