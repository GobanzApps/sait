<?php
// Verificar que $ticketInfo esté definida
if (!isset($ticketInfo)) {
    $item = "id";
    $valor = $_GET["id"] ?? null;
    if ($valor) {
        $ticketInfo = ControladorTicket::ctrMostrarTicket($item, $valor);
    }
}
?>

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Documentos Adjuntos</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fa fa-minus"></i>
      </button>
 <!--     <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fa fa-times"></i> -->
      </button>
    </div>
  </div>

  <div class="box-body">
    <div class="col-md-12">
      <?php
      if (isset($ticketInfo) && isset($ticketInfo["id"])) {
          // Obtener todos los documentos
          $documentos = ControladorDocumento::ctrMostrarDocumento(null, null);
          $encontrados = false;
          
          foreach ($documentos as $key => $value) {
              if ($value["id_ticket"] == $ticketInfo["id"]) {
                  $encontrados = true;
                  ?>
                  <div class="documento-item" style="border-bottom: 1px solid #f4f4f4; padding: 10px 0; margin-bottom: 10px;">
                      <div class="row">
                          <div class="col-md-8">
                              <strong><i class="fa fa-file-text-o"></i> Documento:</strong> <?php echo $value["documento"]; ?><br>
                              <strong><i class="fa fa-tag"></i> Tipo:</strong> <?php echo obtenerNombreTipodocs($value["id_tipodocs"]); ?><br>
                              <strong><i class="fa fa-envelope-o"></i> Asunto:</strong> <?php echo $value["asunto"]; ?><br>
                              <strong><i class="fa fa-user"></i> Remitente:</strong> <?php echo $value["remitente"]; ?><br>
                              <strong><i class="fa fa-user-plus"></i> Destinatario:</strong> <?php echo $value["destinatario"]; ?>
                          </div>
                          <div class="col-md-4 text-right">
                              <?php if($value["adjunto"] && $value["adjunto"] != ""): ?>
                                  <a href="<?php echo $value["adjunto"]; ?>" target="_blank" class="btn btn-sm btn-info" style="margin-top: 15px;">
                                      <i class="fa fa-paperclip"></i> Ver Documento
                                  </a>
                                  <br>
                             <!--     <small class="text-muted">
                                      <i class="fa fa-folder-open-o"></i> Ruta: <?php echo $value["adjunto"]; ?>  
                                  </small>-->
                              <?php else: ?>
                                  <span class="label label-warning" style="margin-top: 15px; display: inline-block;">
                                      <i class="fa fa-exclamation-triangle"></i> Sin adjunto
                                  </span>
                              <?php endif; ?>
                          </div>
                      </div>
                  </div>
                  <?php
              }
          }
          
          if(!$encontrados){
              echo '<div class="alert alert-info">
                      <i class="fa fa-info-circle"></i> No hay documentos vinculados a este ticket.
                      <br><br>

                    </div>';
          }
      } else {
          echo '<div class="alert alert-warning">
                  <i class="fa fa-warning"></i> No se pudo cargar la información del ticket.
                </div>';
      }
      ?>
    </div>
  </div>
</div>