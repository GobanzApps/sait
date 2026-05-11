/* Editar */

$(".tablas").on("click", ".btnEditarTicket", function(){

	var idTicket = $(this).attr("idTicket");
	
	var datos = new FormData();
	datos.append("idTicket", idTicket);

	$.ajax({

		url:"ajax/ticket.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			console.log("Respuesta del servidor:", respuesta);
			
			// Asignar valores a los campos de texto
			$("#editarTicket").val(respuesta["ticket"]);
			$("#editarSolicitante").val(respuesta["solicitante"]);
			$("#editarDescripcion").val(respuesta["descripcion"]);
			$("#idTicket").val(respuesta["id"]);
			
			// Para los selects con Select2, usar el método específico
			// Ente
			$("#editarEnte").val(respuesta["id_ente"]).trigger('change.select2');
			
			// Medio
			$("#editarMedio").val(respuesta["id_medio"]).trigger('change.select2');
			
			// Prioridad
			$("#editarPrioridad").val(respuesta["id_prioridad"]).trigger('change.select2');
			
			// Status
			$("#editarStatus").val(respuesta["id_status"]).trigger('change.select2');

			// Finalizado
			$("#editarFinalizado").val(respuesta["finalizado"]).trigger('change.select2');
		}

	});

})

/* Activar Ticket */

$(".tablas").on("click", ".btnActivar", function(){

    var idTicket = $(this).attr("idTicket");
    var estadoActual = $(this).attr("estadoTicket");
    
    // Determinar el nuevo estado (invertir el actual)
    var nuevoEstado = (estadoActual == 0) ? 1 : 0;

    var datos = new FormData();
    datos.append("activarId", idTicket);
    datos.append("activarTicket", nuevoEstado);  // Enviar el nuevo estado

    $.ajax({
        url: "ajax/ticket.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            if(respuesta.status == "ok"){
                // Actualizar la UI
                if(nuevoEstado == 1){
                    $(this).removeClass('btn-danger');
                    $(this).addClass('btn-success');
                    $(this).html('Activado');
                    $(this).attr('estadoTicket', 1);
                } else {
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-danger');
                    $(this).html('Desactivado');
                    $(this).attr('estadoTicket', 0);
                }
                
                if(window.matchMedia("(max-width:767px)").matches){
                    swal({
                        title: "Ya sido actualizado",
                        type: "success",
                        confirmButtonText: "¡Cerrar!"
                    });
                }
            }
        }.bind(this)  // Importante: bind(this) para mantener el contexto
    });
});

/* Finalizar Ticket */

$(".tablas").on("click", ".btnFinalizar", function(){

    var idTicket = $(this).attr("idTicket");
    var finalizadoActual = $(this).attr("finalizadoTicket");
    
    // Determinar el nuevo estado (invertir el actual)
    var nuevoFinalizado = (finalizadoActual == 'si') ? 'no' : 'si';

    var datos = new FormData();
    datos.append("finalizarId", idTicket);
    datos.append("finalizarTicket", nuevoFinalizado);

    $.ajax({
        url: "ajax/ticket.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            if(respuesta.status == "ok"){
                // Actualizar la UI
                if(nuevoFinalizado == 'si'){
                    $(this).removeClass('btn-warning');
                    $(this).addClass('btn-success');
                    $(this).html('Finalizado');
                    $(this).attr('finalizadoTicket', 'si');
                } else {
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-warning');
                    $(this).html('No Finalizado');
                    $(this).attr('finalizadoTicket', 'no');
                }
                
                if(window.matchMedia("(max-width:767px)").matches){
                    swal({
                        title: "Estado de finalización actualizado",
                        type: "success",
                        confirmButtonText: "¡Cerrar!"
                    });
                }
            }
        }.bind(this)
    });
});

/* Revisar si ticket ya esta registrado */

$("#nuevoTicket").change(function(){

	$(".alert").remove();

	var usuario = $(this).val();

	var datos = new FormData();
	datos.append("validarTicket", usuario);

	 $.ajax({
	    url:"ajax/ticket.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoTicket").parent().after('<div class="alert alert-warning">Ya existe en la base de datos</div>');

	    		$("#nuevoTicket").val("");

	    	}

	    }

	})
})

/* Eliminar */
$(".tablas").on("click", ".btnEliminarTicket", function(){

  var idTicket = $(this).attr("idTicket");
  var ticket = $(this).attr("ticket");

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
      // Redirigir con el ID para eliminar
      window.location = "index.php?ruta=tickets&idTicket=" + idTicket;
	  
    }
  });
})

// AGREGAR TICKET

$(document).ready(function() {
  
  // Inicializar Select2 para ENTE con tema Bootstrap
  $('.select2-ente').select2({
    theme: 'bootstrap',
    placeholder: 'Seleccione un ente',
    language: 'es',
    dropdownParent: $('#modalAgregarTicket')
  });
  
  // Inicializar Select2 para MEDIO
  $('.select2-medio').select2({
    theme: 'bootstrap',
    placeholder: 'Seleccione un medio',
    language: 'es',
    dropdownParent: $('#modalAgregarTicket')
  });
  
  // Inicializar Select2 para PRIORIDAD
  $('.select2-prioridad').select2({
    theme: 'bootstrap',
    placeholder: 'Seleccione una prioridad',
    language: 'es',
    templateResult: formatPrioridad,
    templateSelection: formatPrioridadSelection,
    dropdownParent: $('#modalAgregarTicket')
  });
  
  // Función para formatear las opciones de prioridad con color
  function formatPrioridad(option) {
    if (!option.id) {
      return option.text;
    }
    var color = $(option.element).data('color');
    if (color) {
      var $option = $(
        '<span style="display:inline-block; width:12px; height:12px; border-radius:50%; background-color:' + color + '; margin-right:8px;"></span>' +
        '<span>' + option.text + '</span>'
      );
      return $option;
    }
    return option.text;
  }
  
  function formatPrioridadSelection(option) {
    if (!option.id) {
      return option.text;
    }
    var color = $(option.element).data('color');
    if (color) {
      var $selection = $(
        '<span><i class="fa fa-flag" style="color:' + color + '; margin-right:8px;"></i>' + option.text + '</span>'
      );
      return $selection;
    }
    return option.text;
  }
  
  // Al abrir el modal, refrescar los select2 para que se posicionen bien
  $('#modalAgregarTicket').on('shown.bs.modal', function() {
    $('.select2-ente').select2('open').select2('close');
    $('.select2-medio').select2('open').select2('close');
    $('.select2-prioridad').select2('open').select2('close');
  });
  
  // Manejar el envío del formulario
  $('#formTicket').on('submit', function(e) {
    e.preventDefault();
    
    // Validar campos requeridos
    var ente = $('#ente').val();
    var solicitante = $('#solicitante').val();
    var descripcion = $('#descripcion').val();
    var medio = $('#medio').val();
    var prioridad = $('#prioridad').val();
    
    if (!ente || !solicitante || !descripcion || !medio || !prioridad) {
      // Mostrar alerta de error (SweetAlert opcional)
      alert('Por favor complete todos los campos requeridos.');
      return false;
    }
    
    // Aquí iría la lógica para guardar con AJAX
    console.log('Datos del ticket:', {
      ente: $('#ente option:selected').text(),
      solicitante: solicitante,
      descripcion: descripcion,
      medio: $('#medio option:selected').text(),
      prioridad: $('#prioridad option:selected').text(),
      fecha: $('#fecha').val()
    });
    
    // Mostrar mensaje de éxito
    alert('Ticket guardado exitosamente!');
    
    // Cerrar modal y resetear formulario
    $('#modalAgregarTicket').modal('hide');
    $('#formTicket')[0].reset();
    $('.select2-ente, .select2-medio, .select2-prioridad').val('').trigger('change');
  });
  
  // Limpiar el formulario cuando se cierra el modal
  $('#modalAgregarTicket').on('hidden.bs.modal', function() {
    $('#formTicket')[0].reset();
    $('.select2-ente, .select2-medio, .select2-prioridad').val('').trigger('change');
  });
  
});





/*=============================================
COMPARTIR POR WHATSAPP - VERSIÓN MEJORADA
=============================================*/

$(document).on("click", "#btnCompartirWhatsApp", function(e) {
    e.preventDefault();
    
    var $btn = $(this);
    
    // Obtener los datos del ticket
    var idTicket = $btn.data("id");
    var solicitante = $btn.data("solicitante");
    var ente = $btn.data("ente");
    var descripcion = $btn.data("descripcion");
    var prioridad = $btn.data("prioridad");
    var creador = $btn.data("creador");
    var fechaCreacion = $btn.data("fecha-creacion");
    var modificacion = $btn.data("modificacion");
    
    // Obtener la URL del ticket
    var ticketUrl = window.location.href;
    
    // Construir el mensaje con emojis y formato (usando \n para saltos de línea)
    var mensaje = "📋 *RESUMEN DEL TICKET*\n";
    mensaje += "━━━━━━━━━━━\n\n";
    mensaje += "🆔 *Número:* #" + idTicket + "\n";
    mensaje += "👤 *Solicitante:* " + solicitante + "\n";
    mensaje += "🏢 *Dependencia:* " + ente + "\n";
    mensaje += "📝 *Descripción:* " + descripcion + "\n\n";
    mensaje += "⚡ *Prioridad:* " + prioridad + "\n";
    mensaje += "👨‍💻 *Creado por:* " + creador + "\n";
    mensaje += "📅 *Fecha creación:* " + fechaCreacion + "\n";
    mensaje += "🕒 *Última modificación:* " + modificacion + "\n\n";
    mensaje += "━━━━━━━━━━━\n";
    mensaje += "🔗 *Enlace al ticket:* " + ticketUrl;
    
    // Detectar si es dispositivo móvil
    var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    // Codificar el mensaje para URL
    var mensajeCodificado = encodeURIComponent(mensaje);
    
    // Construir URL según el dispositivo
    var whatsappUrl = isMobile 
        ? "https://api.whatsapp.com/send?text=" + mensajeCodificado
        : "https://web.whatsapp.com/send?text=" + mensajeCodificado;
    
    // Abrir WhatsApp
    window.open(whatsappUrl, "_blank");
});