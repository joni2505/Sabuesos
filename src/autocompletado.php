<?php
	require("../conexion.php");

    if (isset($_POST['search'])) {
		
        $response = "<ul><li>No data found!</li></ul>";

        $producto = $_POST['q'];
       
        $resultados = mysqli_query($conexion,"SELECT * FROM producto WHERE nombre_producto LIKE '%$producto%'");
        
		while($consulta = mysqli_fetch_array($resultados))
        {
            $response = "<ul>";
            //$response = '<img src="data:image/jpeg/jpg/png;base64,'.base64_encode($consulta['imagen']).'" width="70" />&nbsp;&nbsp;&nbsp;'.$consulta['nombre_producto'].'';
            $response = '<img src="data:image/jpeg/jpg/png;base64,'.base64_encode($consulta['imagen']).'" width="70" />&nbsp;&nbsp;&nbsp;'."Stock: ".$consulta['stock_producto'].'';

            $response .= "<li>" . $consulta['nombre_producto'] . "</li>";
            
            
            $response .= "</ul>";

        }

        exit($response);
        
	}

    if (isset($_POST['search_cliente'])) {
		
        $response2 = "<ul><li>No Existe el Cliente!</li></ul>";

        $cliente = $_POST['q'];
       
        $resultados = mysqli_query($conexion,"SELECT * FROM cliente WHERE nombre LIKE '%$cliente%' limit 1");
        
		while($consulta = mysqli_fetch_array($resultados))
        {
            $response2 = "<ul>";
            //$response = '<img src="data:image/jpeg/jpg/png;base64,'.base64_encode($consulta['imagen']).'" width="70" />&nbsp;&nbsp;&nbsp;'.$consulta['nombre_producto'].'';
            //$response = '<img src="data:image/jpeg/jpg/png;base64,'.base64_encode($consulta['imagen']).'" width="70" />&nbsp;&nbsp;&nbsp;'."Stock: ".$consulta['stock_producto'].'';

            $response2 .= "<h6><li style='cursor:pointer;'onclick='listaClientes();'>" . $consulta['nombre'] . "</li></h6>";
            
            
            $response2 .= "</ul>";

        }

        exit($response2);
        
	}

   
?>    