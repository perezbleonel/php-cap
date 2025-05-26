<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir imagen</title>
    <style>
        body {
            background-color: #bbd4d8;
            width: 440px;
            margin: 0 auto;
        }
        th {
            background-color: #728987;
        }
        tr:nth-child(even) { background-color: #486273; }
        tr:nth-child(odd) { background-color: #ccc; }
        table { width: 100%; }
    </style>
    <?php
    // Habilitar la visualización de errores (solo necesitas hacerlo una vez al principio)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include "enviroment/conn.php"; // Debería mostrar "Conexion exitosa" si está configurado así en conn.php

    // El arreglo $msg es para almacenar los string de los posibles errores y mensajes de éxito
    $msg = array();
    $r = null; // Inicializar $r para evitar errores si no se ejecuta ninguna consulta que lo defina
    $id = "";  // Inicializar $id

    /*
    //Manejo CRUD
    /M=Mood
    /C=Create
    /R=Read
    /U=Update
    /B=Before DELETE B triggers a pop-up to confirm the DELETE.
    /D=Delete
    /K=Download
    */

    // LÓGICA POST (CREATE/UPDATE)
    if (isset($_POST["name"])) {
        $name = $_POST["name"] ?? "";
        // CORRECCIÓN: Asegúrate de que usas $_POST y no $POST_ ok
        $id_post = $_POST["id"] ?? ""; // Renombrada para evitar conflicto con $id de GET

        //CREATE
        if ($id_post == "") {
            if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != "") {
                $image_content = file_get_contents($_FILES['image']['tmp_name']);
                if (!empty($image_content)) {
                    $image = addslashes($image_content);
                    $sql = "INSERT INTO images(name, image) VALUES('$name','$image')";
                    if (mysqli_query($conn, $sql)) {
                        array_push($msg, "Se creo con exito");
                    } else {
                        array_push($msg, "ERROR: No se pudo crear - " . mysqli_error($conn));
                    }
                } else {
                    array_push($msg, "ERROR: La imagen seleccionada está vacía.");
                }
            } else {
                 array_push($msg, "ERROR: No se seleccionó ninguna imagen para crear.");
            }
        } else { //UPDATE
            $image = "";
            if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != "") {
                $image_content = file_get_contents($_FILES['image']['tmp_name']);
                if (!empty($image_content)) {
                    $image = addslashes($image_content);
                }
            }
            if ($name == "") {
                array_push($msg, "El nombre de la imagen no puede estar vacio");
            } else {
                $sql = "UPDATE images SET name='" . mysqli_real_escape_string($conn, $name) . "'";
                if ($image != "") {
                    $sql .= ", image='" . $image . "'"; // addslashes ya se aplicó
                }
                $sql .= " WHERE id=" . intval($id_post);
                if (mysqli_query($conn, $sql)) {
                    array_push($msg, "Se modifico correctamente");
                } else {
                    array_push($msg, "ERROR: No se pudo modificar - " . mysqli_error($conn));
                }
            }
        }
    }

    // MOOD HANDLER (Lógica GET)
    if (isset($_GET["M"])) {
        $M = $_GET["M"];
    } else {
        $M = "R";
    }
    echo "";

    // DELETE (Acción final de borrado)
    if ($M == "D") {
        $id = $_GET["id"] ?? "";
        if ($id != "") {
            $sql = "DELETE FROM images WHERE id=".intval($id);
            if (mysqli_query($conn, $sql)) {
                array_push($msg, "Imagen borrada");
            } else {
                array_push($msg, "Error: No se pudo borrar la imagen - " . mysqli_error($conn));
            }
        }
        $M = "R"; // Después de borrar, ir a la lista
    }
    echo "";

    // PREPARACIÓN DE DATOS PARA K (Download), U (Update Form), B (Before Delete View)
    $data_item = null; // Para almacenar los datos del ítem individual
    if ($M == "K" || $M == "U" || $M == "B") {
        $id = $_GET["id"] ?? ""; // $id se usa para K, U, B
        if ($id != "") {
            $sql = "SELECT * FROM images WHERE id=".intval($id);
            $result_item = mysqli_query($conn, $sql);
            if ($result_item && mysqli_num_rows($result_item) > 0) {
                $data_item = mysqli_fetch_assoc($result_item); // Usaremos $data_item para U y B
            } else if ($M != "K") { // No mostrar error si es K y no encuentra, podría ser diferente manejo
                 array_push($msg, "No se encontró el ítem con ID: ".htmlspecialchars($id));
            }
        } else if ($M != "K") {
            array_push($msg, "ID no especificado para la operación.");
        }

        // DOWNLOAD
        if ($M == "K") {
            if ($data_item) {
                // Sanitize name for filename
                $file_name_safe = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $data_item["name"]);
                $file = $file_name_safe . ".jpg";

                // Send headers to initiate download
                header('Content-Description: File Transfer');
                header('Content-Type: image/jpeg');
                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . strlen($data_item["image"]));
                echo $data_item["image"]; // Output the image data
                exit; // Terminate script after download
            } else {
                array_push($msg, "No se pudo descargar: Ítem no encontrado o imagen vacía.");
                // $M = "R"; // Ir a la lista si la descarga falla por ítem no encontrado
            }
            // No se cambia $M a "R" aquí directamente si la descarga tiene su propio flujo y termina con exit.
            // Si la descarga falla y no hace exit, podrías querer redirigir o cambiar $M.
            // Por ahora, si K falla y no hay exit, continuará el script, lo que podría ser no deseado.
            // Considerar un $M = "R"; aquí si la descarga falla y no se hace exit().
        }
        // ANTERIORMENTE: $M="R"; ESTA LÍNEA CAUSABA EL PROBLEMA. LA HEMOS ELIMINADO DE AQUÍ.
        // Ahora M permanece como B o U si entraron así.
    }
    echo "";

    //READ (Carga la lista completa si $M es "R")
    if ($M == "R") {
        $sql = "SELECT * FROM images";
        $r = mysqli_query($conn, $sql); // $r ahora es para la lista general
        echo "";
    } else if ($M == "U" || $M == "B") {
        // Si M es U o B, y $data_item fue cargado, $r (para la tabla) puede ser el resultado del ítem individual
        // Para simplificar, la tabla principal siempre usará $r de la lista completa si M es R,
        // y para M=B, mostraremos el ítem específico ANTES de la confirmación.
        // Si M es U, se muestra el formulario.
        // Si M es B, el $data_item ya tiene los datos del ítem a borrar.
        // El $r para la tabla principal solo se llena si M=R.
        // Para M=B, la tabla principal (lista) no se mostraría idealmente, solo la info del ítem a borrar.
        // Ajustaremos la lógica de la tabla.
    }
    ?>
    <script>
        window.onload = function() {
            <?php echo "/* JS DEBUG: M en script es: [$M] */"; ?>
            <?php if ($M == "R") { ?>
                if (document.getElementById("create")) {
                    document.getElementById("create").onclick = function() {
                        window.open("index.php?M=C", "_self");
                    }
                }
            <?php } ?>

            <?php if ($M == "B" && $data_item) { // Solo generar JS si M es B y tenemos datos del ítem ?>
                if (document.getElementById("yes")) {
                    document.getElementById("yes").onclick = function() {
                        let id = <?php echo intval($data_item['id']); ?>;
                        window.open("index.php?M=D&id=" + id, "_self");
                    }
                }
                if (document.getElementById("no")) {
                    document.getElementById("no").onclick = function() {
                        window.open("index.php", "_self");
                    }
                }
            <?php } ?>
        }
    </script>
</head>
<body>
    <?php
    echo "";

    if ($M == "R") {
        print "<label for='create'></label>";
        print "<input type='button' name='create' value='Subir una imagen' id='create'>";
    }

    // Mostrar mensajes
    if (count($msg) > 0) {
        print "<div style='border:1px solid #900; padding:10px; margin-bottom:10px; background-color:#fee;'>";
        foreach ($msg as $key => $value) {
            print "<strong>" . htmlspecialchars($value) . "</strong><br>";
        }
        print "</div>";
    }

    // FORMULARIO para CREATE o UPDATE
    if ($M == "C" || ($M == "U" && $data_item)) {
    ?>
        <form action="index.php" method="post" enctype="multipart/form-data" style="margin-bottom:20px; padding:10px; border:1px solid #666;">
            <h3><?php echo ($M == "C") ? "Subir nueva imagen" : "Modificar imagen"; ?></h3>
            <input type="text" required name="name" placeholder="Ingrese el nombre de su imagen" 
                   value="<?php if ($M == "U" && isset($data_item['name'])) print htmlspecialchars($data_item['name']); ?>">
            <br>
            <?php if ($M == "U" && isset($data_item['image'])) {
                print "<br><img width='100' src='data:image/jpeg;base64," . base64_encode($data_item['image']) . "'/><br>";
            } ?>
            <input type="file" <?php if ($M == 'C') print "required"; ?> name="image" id="image">
            <br>
            <input type="hidden" name="id" id="id" value="<?php if ($M == "U" && isset($data_item['id'])) print intval($data_item['id']); ?>">
            <input type="submit" value="<?php echo ($M == "C") ? "Subir archivo" : "Guardar Cambios"; ?>">
            <a href="index.php">Regresar a la lista</a>
        </form>
    <?php
    } // Fin del formulario C o U

    // VISTA DE CONFIRMACIÓN PARA BORRADO (Modo B)
    if ($M == "B") {
        echo "";
        if ($data_item) {
    ?>
            <div style="border:2px solid red; padding:15px; margin-bottom:20px;">
                <h3>Confirmar Eliminación</h3>
                <p>¿Desea borrar la imagen "<strong><?php echo htmlspecialchars($data_item['name']); ?></strong>"?</p>
                <p><img width='100' src='data:image/jpeg;base64,<?php echo base64_encode($data_item['image']); ?>'/></p>
                <p>
                    <input type='button' name='yes' value='Sí, Borrar' id='yes'/>
                    <input type='button' name='no' value='No, Cancelar' id='no'/>
                </p>
                <p><small>Una vez borrado el registro NO se podrá recuperar.</small></p>
            </div>
    <?php
        } else {
            // El mensaje de "ítem no encontrado" ya se habrá añadido a $msg
            print "<p>Regrese a la <a href='index.php'>lista principal</a>.</p>";
        }
    } // Fin de la vista de confirmación M=B

    // TABLA DE IMÁGENES (Solo se muestra si M es "R" o si M es B y no hay ítem (para ver la lista))
    // Idealmente, si M=B y el ítem existe, solo muestras la confirmación.
    // Si M=R, muestras la tabla.
    echo "";
    if ($M == "R") { // Mostrar tabla solo en modo Read
        if ($r && mysqli_num_rows($r) > 0) {
    ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Imagen</th>
                        <th>Borrar</th>
                        <th>Modificar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($data_row = mysqli_fetch_assoc($r)) { // Renombrado $data a $data_row para evitar conflicto
                        print "<tr>";
                        print "<td>" . $data_row["id"] . "</td>";
                        print "<td><a href='index.php?M=K&id=" . $data_row['id'] . "'>" . htmlspecialchars($data_row["name"]) . "</a></td>";
                        print "<td><img width='100' src='data:image/jpeg;base64," . base64_encode($data_row['image']) . "'/></td>";
                        print "<td><a href='index.php?M=B&id=" . $data_row['id'] . "'>Borrar</a></td>";
                        print "<td><a href='index.php?M=U&id=" . $data_row['id'] . "'>Modificar</a></td>";
                        print "</tr>";
                    }
                    ?>
                </tbody>
            </table>
    <?php
        } else if ($M == "R") { // Solo muestra "No hay imágenes" si estamos en modo R y no hay resultados
            print "<p>No hay imágenes para mostrar.</p>";
        }
    } // Fin de if ($M == "R") para la tabla
    ?>
</body>
</html>