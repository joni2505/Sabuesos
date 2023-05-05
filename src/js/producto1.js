document.addEventListener("DOMContentLoaded", function () {
  $('#table2').DataTable();
  $(".confirmar").submit(function (e) {
      e.preventDefault();
      Swal.fire({
          title: 'Esta seguro de eliminar?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'SI, Eliminar!'
      }).then((result) => {
          if (result.isConfirmed) {
              this.submit();
          }
      })
  })
}) 
//mostrar marcas segun rubros
function listaMarcas()
{ 
alert("entroo");
buscar = document.getElementById('idrubro1').value;
var parametros = 
{

"idrubro" : buscar,
"lista_marcas" : "4"
};

$.ajax({
data: parametros,
url: 'tablas.php',
type: 'POST',

beforesend: function()
{
$('#mostrar_marcas').html("Mensaje antes de Enviar");

},

success: function(mensaje)
{
$('#mostrar_marcas').html(mensaje);

}
});
}

//click en tbl marca
$('order-table tr').on('click', function(){
var idmarca2 = $(this).find('td:nth-child(1)').html();
var dato2 = $(this).find('td:nth-child(2)').html();
var dato3 = $(this).find('td:nth-child(3)').html();

$('#marca').val(dato2);
$('#detalle').val(dato3);

});

//imprimir tabla
function imprimirTabla()
{

url = 'generar_lista.php';
window.open(url, '_blank')
}

//agregar lista
function agregarLista()
{

rubro = $("#idrubro1").val();
marca = $("#idmarca1").val();

var parametros = 
{
"agregar_lista": "1",
"rubro" : rubro,
"marca" : marca



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
tablaPDF();
}

}) 

}
// imprimir lista
function imprimirLista()
  {
    
    idrubro1 = $("#idrubro1").val();
    idmarca1 = $("#idmarca1").val();
    
    var parametros = 
    {
      "idrubro1" : idrubro1,
      "idmarca1" : idmarca1
      
    };
    $.ajax(
    {
      data:  parametros,
      error: function()
      {alert("Error");},
    
      success:  function () 
      {
        url = 'lista_producto_imprimir.php?idrubro=' + idrubro1 + '&idmarca=' + idmarca1;
        window.open(url, '_blank')
      }
    })

  }

//eliminar lista pdf
function eliminarLista()
{

var parametros = 
{
"eliminar_lista": "1",
"marca" : "2"



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
tablaPDF();
}

}) 

}

//mostrar tabla lista pdf
function tablaPDF()
{ 

var parametros = 
{
"tabla_lista" : "a",
"accion" : "4"


};

$.ajax({
data: parametros,
url: 'tablas.php',
type: 'POST',

beforesend: function()
{
$('#mostrar_tabla').html("Mensaje antes de Enviar");
},

success: function(mensaje)
{
$('#mostrar_tabla').html(mensaje);

}
});
}
//editar Stock
$(function(){
  //Mensaje
    var message_status = $("#tbl_producto");
    $("td[contenteditable=true]").blur(function(){
        var rownumber = $(this).attr("id");
        var value = $(this).text();
        $.post('proceso.php' , rownumber + "=" + value, function(data){
            if(data != '')
      {
        message_status.show();
        message_status.html(data);
        //hide the message
        //setTimeout(function(){message_status.html("REGISTRO ACTUALIZADO CORRECTAMENTE");},2000);
        window.location.href = "lista_productos.php";
      } else {
        //message_status().html = data;
      }




        });
    });
});
//Guardar Producto
function guardarProducto()
  {
    
    image = $('#imagen');
    image_data = image.prop('files')[0];
    formData = new FormData();
    formData.append('imagen', image_data);

    codigo = $("#codigo").val();
    nombre_producto = $("#nombre_producto").val();
    precio = $("#precio").val();
    stock = $("#stock").val();
    unidad = $("#unidad").val();
    precio_mayor = $("#precio_mayor").val();
    locales = $("#locales").val();
    mi_precio = $("#mi_precio").val();
    porcentaje_menor = $("#porcentaje_menor").val();
    porcentaje_mayor = $("#porcentaje_mayor").val();
    proveedor = $("#proveedor").val();
    idrubro2 = $("#idrubro2").val();
    idmarca = $("#idmarca").val();
    

    var parametros = 
    {
      "guardar_producto": "1",
      "codigo" : codigo,
      "nombre_producto" : nombre_producto,
      "precio" : precio,
      "stock" : stock,
      "unidad" : unidad,
      "precio_mayor" : precio_mayor,
      "locales" : locales,
      "mi_precio" : mi_precio,
      "porcentaje_menor" : porcentaje_menor,
      "porcentaje_mayor" : porcentaje_mayor,
      "proveedor" : proveedor,
      "idrubro2" : idrubro2,
      "idmarca" : idmarca
    
    };
    $.ajax(
    {
      data:  parametros, formData, 
      url:   'datos_producto.php',
      type:  'post',
     
      error: function()
      {alert("Error");},
      
      success:  function (mensaje) 
      {
        $('#mostrar_mensaje').html(mensaje); 
        limpiarproductos();
        
      }
      
    }) 
    
  }
 
function calcular_menor()
{

var miprecio = parseFloat($('#mi_precio').val());
var porcen_menor = parseFloat($('#porcentaje_menor').val());
var porcentaje = miprecio * porcen_menor / 100;
var total = miprecio + porcentaje;
$.ajax({

beforesend: function()
{
alert("Error");
},

success: function()
{

$("#precio").val(total);
}
});



}

function calcular_mayor()
{

var miprecio = parseFloat($('#mi_precio').val());
var porcen_mayor = parseFloat($('#porcentaje_mayor').val());
var porcentaje = miprecio * porcen_mayor / 100;
var total = miprecio + porcentaje;
$.ajax({

beforesend: function()
{
alert("Error");
},

success: function()
{

$("#precio_mayor").val(total);
}
});

}

//Nuevo cliente
function agregar_cliente()
  {
    
    nombre = $("#nombre2").val();
    //apellido = $("#apellido2").val();
    direccion = $("#direccion2").val();
    celular = $("#celular2").val();

    var parametros = 
    {
      "nuevo_cliente": "1",
      "nombre" : nombre,
      //"apellido" : apellido,
      "direccion" : direccion,
      "celular" : celular
      
      
    };
    $.ajax(
    {
      data:  parametros,
      url:   'datos_cliente.php',
      type:  'post',
     
      error: function()
      {alert("Error");},
      
      success:  function (mensaje) 
      {
        $('#mostrar_mensaje').html(mensaje); 
        limpiarCliente();
        
      }
      
    }) 
    
  }

  
