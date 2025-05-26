<?php 
    $host="localhost";
    $user="root";
    $password="";
    $port="3306";
    $db="quiz";

    //DataBase connection.
    $conn= mysqli_connect($host,$user,$password,$db,$port);

    if(mysqli_connect_errno()){
        printf("Error en la conexion :%s <br>", mysqli_connect_error());
        exit();
    }else{
        print"Conexion exitosa";
    }
?>