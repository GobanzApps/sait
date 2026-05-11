// Archivo: vistas/js/ticketevidencia.js

/* Eliminar evidencia */
$(".tablas").on("click", ".btnEliminarTicketevidencia", function(){

  var idTicketevidencia = $(this).attr("idTicketevidencia");
  var idTicket = $(this).attr("idTicket");

  swal({
    title: '¿Está seguro de eliminar esta imagen?',
    text: "¡No podrá recuperarla después!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí, eliminar!'
  }).then(function(result) {
    if (result.value) {
      window.location = "index.php?ruta=ticket&id=" + idTicket + "&idTicketevidencia=" + idTicketevidencia;
    }
  });
});

// Previsualización de imagen al seleccionar (para cuando se usa en modales)
$(document).ready(function() {
    $('#modalAgregarTicketevidencia').on('shown.bs.modal', function() {
        $('#nuevoTicketevidencia').on('change', function(e) {
            var file = e.target.files[0];
            if(file){
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previsualizacionImagen').attr('src', e.target.result).show();
                    $('#infoArchivo').html('<strong>Archivo:</strong> ' + file.name + '<br><strong>Tamaño:</strong> ' + (file.size / 1024).toFixed(2) + ' KB');
                }
                reader.readAsDataURL(file);
            } else {
                $('#previsualizacionImagen').hide().attr('src', '');
                $('#infoArchivo').html('');
            }
        });
    });
    
    $('#modalAgregarTicketevidencia').on('hidden.bs.modal', function() {
        $('#previsualizacionImagen').hide().attr('src', '');
        $('#infoArchivo').html('');
        $('#nuevoTicketevidencia').val('');
    });
});