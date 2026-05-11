<script>
$(document).ready(function() {
    // Previsualización de imagen antes de subir
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
    
    // Resetear previsualización al cerrar modal
    $('#modalAgregarTicketevidencia').on('hidden.bs.modal', function() {
        $('#previsualizacionImagen').hide().attr('src', '');
        $('#infoArchivo').html('');
        $('#nuevoTicketevidencia').val('');
    });
});
</script>

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Evidencias Fotográficas  
    <?php 
    if($ticketInfo["finalizado"] != "si") {
        $cantidadEvidencias = ControladorTicketevidencia::ctrContarEvidenciasPorTicket($ticketInfo["id"]);
        if($cantidadEvidencias < 2){
            echo '<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalAgregarTicketevidencia">
                  <i class="fa fa-camera"></i> Añadir Imagen</button>';
        } else {
            echo '<button type="button" class="btn btn-xs btn-warning" disabled>
                  <i class="fa fa-exclamation-triangle"></i> Límite alcanzado (2/2)</button>';
        }
    }
    ?>
    </h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>

  <div class="box-body">
    <div class="row">
        <?php
        $evidencias = ControladorTicketevidencia::ctrMostrarTicketevidencia("id_ticket", $ticketInfo["id"]);
        
        if(empty($evidencias)){
            echo '<div class="col-md-12">
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle"></i> No hay evidencias asociadas a este ticket.
                    </div>
                  </div>';
        } else {
            foreach ($evidencias as $key => $value){
                echo '
                <div class="col-md-3 col-sm-4 col-xs-6" style="margin-bottom: 15px;">
                    <div class="thumbnail text-center" style="padding: 10px;">
                        <a href="'.$value["ticketevidencia"].'" target="_blank">
                            <img src="'.$value["ticketevidencia"].'" alt="Evidencia" style="width: 100%; height: 150px; object-fit: cover; border-radius: 5px;">
                        </a>
                        <div class="caption">
                            <p><small><i class="fa fa-clock-o"></i> '.$value["fecha_subida"].'</small></p>';
                            
                if($ticketInfo["finalizado"] != "si"){
                    echo '<button class="btn btn-xs btn-danger btnEliminarTicketevidencia" 
                                idTicketevidencia="'.$value["id"].'" 
                                idTicket="'.$value["id_ticket"].'">
                                <i class="fa fa-trash"></i> Eliminar
                            </button>';
                } else {
                    echo '<span class="label label-default">Finalizado</span>';
                }
                
                echo '    <a href="'.$value["ticketevidencia"].'" target="_blank" class="btn btn-xs btn-info">
                                <i class="fa fa-eye"></i> Ver
                            </a>
                        </div>
                    </div>
                </div>';
            }
        }
        ?>
    </div>
  </div>
</div>

<!--- Modal de crear evidencia --->
<div id="modalAgregarTicketevidencia" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h5 class="modal-title"><i class="fa fa-camera"></i> Agregar Evidencia (Imagen)</h5>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <input type="hidden" name="nuevoId_ticket" value="<?php echo $ticketInfo["id"];?>" required>
            
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> <strong>Requisitos:</strong>
                <ul style="margin-bottom: 0; margin-top: 5px;">
                    <li>Formatos permitidos: JPG, JPEG, PNG, GIF, WEBP, BMP</li>
                    <li>Tamaño máximo: <strong>2 MB</strong> por archivo</li>
                    <li>Máximo de <strong>2 imágenes</strong> por ticket</li>
                </ul>
            </div>
            
            <div class="form-group">
                <label><i class="fa fa-image"></i> Seleccionar Imagen</label>
                <input type="file" class="form-control" name="nuevoTicketevidencia" id="nuevoTicketevidencia" accept="image/jpeg,image/png,image/gif,image/webp,image/bmp" required>
                <p class="help-block">Seleccione una imagen (máx. 2MB)</p>
            </div>
            
            <div id="infoArchivo" class="text-muted" style="margin-top: 5px;"></div>
            
            <div class="text-center" style="margin-top: 10px;">
                <img id="previsualizacionImagen" src="" style="max-width: 100%; max-height: 200px; display: none; border-radius: 5px; border: 1px solid #ddd; padding: 5px;">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Subir Imagen</button>
        </div>
        <?php
          $crearTicketevidencia = new ControladorTicketevidencia();
          $crearTicketevidencia -> ctrCrearTicketevidencia();
        ?>
      </form>
    </div>
  </div>
</div>

<script>
// Eliminar evidencia
$('.btnEliminarTicketevidencia').on('click', function() {
    var idTicketevidencia = $(this).attr('idTicketevidencia');
    var idTicket = $(this).attr('idTicket'); 
    
    swal({
        title: '¿Está seguro?',
        text: "¡Esta acción eliminará la imagen permanentemente!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=ticket&id=" + idTicket + "&idTicketevidencia=" + idTicketevidencia;
        }
    });
});
</script>