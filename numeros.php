<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Force type</title>
</head>
<body>
    <?php
    $div = 10/3;
    print $div. "<br>";
    $entero = (int)$div;
    print $entero."<br>";
    var_dump($entero);
    print "<br>";
    print intval(10/3)."<br>";
    settype($div, "integer");
    var_dump($div);
    print"<br>";
    print gettype($div);

    ?>
</body>
</html>