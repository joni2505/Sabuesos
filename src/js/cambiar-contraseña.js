function btnCambiar(e) {
    e.preventDefault();
    const actual = document.getElementById('actual').value;
    const nueva = document.getElementById('nueva').value;
    if (actual == "" || nueva == "") {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Los campos estan vacios',
            showConfirmButton: false,
            timer: 2000
        })
    } else {
        const cambio = 'pass';
         $.ajax({
             url: "ajax.php",
             type: 'POST',
             data: {
                 actual: actual,
                 nueva: nueva,
                 cambio: cambio
             },
             success: function (response) {
                 console.log(response);
                 if (response == 'ok') {
                     Swal.fire({
                         position: 'top-end',
                         icon: 'success',
                         title: 'Contraseña modificado',
                         showConfirmButton: false,
                         timer: 2000
                     })
                     document.querySelector('frmPass').reset();
                     $("#nuevo_pass").modal("hide");
                 } else if (response == 'dif') {
                     Swal.fire({
                         position: 'top-end',
                         icon: 'error',
                         title: 'La contraseña actual incorrecta',
                         showConfirmButton: false,
                         timer: 2000
                     })
                 } else {
                     Swal.fire({
                         position: 'top-end',
                         icon: 'error',
                         title: 'Error al modificar la contraseña',
                         showConfirmButton: false,
                         timer: 2000
                     })
                 }
             }
         });
    }
}

function btnCambiar2(e) {
    e.preventDefault();
    const actual = document.getElementById('actual2').value;
    const nueva = document.getElementById('nueva2').value;
    if (actual == "" || nueva == "") {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Los campos estan vacios',
            showConfirmButton: false,
            timer: 2000
        })
    } else {
        const cambio = 'pass';
         $.ajax({
             url: "ajax.php",
             type: 'POST',
             data: {
                 actual: actual,
                 nueva: nueva,
                 cambio: cambio
             },
             success: function (response) {
                 console.log(response);
                 if (response == 'ok') {
                     Swal.fire({
                         position: 'top-end',
                         icon: 'success',
                         title: 'Contraseña modificado',
                         showConfirmButton: false,
                         timer: 2000
                     })
                     document.querySelector('frmPass').reset();
                     $("#nuevo_pass").modal("hide");
                 } else if (response == 'dif') {
                     Swal.fire({
                         position: 'top-end',
                         icon: 'error',
                         title: 'La contraseña actual incorrecta',
                         showConfirmButton: false,
                         timer: 2000
                     })
                 } else {
                     Swal.fire({
                         position: 'top-end',
                         icon: 'error',
                         title: 'Error al modificar la contraseña',
                         showConfirmButton: false,
                         timer: 2000
                     })
                 }
             }
         });
    }
}