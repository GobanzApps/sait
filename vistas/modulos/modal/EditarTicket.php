<!-- MODAL EDITAR TICKET -->
<div class="modal fade" id="modalEditarTicket" tabindex="-1" role="dialog" aria-labelledby="modalEditarTicketLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #3c8dbc; color: white;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white;">&times;</span>
        </button>
        <h4 class="modal-title" id="modalEditarTicketLabel">
          <i class="fa fa-ticket"></i> Editar Ticket
        </h4>
      </div>

      <form role="form" method="post" enctype="multipart/form-data">
      
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <!-- Select2 para ENTE -->
              <div class="form-group col-md-6">
                <label for="editarEnte"><i class="fa fa-building"></i> Ente</label>
                <select class="form-control select2-ente-editar" id="editarEnte" name="editarEnte" style="width: 100%;" required>
                    <?php
                    $entes = ControladorEntes::ctrMostrarEntes(null, null);
                    foreach ($entes as $key => $value){
                      if ($value["estado"] != "1") continue;
                      echo '<option value="'.$value["id"].'">'.$value["entes"].'</option>';
                    }
                    ?>
                </select>
              </div>

              <!-- Campo SOLICITANTE -->
              <div class="form-group col-md-6">
                <label for="editarSolicitante"><i class="fa fa-user"></i> Solicitante</label>
                <input type="text" class="form-control" id="editarSolicitante" name="editarSolicitante" placeholder="Nombre del solicitante" required>
                <input type="hidden" class="form-control" id="editarTicket" name="editarTicket" required>
                <input type="hidden" id="idTicket" name="idTicket">
              </div>
            </div>

            <div class="col-md-12">
              <!-- Select2 para MEDIO -->
              <div class="form-group col-md-6">
                <label for="editarMedio"><i class="fa fa-phone"></i> Medio de Recepción</label>
                <select class="form-control select2-medio-editar" id="editarMedio" name="editarMedio" style="width: 100%;" required>
                    <?php
                    $medio = ControladorMedio::ctrMostrarMedio(null, null);
                    foreach ($medio as $key => $valueMedio){
                      if ($valueMedio["estado"] != "1") continue;
                      echo '<option value="'.$valueMedio["id"].'">'.$valueMedio["medio"].'</option>';
                    }
                    ?>
                </select>
              </div>

              <!-- Select2 para PRIORIDAD -->
              <div class="form-group col-md-6">
                <label for="editarPrioridad"><i class="fa fa-flag"></i> Prioridad</label>
                <select class="form-control select2-prioridad-editar" id="editarPrioridad" name="editarPrioridad" style="width: 100%;" required>
                    <?php
                    $prioridad = ControladorPrioridad::ctrMostrarPrioridad(null, null);
                    foreach ($prioridad as $key => $valuePrioridad){
                      if ($valuePrioridad["estado"] != "1") continue;
                      echo '<option value="'.$valuePrioridad["id"].'" data-color="'.$valuePrioridad["color"].'">'.$valuePrioridad["prioridad"].'</option>';
                    }
                    ?>
                </select>
              </div>

            </div>
          </div>

          <div class="row">
            <div class="col-md-12">     
              <!-- Campo DESCRIPCIÓN -->
              <div class="form-group col-md-12">
                <label for="editarDescripcion"><i class="fa fa-file-text"></i> Descripción</label>
                <textarea class="form-control" id="editarDescripcion" name="editarDescripcion" rows="5" placeholder="Describa el problema o solicitud..." required></textarea>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <!-- Select2 para FINALIZADO -->
              <div class="form-group col-md-6">
                <label for="editarFinalizado"><i class="fa fa-check-circle"></i> Finalizado</label>
                <select class="form-control select2-finalizado-editar" id="editarFinalizado" name="editarFinalizado" style="width: 100%;" required>
                  <option value="si">Sí</option>
                  <option value="no">No</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-info alert-dismissible" style="margin-top: 10px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fa fa-info-circle"></i> Información</h5>
                Complete todos los campos marcados con <i class="fa fa-asterisk text-red"></i> para editar el ticket.
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
            <i class="fa fa-times"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Actualizar Ticket
          </button>
        </div>
        
        <?php
        $editarTicket = new ControladorTicket();
        $editarTicket -> ctrEditarTicket();
        ?>

      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    
    // Inicializar Select2 para el modal de EDICIÓN
    $('.select2-ente-editar').select2({
      theme: 'bootstrap',
      language: 'es',
      dropdownParent: $('#modalEditarTicket')
    });
    
    $('.select2-medio-editar').select2({
      theme: 'bootstrap',
      placeholder: 'Seleccione un medio',
      language: 'es',
      dropdownParent: $('#modalEditarTicket')
    });

    $('.select2-status-editar').select2({
      theme: 'bootstrap',
      placeholder: 'Seleccione un status',
      language: 'es',
      dropdownParent: $('#modalEditarTicket')
    });
    
    $('.select2-prioridad-editar').select2({
      theme: 'bootstrap',
      placeholder: 'Seleccione una prioridad',
      language: 'es',
      templateResult: formatPrioridadEditar,
      templateSelection: formatPrioridadSelectionEditar,
      dropdownParent: $('#modalEditarTicket')
    });

    $('.select2-finalizado-editar').select2({
      theme: 'bootstrap',
      placeholder: 'Seleccione estado de finalización',
      language: 'es',
      dropdownParent: $('#modalEditarTicket')
    });
    
    // Función para formatear las opciones de prioridad con color
    function formatPrioridadEditar(option) {
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
    
    function formatPrioridadSelectionEditar(option) {
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
  });
</script>