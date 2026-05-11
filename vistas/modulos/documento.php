

<?php

if( $_SESSION["perfil"] != "Administrador"  &&
    $_SESSION["perfil"] != "Coordinacion"  &&
    $_SESSION["id_coordinacion"] != "11"    &&  //Archivo
    $_SESSION["id_coordinacion"] != "8"     &&  //centro de atencion
    $_SESSION["usuario"] != "agamardo"                    //Angie
   ){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>






<div class="content-wrapper">

    <section class="content-header">
        <h1>Administrar Documentos</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Administrar Documentos</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarDocumento">
                    Agregar Documento
                </button>
            </div>

            <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                    <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Documento</th>
                            <th>Tipo</th>
                            <th>Fecha Recibido/Entregado</th>
                            <th>Emisión</th>
                            <th>Remitente</th>
                            <th>Destinatario</th>
                            <th>Asunto</th>
                            <th>Vínculo de Ticket</th>
                            <th>Adjunto</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $item = null;
                        $valor = null;
                        $documentos = ControladorDocumento::ctrMostrarDocumento($item, $valor);

                        foreach ($documentos as $key => $value){
                            echo '<tr>
                                <td>'.($key+1).'</td>
                                <td>'.$value["documento"].'</td>
                                <td>'.obtenerNombreTipodocs($value["id_tipodocs"]).'</td>
                                <td>'.$value["fecha"].'</td>
                                <td>'.$value["emision"].'</td>
                                <td>'.$value["remitente"].'</td>
                                <td>'.$value["destinatario"].'</td>
                                <td>'.substr($value["asunto"], 0, 50).'...</td>
                                <td>';
                                
                                // Mostrar vínculo del ticket si existe
                                if($value["id_ticket"] && $value["id_ticket"] != ""){
                                    echo '<a href="index.php?ruta=ticket&id='.$value["id_ticket"].'" target="_blank" class="btn btn-xs btn-primary">Ticket #'.$value["id_ticket"].'</a>';
                                } else {
                                    echo '<span class="text-muted">Sin ticket</span>';
                                }
                                
                                echo '</td>
                                <td>';
                                
                                if($value["adjunto"] && $value["adjunto"] != ""){
                                    echo '<a href="'.$value["adjunto"].'" target="_blank" class="btn btn-xs btn-info">Ver</a>';
                                } else {
                                    echo '<span class="text-muted">Ninguno</span>';
                                }
                                
                                echo '</td>';
                                
                                if($value["estado"] != 0){
                                    echo '<td><button class="btn btn-success btn-xs btnActivar" idDocumento="'.$value["id"].'" estadoDocumento="0">Activado</button></td>';
                                } else {
                                    echo '<td><button class="btn btn-danger btn-xs btnActivar" idDocumento="'.$value["id"].'" estadoDocumento="1">Desactivado</button></td>';
                                }
                                
                                echo '<td>
                                    <div class="btn-group">
                                    
                  ';  
                  if($_SESSION["perfil"] == "Administrador" ||
                  $_SESSION["id_coordinacion"] == "12"   ||
                  $_SESSION["usuario"] == "agamardo"       //Archivo
                  
                  ){
                  echo '
                                        <button class="btn btn-sm btn-warning btnEditarDocumento" idDocumento="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarDocumento"><i class="fa fa-pencil"></i></button>
                    ';}
                  if($_SESSION["perfil"] == "Administrador"
                  ){
                  echo '



                                        <button class="btn btn-sm btn-danger btnEliminarDocumento" idDocumento="'.$value["id"].'" documento="'.$value["documento"].'"><i class="fa fa-times"></i></button>
                    ';}
                    echo'                
                                    </div>
                                </td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Modal Agregar Documento -->
<div id="modalAgregarDocumento" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">Agregar Documento</h5>
                </div>

                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre del Documento</label>
                                    <input type="text" class="form-control" name="nuevoDocumento" id="nuevoDocumento" placeholder="Ingresar nombre del documento" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo de Documento</label>
                                    <select class="form-control select2" name="nuevoIdTipodocs" style="width: 100%" required>
                                        <option value="">Seleccionar tipo</option>
                          
                                        <?php
                                        $tipodocs = ControladorTipodocs::ctrMostrarTipodocs(null, null);
                                        foreach ($tipodocs as $key => $value){
                                        if ($value["estado"] != "1") continue;
                                            echo '<option value="'.$value["id"].'">'.$value["tipodocs"].'</option>';
                                        }
                                        ?>
                            
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha Recibido/Entregado</label>
                                    <input type="date" class="form-control" name="nuevoFecha" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha de Emisión</label>
                                    <input type="date" class="form-control" name="nuevoEmision" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Remitente</label>
                                    <input type="text" class="form-control" name="nuevoRemitente" placeholder="Remitente" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Destinatario</label>
                                    <input type="text" class="form-control" name="nuevoDestinatario" placeholder="Destinatario" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Vínculo de Ticket</label>
                                    <input type="text" class="form-control" name="nuevoIdTicket" value="0" placeholder="Ingresar numero del ticket a vincular">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Asunto</label>
                                    <textarea class="form-control" name="nuevoAsunto" rows="3" placeholder="Asunto del documento" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Archivo Adjunto</label>
                                    <input type="file" class="form-control" name="nuevoAdjunto" accept=".pdf,application/pdf">
                                    <p class="help-block"><strong>Solo archivos PDF</strong> (Máx. 10MB)</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary">Guardar Documento</button>
                </div>

                <?php
                $crearDocumento = new ControladorDocumento();
                $crearDocumento->ctrCrearDocumento();
                ?>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Documento -->
<div id="modalEditarDocumento" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Documento</h4>
                </div>

                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre del Documento</label>
                                    <input type="text" class="form-control" id="editarDocumento" name="editarDocumento" required>
                                    <input type="hidden" id="idDocumento" name="idDocumento">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo de Documento</label>
                                    <select class="form-control select2" id="editarIdTipodocs" name="editarIdTipodocs" style="width: 100%" required>
                                        <option value="">Seleccionar tipo</option>
                                        
                                        <?php
                                        $tipodocs = ControladorTipodocs::ctrMostrarTipodocs(null, null);
                                        foreach ($tipodocs as $key => $value){
                                        if ($value["estado"] != "1") continue;
                                            echo '<option value="'.$value["id"].'">'.$value["tipodocs"].'</option>';
                                        }
                                        
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha </label>
                                    <input type="date" class="form-control" id="editarFecha" name="editarFecha" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha de Emisión</label>
                                    <input type="date" class="form-control" id="editarEmision" name="editarEmision" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Remitente</label>
                                    <input type="text" class="form-control" id="editarRemitente" name="editarRemitente" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Destinatario</label>
                                    <input type="text" class="form-control" id="editarDestinatario" name="editarDestinatario" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Vínculo de Ticket</label>
                                    <input type="text" class="form-control" name="editarIdTicket" id="editarIdTicket" placeholder="Ingresar numero del ticket a vincular">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Asunto</label>
                                    <textarea class="form-control" id="editarAsunto" name="editarAsunto" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Cambiar Archivo Adjunto</label>
                                    <input type="file" class="form-control" name="editarAdjunto" accept=".pdf,application/pdf">
                                    <p class="help-block"><strong>Solo archivos PDF</strong> (Máx. 10MB) - Dejar vacío para mantener el adjunto actual</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary">Modificar Documento</button>
                </div>

                <?php
                $editarDocumento = new ControladorDocumento();
                $editarDocumento->ctrEditarDocumento();
                ?>
            </form>
        </div>
    </div>
</div>

<?php
$borrar = new ControladorDocumento();
$borrar->ctrBorrarDocumento();
?>
<script src="vistas/js/documento.js"></script>