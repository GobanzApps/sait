<script>

$(document).ready(function() {
    // Eliminar ticket coordinación
    $('.btnEliminarTicketstatus').on('click', function() {
    var idTicketstatus = $(this).attr('idTicketstatus');
    var idTicket = $(this).attr('idTicket'); 
    
        swal({
            title: '¿Está seguro?',
            text: "¡No podrás revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(function(result) {
            if (result.value) {
                        window.location = "index.php?ruta=ticket&id=" + idTicket + "&idTicketstatus=" + idTicketstatus;
            }
        });
    });
});

</script>


<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Status    

<?php 
if($ticketInfo["finalizado"] != "si") {


echo'
      <button type="button" class="btn btn-xs" data-toggle="modal" data-target="#modalAgregarTicketstatus"">
      <i class="fa fa-plus"></i> Añadir</button>

';


}


?>



    </h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
 <!--     <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fa fa-times"></i> -->
    </div>
  </div>

 
  <div class="box-body">

    <ul class="timeline">

        <?php

        $ticketstatus = null;
        $valor = null;

        $ticketstatus = ControladorTicketstatus::ctrMostrarTicketstatus($ticketstatus, $valor);

        foreach ($ticketstatus as $key => $value){

          if ($value["id_ticket"] != $ticketInfo["id"]) continue;

          echo'

                <li>
                  <i class="fa fa-flag-o bg-aqua"></i>
                  <div class="timeline-item">';
                  $datosStatus = obtenerDatosStatus($value["id_status"]);
         echo '     
                    
                    <button
                      idTicketstatus="'.$value["id"].'" 
                      idTicket="'.$value["id_ticket"].'"
                      style="color: white; background-color:'.$datosStatus["color"].'"
                      class="btn btn-xs';
          

          if( $ticketInfo["finalizado"] != "si" && 
              ($_SESSION["perfil"] == "Administrador") 
          ){
              echo ' btnEliminarTicketstatus"><i class="fa fa-times"></i> ';
          } else { 
              echo '">'; 
          }






          
          echo '      '.$datosStatus["status"].'
                    </button>
                    <span class="time"><i class="fa fa-clock-o"></i> '.$value["fecha"].'</span>
                  </div>
                </li>
            
              ';

        }

        ?>
    
    </ul>
  
  </div>
   
</div>







<!--- Modal de crear --->

<div id="modalAgregarTicketstatus" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">

        <!--- Cabezal del modal --->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h5 class="modal-title">Agregar Status</h5>
        </div>

        <!--- Cuerpo del modal --->

        <div class="modal-body">
          <div class="box-body">

            <!-- ENTRADA PARA PRUEBA -->

            <div class="form-group">
                <input type="hidden" class="form-control input-lg" name="nuevoId_ticket" value="<?php echo $ticketInfo["id"];?>" required>
                <label><i class="fa fa-building"></i> Seleccionar Status</label>
                <select class="form-control" name="nuevoId_status">
                    <option value="0">Seleccionar status</option>
                    <?php
                    $status = ControladorStatus::ctrMostrarStatus($null, null);
                    foreach ($status as $key => $valueCoordinacion){
                      if ($valueCoordinacion["estado"] != "1") continue;
                      echo '<option value="'.$valueCoordinacion["id"].'">'.$valueCoordinacion["status"].'</option>';
                    }
                    ?>
                </select>
            </div>

          </div>
        </div>

        <!--- Pie del Modal --->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar ticketstatus</button>
        </div>

        <?php
          $crearTicketstatus = new ControladorTicketstatus();
          $crearTicketstatus -> ctrCrearTicketstatus();
        ?>

      </form>
    </div>
  </div>
</div>



