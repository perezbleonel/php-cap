    <?php
        $host="localhost";
        $password="";
        $usuario="root";
        $db="quiz";
        $puerto="3306";
        $conn =  mysqli_connect($host, $usuario, $password, $db, $puerto); 
        
        if(mysqli_connect_errno()){
            printf("Error en la conexion: %s <br>",mysqli_connect_error());
            exit();
        }else{
            print"Conexion exitosa";
        }

        printf("El conjunto de caracteres inicial es :%s <br>", mysqli_character_set_name($conn));
        ///En este caso no es necesario usar el "UTF-8, se realiza sin el guion
        /// El uso de !mysqli_set_charset  es importante para segurarnos que el charset sea el mismo, al momento de usar librerias como Laravel
        if(!mysqli_set_charset($conn,"utf8")){
            printf("Error cargando el conjunto de caraceres: %s <br>",mysqli_error($conn));
            exit();
        }else{
            printf("El conjunto de caracteres actual es : %s <br>", mysqli_character_set_name($conn));
        }
    ?>