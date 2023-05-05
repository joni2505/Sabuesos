<?php include_once "includes/header.php"; ?>  
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
         <h5 class="text-center text-light">Informes Ventas</h5>
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
                                <th>cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require("../conexion.php");
                            $mes = $_GET['mes'];
                            $idlocal = $_GET['idlocal'];
                            $anio = $_GET['anio'];
                            $ac = 0;
                            $aci = 0;
                            $i = 1;
                            $query = mysqli_query($conexion, "SELECT producto.nombre_producto, ventas.total_venta'total', cantidad FROM ventas INNER JOIN producto on ventas.idproducto=producto.idproducto where mes='$mes' and ventas.idlocal=$idlocal and año=$anio");
                            $result = mysqli_num_rows($query);
                            if ($result > 0) {
                                while ($data = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <td><?php echo $data['nombre_producto']; ?></td>
                                        <td><?php echo $data['cantidad']; ?></td>
                                        <td><?php echo $data['total']; ?></td>
                                        <?php
                                        $totall = $data['total'];
                                        $cantidad = $data['cantidad'];
                                        $ac = $ac + $totall;
                                        $aci = $aci + $cantidad; ?>
                                        
                                    </tr>
                            <?php }
                            } ?>                          
                        </tbody>
                        
                        <tfoot>    
                    <tr class='font-weight-bold'>
                    <td colspan=1>MES INFORME
                    <input type='text' name='total' id='totalC' class='form-control' value='<?php echo $mes ?>' style='font-size: 20px;  text-transform: uppercase; color: black;'> </td>
                        <td colspan=1>COMPRAS
                    <input type='text' name='total' id='totalC' class='form-control' value='<?php echo $aci ?>' style='font-size: 20px;  text-transform: uppercase; color: black;'> </td>
                        <td colspan=1> TOTAL COMPRAS $
                        <input type='number' name='total' id='totalC' class='form-control' value='<?php echo $ac ?>' style='font-size: 20px;  text-transform: uppercase; color: black;'></td>
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
    <?php //include_once "includes/footer.php"; ?>
  

