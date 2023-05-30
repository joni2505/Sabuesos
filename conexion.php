<?php
    //conexion local
    $host = "localhost";
    $user = "u765647919_creating";
    $clave = "600269Joni2505";
    $bd = "u765647919_sabuesos";

    //conexion mysql remoto
    //$host = "185.213.81.103";
    //$ServerName = "185.213.81.103";
    //$user = "u765647919_creating";
    //$clave = "600269Joni2505";
    //$bd = "u765647919_sabuesos";
    

    $conexion = mysqli_connect($host,$user,$clave,$bd);
    if (mysqli_connect_errno()){
        echo "No se pudo conectar a la base de datos";
        exit();
    }

    mysqli_select_db($conexion,$bd) or die("No se encuentra la base de datos");

    mysqli_set_charset($conexion,"utf8");


?>