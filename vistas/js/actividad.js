// Archivo: vistas/js/actividad.js

$(document).ready(function() {
    // Inicializar Select2 para AGREGAR
    function inicializarSelect2Agregar() {
        // Select2 para Usuarios en modal AGREGAR
        $('.select2-usuarios-agregar').select2({
            theme: 'bootstrap',
            placeholder: 'Seleccione uno o más usuarios',
            language: 'es',
            dropdownParent: $('#modalAgregarActividad'),
            width: '100%',
            allowClear: true,
            closeOnSelect: false
        });
        
        // Select2 para Servicios en modal AGREGAR
        $('.select2-servicios-agregar').select2({
            theme: 'bootstrap',
            placeholder: 'Seleccione uno o más servicios',
            language: 'es',
            dropdownParent: $('#modalAgregarActividad'),
            width: '100%',
            allowClear: true,
            closeOnSelect: false
        });
        
        // Select2 para Entes en modal AGREGAR
        $('.select2-entes-agregar').select2({
            theme: 'bootstrap',
            placeholder: 'Seleccione uno o más entes',
            language: 'es',
            dropdownParent: $('#modalAgregarActividad'),
            width: '100%',
            allowClear: true,
            closeOnSelect: false
        });
    }
    
    // Inicializar Select2 para EDITAR
    function inicializarSelect2Editar() {
        // Select2 para Usuarios en modal EDITAR
        $('.select2-usuarios-editar').select2({
            theme: 'bootstrap',
            placeholder: 'Seleccione uno o más usuarios',
            language: 'es',
            dropdownParent: $('#modalEditarActividad'),
            width: '100%',
            allowClear: true,
            closeOnSelect: false
        });
        
        // Select2 para Servicios en modal EDITAR
        $('.select2-servicios-editar').select2({
            theme: 'bootstrap',
            placeholder: 'Seleccione uno o más servicios',
            language: 'es',
            dropdownParent: $('#modalEditarActividad'),
            width: '100%',
            allowClear: true,
            closeOnSelect: false
        });
        
        // Select2 para Entes en modal EDITAR
        $('.select2-entes-editar').select2({
            theme: 'bootstrap',
            placeholder: 'Seleccione uno o más entes',
            language: 'es',
            dropdownParent: $('#modalEditarActividad'),
            width: '100%',
            allowClear: true,
            closeOnSelect: false
        });
    }
    
    // Ejecutar inicializaciones
    inicializarSelect2Agregar();
    inicializarSelect2Editar();

    // Al abrir modal AGREGAR, refrescar Select2
    $('#modalAgregarActividad').on('shown.bs.modal', function() {
        $('.select2-usuarios-agregar, .select2-servicios-agregar, .select2-entes-agregar').each(function() {
            $(this).select2('open').select2('close');
        });
    });
    
    // Al abrir modal EDITAR, refrescar Select2
    $('#modalEditarActividad').on('shown.bs.modal', function() {
        $('.select2-usuarios-editar, .select2-servicios-editar, .select2-entes-editar').each(function() {
            $(this).select2('open').select2('close');
        });
    });
    
    // Limpiar formulario AGREGAR al cerrar
    $('#modalAgregarActividad').on('hidden.bs.modal', function() {
        $('#formAgregarActividad')[0].reset();
        $('.select2-usuarios-agregar, .select2-servicios-agregar, .select2-entes-agregar').val(null).trigger('change');
    });
    
    // Limpiar formulario EDITAR al cerrar
    $('#modalEditarActividad').on('hidden.bs.modal', function() {
        $('#formEditarActividad')[0].reset();
        $('.select2-usuarios-editar, .select2-servicios-editar, .select2-entes-editar').val(null).trigger('change');
    });
});

/* =============================================
   EDITAR - Cargar datos en el modal
============================================= */
$(".tablas").on("click", ".btnEditarActividad", function(){
    var idActividad = $(this).attr("idActividad");
    var datos = new FormData();
    datos.append("idActividad", idActividad);

    $.ajax({
        url: "ajax/actividad.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            console.log("Respuesta del servidor:", respuesta);
            
            // Asignar valores a los campos
            $("#editarActividad").val(respuesta["actividad"]);
            $("#editarDescripcion").val(respuesta["descripcion"]);
            $("#idActividad").val(respuesta["id"]);
            
            // IMPORTANTE: Destruir y recrear Select2 para evitar problemas de duplicación
            // Primero destruimos los Select2 existentes en el modal de edición
            $('#modalEditarActividad .select2-usuarios-editar').select2('destroy');
            $('#modalEditarActividad .select2-servicios-editar').select2('destroy');
            $('#modalEditarActividad .select2-entes-editar').select2('destroy');
            
            // Asignar los valores decodificados
            $('#modalEditarActividad .select2-usuarios-editar').val(respuesta["id_usuario"]);
            $('#modalEditarActividad .select2-servicios-editar').val(respuesta["id_servicios"]);
            $('#modalEditarActividad .select2-entes-editar').val(respuesta["id_ente"]);
            
            // Recrear Select2 con los nuevos valores
            $('#modalEditarActividad .select2-usuarios-editar').select2({
                theme: 'bootstrap',
                placeholder: 'Seleccione uno o más usuarios',
                language: 'es',
                dropdownParent: $('#modalEditarActividad'),
                width: '100%',
                allowClear: true,
                closeOnSelect: false
            });
            
            $('#modalEditarActividad .select2-servicios-editar').select2({
                theme: 'bootstrap',
                placeholder: 'Seleccione uno o más servicios',
                language: 'es',
                dropdownParent: $('#modalEditarActividad'),
                width: '100%',
                allowClear: true,
                closeOnSelect: false
            });
            
            $('#modalEditarActividad .select2-entes-editar').select2({
                theme: 'bootstrap',
                placeholder: 'Seleccione uno o más entes',
                language: 'es',
                dropdownParent: $('#modalEditarActividad'),
                width: '100%',
                allowClear: true,
                closeOnSelect: false
            });
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar la actividad:", error);
            console.log("Respuesta del servidor:", xhr.responseText);
        }
    });
});

/* =============================================
   ACTIVAR / DESACTIVAR Actividad
============================================= */
$(".tablas").on("click", ".btnActivar", function(){
    var idActividad = $(this).attr("idActividad");
    var estadoActual = $(this).attr("estadoActividad");
    var nuevoEstado = (estadoActual == 0) ? 1 : 0;
    var $btn = $(this);

    var datos = new FormData();
    datos.append("activarId", idActividad);
    datos.append("activarActividad", nuevoEstado);

    $.ajax({
        url: "ajax/actividad.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            if(respuesta.status == "ok"){
                if(nuevoEstado == 1){
                    $btn.removeClass('btn-danger').addClass('btn-success');
                    $btn.html('Activado');
                    $btn.attr('estadoActividad', 1);
                } else {
                    $btn.removeClass('btn-success').addClass('btn-danger');
                    $btn.html('Desactivado');
                    $btn.attr('estadoActividad', 0);
                }
                
                if(window.matchMedia("(max-width:767px)").matches){
                    swal({
                        title: "Estado actualizado",
                        text: "El estado de la actividad ha cambiado",
                        type: "success",
                        confirmButtonText: "¡Cerrar!"
                    });
                }
            } else {
                swal({
                    title: "Error",
                    text: "No se pudo cambiar el estado",
                    type: "error",
                    confirmButtonText: "Cerrar"
                });
            }
        }.bind(this)
    });
});

/* =============================================
   VALIDAR si la actividad ya existe
============================================= */
$("#nuevoActividad").change(function(){
    $(".alert").remove();
    var actividad = $(this).val();

    var datos = new FormData();
    datos.append("validarActividad", actividad);

    $.ajax({
        url: "ajax/actividad.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            if(respuesta){
                $("#nuevoActividad").parent().after('<div class="alert alert-warning">¡Esta actividad ya existe en la base de datos!</div>');
                $("#nuevoActividad").val("");
            }
        }
    });
});

/* =============================================
   ELIMINAR Actividad
============================================= */
$(".tablas").on("click", ".btnEliminarActividad", function(){
    var idActividad = $(this).attr("idActividad");
    var actividad = $(this).attr("actividad");

    swal({
        title: '¿Está seguro de borrar?',
        text: "¡La actividad '" + actividad + "' será eliminada permanentemente!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, borrar!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=actividad&idActividad=" + idActividad;
        }
    });
});

/*=============================================
COMPARTIR POR WHATSAPP - INFORME DE ACTIVIDAD
=============================================*/
$(document).on("click", ".btnCompartirWhatsApp", function(e) {
    e.preventDefault();
    
    var $btn = $(this);
    
    // Obtener los datos de la actividad desde los atributos data-
    var idActividad = $btn.data("id");
    var actividad = $btn.data("actividad");
    var descripcion = $btn.data("descripcion");
    var fecha = $btn.data("fecha");
    var coordinacion = $btn.data("coordinacion");
    var usuarios = $btn.data("usuarios");
    var servicios = $btn.data("servicios");
    var entes = $btn.data("entes");
    var creador = $btn.data("creador");
    var usuarioCreador = $btn.data("usuario-creador");
    
    // Obtener la URL de la actividad (opcional)
    var actividadUrl = window.location.href;
    
    // Formatear la fecha (si es necesario)
    var fechaFormateada = fecha;
    if(fecha && fecha.includes(' ')){
        var fechaParts = fecha.split(' ');
        fechaFormateada = fechaParts[0] + ' a las ' + fechaParts[1];
    }
    
    // Construir el mensaje con emojis y formato
    var mensaje = "📋 *INFORME DE ACTIVIDAD*\n";
    mensaje += "━━━━━━━━━━━━\n\n";
    mensaje += "🆔 *ID:* #" + idActividad + "\n";
    mensaje += "📌 *Actividad:* " + actividad + "\n";
    mensaje += "🏢 *Coordinación:* " + coordinacion + "\n\n";
    mensaje += "🏛️ *Dependencias:*\n" + entes + "\n\n";
    mensaje += "👥 *Especialistas Asignados:*\n" + usuarios + "\n\n";
    mensaje += "🔧 *Servicios Relacionados:*\n" + servicios + "\n\n";
    mensaje += "📝 *Descripción:*\n" + descripcion + "\n\n";
    mensaje += "📅 *Fecha de Creación:* " + fechaFormateada + "\n";
    mensaje += "👨‍💻 *Creado por:* " + creador + " (" + usuarioCreador + ")\n";
    mensaje += "━━━━━━━━━━━━\n\n";
    mensaje += "🔗 *Enlace:* " + actividadUrl;
    
    // Detectar si es dispositivo móvil
    var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    // Codificar el mensaje para URL
    var mensajeCodificado = encodeURIComponent(mensaje);
    
    // Construir URL según el dispositivo
    var whatsappUrl = isMobile 
        ? "https://api.whatsapp.com/send?text=" + mensajeCodificado
        : "https://web.whatsapp.com/send?text=" + mensajeCodificado;
    
    // Abrir WhatsApp en una nueva pestaña
    window.open(whatsappUrl, "_blank");
});