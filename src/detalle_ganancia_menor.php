<?php include_once "includes/header_informes.php"; ?>  
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="#" />  
    
      
    <!-- Bootstrap CSS -->
    
    <!-- CSS personalizado --> 
    <link rel="stylesheet" href="exportar/main.css">  
      
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="exportar/datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="exportar/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
           
    <!--font awesome con CDN-->  
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">  
      
  </head>
  <body> 
  <header>
         <h5 class="text-center text-light">Informes Ventas X Menor</h5>
         <h2 class="text-center text-light">SABUESOS <span class="badge badge-warning">Petshop</span></h2> 
         <a href="#" onclick="printHTML()"; class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i><font _mstmutation="1" _msthash="507598" _msttexthash="259831">Imprimir</font></a>

     </header> 
    <div style="height:50px"></div>
     
    <!--Ejemplo tabla con DataTables-->
    <div class="container">
        <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive"> 
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Productos</th>
                                <th>Precio Compra</th>
                                <th>Precio Menor</th>
                                <th>cantidad</th>
                                <th>Descuento</th>
                                <th>Precio Final</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require("../conexion.php");
                            $mes = $_GET['mes'];
                            $idlocal = $_GET['idlocal'];
                            $anio = $_GET['anio'];
                            $ganancias_compras = $_GET['compra'];
                            $total_compra = $_GET['total_compras'];
                            $ac = 0;
                            $aci = 0;
                            $i = 1;
                            $acc=0;
                            $ganancias_menor = 0;
                            $recadacion_compras = 0;
                            $total_final = 0;
                            $query = mysqli_query($conexion, "SELECT producto.nombre_producto, ventas.mi_precio'precio_compra', ventas.subtotal'precio_menor', cantidad,descuento, preciofinal,ventas.total_venta, ventas.tipoventa FROM ventas INNER JOIN producto on ventas.idproducto=producto.idproducto where mes='$mes' and ventas.idlocal=$idlocal and año=$anio and tipoventa='Precio x Menor' ");
                            $result = mysqli_num_rows($query);
                            if ($result > 0) {
                                while ($data = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <td><?php echo $data['nombre_producto']; ?></td>
                                        <td><?php echo $data['precio_compra']; ?></td>
                                        <td><?php echo $data['precio_menor']; ?></td>
                                        <td><?php echo $data['cantidad']; ?></td>
                                        <td><?php echo $data['descuento']; ?></td>
                                        <td><?php echo $data['preciofinal']; ?></td>
                                        <td><?php echo $data['total_venta']; ?></td>
                                        <?php
                                        $totall = $data['total_venta'];
                                        $cantidad = $data['cantidad'];
                                        $ac = $ac + $totall;
                                        $aci = $aci + $cantidad; 
                                        $ganancias_menor = $ac - $ganancias_compras;
                                        $total_final = $ac - $total_compra;
                                        ?>
                                        
                                    </tr>
                            <?php }
                            } ?>                          
                        </tbody>
                        
                        <tfoot>    
                    <tr class='font-weight-bold'>
                    <td colspan=1>MES INFORME
                    <input type='text' name='total' id='totalC' class='form-control' value='<?php echo $mes ?>' style='font-size: 20px;  text-transform: uppercase; color: black;'> </td>
                        <td colspan=1>BULTOS
                    <input type='text' name='total' id='totalC' class='form-control' value='<?php echo $aci ?>' style='font-size: 20px;  text-transform: uppercase; color: black;'> </td>
                        <td colspan=1> TOTAL VENTA $
                        <input type='text' name='total' id='totalC' class='form-control' value='<?php echo "$".$ac ?>' style='font-size: 20px;  text-transform: uppercase; color: black;'></td>
                        <td colspan=1> RECAUDACION FINAL $
                        <input type='text' name='total' id='totalC' class='form-control' value='<?php echo "$".$total_final ?>' style='font-size: 20px;  text-transform: uppercase; color: black;'></td>
                    </tr>
                   
                    
                        </tfoot> 
                       </table>                  
                    </div>
                </div>
        </div>  
    </div>    
</body> 
</html>    
    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="exportar/jquery/jquery-3.3.1.min.js"></script>
    <script src="exportar/popper/popper.min.js"></script>
    <script src="exportar/bootstrap/js/bootstrap.min.js"></script>
      
    <!-- datatables JS -->
    <script type="text/javascript" src="exportar/datatables/datatables.min.js"></script>   
     
    <!-- para usar botones en datatables JS -->  
    <script src="exportar/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script> 
    <script src="exportar/datatables/JSZip-2.5.0/jszip.min.js"></script>    
    <script src="exportar/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>    
    <script src="exportar/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="exportar/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
     
    <!-- código JS propìo-->    
    <script type="text/javascript" src="exportar/main.js"></script> 
    <script>   
    function printHTML() { 
  if (window.print) { 
    window.print();
  }
}
</script>