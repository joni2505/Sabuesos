<?php
require("../conexion.php");
if (isset($_POST['search_cliente'])) {
		
        $response = "<ul><li>No data found!</li></ul>";

        $cliente = $_POST['q'];
       
        $resultados = mysqli_query($conexion,"SELECT * FROM cliente WHERE nombre LIKE '%$cliente%'");
        
		while($consulta = mysqli_fetch_array($resultados))
        {
            $response = "<ul>";
            //$response = '<img src="data:image/jpeg/jpg/png;base64,'.base64_encode($consulta['imagen']).'" width="70" />&nbsp;&nbsp;&nbsp;'.$consulta['nombre_producto'].'';
            //$response = '<img src="data:image/jpeg/jpg/png;base64,'.base64_encode($consulta['imagen']).'" width="70" />&nbsp;&nbsp;&nbsp;'."Stock: ".$consulta['stock_producto'].'';

            $response .= "<li>" . $consulta['nombre'] . "</li>";
            
            
            $response .= "</ul>";

        }

        exit($response);
        
	}
    ?>