<?php
	require("../conexion.php");

  if(isset($_POST['nuevo_cliente']))
	{
        $nombre = $_POST['nombre'];
        //$apellido = $_POST['apellido'];
        $celular = $_POST['celular'];
        $direccion = $_POST['direccion'];
         
        if (empty($_POST['nombre'])  || empty($_POST['direccion'])) {
            echo '<script language="javascript">';
          echo 'alert("Todos los Campos son requeridos");';
          echo '</script>';
        }else{

        $query = mysqli_query($conexion, "SELECT * FROM cliente WHERE nombre = '$nombre'");
        $result = mysqli_fetch_array($query);
        if ($result > 0) {
            echo '<script language="javascript">';
          echo 'alert("Ya existe el Cliente");';
          echo '</script>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO cliente(nombre,direccion,celular) values ('$nombre', '$direccion', '$celular')");
            if ($query_insert) {
                echo '<script language="javascript">';
                echo 'alert("Cliente Agregado Correctamente");';
                echo '</script>';
            } else {
                echo '<script language="javascript">';
                echo 'alert("Error al Agregar Cliente");';
                echo '</script>';
            }
        }
    }
}

?>