// Archivo: vistas/js/documento.js

$(document).ready(function() {
    // Inicializar Select2 para los selects
    $('.select2').select2({
        language: "es",
        theme: "bootstrap"
    });
    
    // Validar archivo PDF antes de enviar el formulario de agregar
    $('form[role="form"]').on('submit', function(e) {
        var fileInput = $(this).find('input[type="file"]');
        
        if(fileInput.length && fileInput[0].files[0]) {
            var file = fileInput[0].files[0];
            var fileType = file.type;
            var fileName = file.name;
            var extension = fileName.split('.').pop().toLowerCase();
            
            // Validar que sea PDF
            if(fileType !== 'application/pdf' && extension !== 'pdf') {
                e.preventDefault();
                swal({
                    type: "error",
                    title: "¡Solo se permiten archivos PDF!",
                    text: "Por favor seleccione un archivo PDF válido.",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                });
                return false;
            }
            
            // Validar tamaño máximo (10MB)
            if(file.size > 10485760) {
                e.preventDefault();
                swal({
                    type: "error",
                    title: "¡El archivo no debe superar los 10MB!",
                    text: "Por favor seleccione un archivo más pequeño.",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                });
                return false;
            }
        }
    });
});

/* Editar Documento */
$(".tablas").on("click", ".btnEditarDocumento", function(){

    var idDocumento = $(this).attr("idDocumento");

    $.ajax({
        url: "ajax/documento.ajax.php",
        method: "POST",
        data: { idDocumento: idDocumento },
        dataType: "json",
        success: function(respuesta){
            
            $("#editarDocumento").val(respuesta["documento"]);
            
            // Para Select2, necesitas disparar el cambio después de asignar el valor
            $("#editarIdTipodocs").val(respuesta["id_tipodocs"]).trigger('change');
            
            $("#editarFecha").val(respuesta["fecha"]);
            $("#editarEmision").val(respuesta["emision"]);
            $("#editarRemitente").val(respuesta["remitente"]);
            $("#editarDestinatario").val(respuesta["destinatario"]);
            $("#editarAsunto").val(respuesta["asunto"]);
            $("#editarIdTicket").val(respuesta["id_ticket"]).trigger('change');
            $("#idDocumento").val(respuesta["id"]);
            
            // Mostrar adjunto actual si existe
            if(respuesta["adjunto"] && respuesta["adjunto"] != ""){
                $("#adjuntoActual").html('<a href="'+respuesta["adjunto"]+'" target="_blank" class="btn btn-xs btn-info">Ver adjunto actual</a>');
            } else {
                $("#adjuntoActual").html('<span class="text-muted">Sin adjunto</span>');
            }
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar el documento:", error);
            console.log("Respuesta del servidor:", xhr.responseText);
        }
    });
});

/* Activar/Desactivar Documento */
$(".tablas").on("click", ".btnActivar", function(){

    var idDocumento = $(this).attr("idDocumento");
    var estadoActual = $(this).attr("estadoDocumento");
    var nuevoEstado = (estadoActual == 0) ? 1 : 0;

    var datos = new FormData();
    datos.append("activarId", idDocumento);
    datos.append("activarDocumento", nuevoEstado);

    $.ajax({
        url: "ajax/documento.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            if(respuesta.status == "ok"){
                location.reload();
            }
        }
    });
});

/* Validar si documento ya está registrado */
$("#nuevoDocumento").change(function(){

    $(".alert").remove();
    var documento = $(this).val();

    var datos = new FormData();
    datos.append("validarDocumento", documento);

    $.ajax({
        url: "ajax/documento.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            if(respuesta){
                $("#nuevoDocumento").parent().after('<div class="alert alert-warning">Ya existe en la base de datos</div>');
                $("#nuevoDocumento").val("");
            }
        }
    });
});

/* Eliminar Documento */
$(".tablas").on("click", ".btnEliminarDocumento", function(){

    var idDocumento = $(this).attr("idDocumento");
    var documento = $(this).attr("documento");

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
            window.location = "index.php?ruta=documento&idDocumento=" + idDocumento;
        }
    });
});