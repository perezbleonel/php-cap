<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php 
        if(isset($_POST['mostrar'])){
             $nombre = isset($_POST['nombre'])?$_POST['nombre']:'';
        }
        $error = array();

        if($nombre==""){
            $error[0]="Error: El nombre de usuario no puede estarn en blanco";
        }
    ?>
    <style type="test/css">
        .erro{color:red;}
    </style>
</head>
<body>
    <form action="" method="POST">
        <label for=""></label>
        <input type="text" name="nombre" id="name" value="<?php print isset($nombre)? $nombre : ''; ?>">
        <?php 
            if(isset($error[0])){
                print "<p class='error'>" .$error[0]. "</p>";
            }
        ?>
        <input type="hidden" name="mostrar" value="1">
    </form>
</body>
</html>