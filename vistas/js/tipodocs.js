// Archivo: vistas/js/tipodocs.js

/* Editar */
$(".tablas").on("click", ".btnEditarTipodoc", function(){

    var idTipodoc = $(this).attr("idTipodoc");
    
    var datos = new FormData();
    datos.append("idTipodoc", idTipodoc);

    $.ajax({
        url:"ajax/tipodocs.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            $("#editarTipodoc").val(respuesta["tipodocs"]);
            $("#idTipodoc").val(respuesta["id"]);
        }
    });
});

/* Activar Tipodoc */
$(".tablas").on("click", ".btnActivar", function(){

    var idTipodoc = $(this).attr("idTipodoc");
    var estadoActual = $(this).attr("estadoTipodoc");
    
    // Determinar el nuevo estado (invertir el actual)
    var nuevoEstado = (estadoActual == 0) ? 1 : 0;

    var datos = new FormData();
    datos.append("activarId", idTipodoc);
    datos.append("activarTipodoc", nuevoEstado);

    var boton = $(this); // Guardar referencia al botón

    $.ajax({
        url: "ajax/tipodocs.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            if(respuesta.status == "ok"){
                if(nuevoEstado == 1){
                    boton.removeClass('btn-danger');
                    boton.addClass('btn-success');
                    boton.html('Activado');
                    boton.attr('estadoTipodoc', 1);
                } else {
                    boton.removeClass('btn-success');
                    boton.addClass('btn-danger');
                    boton.html('Desactivado');
                    boton.attr('estadoTipodoc', 0);
                }
                
                if(window.matchMedia("(max-width:767px)").matches){
                    swal({
                        title: "Ya sido actualizado",
                        type: "success",
                        confirmButtonText: "¡Cerrar!"
                    });
                }
            }
        }
    });
});

/* Revisar si tipo de documento ya está registrado */
$("#nuevoTipodoc").change(function(){

    $(".alert").remove();

    var tipodoc = $(this).val();

    var datos = new FormData();
    datos.append("validarTipodoc", tipodoc);

    $.ajax({
        url:"ajax/tipodocs.ajax.php",
        method:"POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(respuesta){
            if(respuesta){
                $("#nuevoTipodoc").parent().after('<div class="alert alert-warning">Ya existe en la base de datos</div>');
                $("#nuevoTipodoc").val("");
            }
        }
    });
});

/* Eliminar */
$(".tablas").on("click", ".btnEliminarTipodoc", function(){

    var idTipodoc = $(this).attr("idTipodoc");
    var tipodoc = $(this).attr("tipodoc");

    swal({
        title: '¿Está seguro de borrar?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=tipodocs&idTipodoc=" + idTipodoc;
        }
    });
});