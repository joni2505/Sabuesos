//auto completado input
$(document).ready(function () {
    $("#producto").keyup(function () {
       
        var query = $("#producto").val();
  
        if (query.length > 0) {
            $.ajax(
                {
                    url: 'autocompletado.php',
                    method: 'POST',
                    data: {
                        search: 1,
                        q: query
                    },
                    success: function (data) {
                        $("#response").html(data);
                    },
                    dataType: 'text'
                }
            );
        }
    });
    
    $(document).on('click', 'li', function () {
        var country = $(this).text();
        $("#producto").val(country);
        $("#response").html("");
    });
  });
  
 
  
  //agregar producto suelto nuevo
  function agregar_suelto()
  {
  idlocal = $("#idlocal").val();
  producto = $("#producto").val();
  kg = $("#kg").val();
  gramos = $("#gramos").val();
  gramosFijos = $("#gramos").val();
  precio = $("#precio3").val();
  stock = $("#stock3").val();
  
  var parametros = 
  {
  "nuevo_producto": "1",
  "producto" : producto,
  "kg" : kg,
  "gramos" : gramos,
  "gramosFijos" : gramosFijos,
  "precio" : precio,
  "idlocal" : idlocal,
  "stock" : stock
  
  
  };
  $.ajax(
  {
  data:  parametros,
  url:   'datos_producto.php',
  type:  'post',
  
  error: function()
  {alert("Error");},
  
  success:  function (mensaje) 
  {
  $('#mostrar_mensaje').html(mensaje); 
  $("#producto").val("");
  $("#stock3").val("");
  $("#gramos").val("");
  $("#precio3").val("");
  $("#kg").val("");
  tabla_suelto();
  
  }
  
  }) 
  
  }  