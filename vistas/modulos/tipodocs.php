<?php

if( $_SESSION["perfil"] != "Administrador"  &&
    $_SESSION["id_coordinacion"] != "11"    &&  //Archivo
    $_SESSION["id_coordinacion"] != "8"     &&  //centro de atencion
    $_SESSION["usuario"] != "agamardo"          //Angie
   ){


echo'
<button type="button" class="btn btn-default bg-maroon toastsDefaultMaroon">
                  Launch Maroon Toast
                </button>';






  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>


<div class="content-wrapper">
    <section class="content-header">
        <h1>Administrar Tipos de Documentos</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Administrar tipos de documentos</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarTipodoc">
                    Agregar Tipo de Documento
                </button>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                    <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Tipo Documento</th>
                            <th>Estado</th>
                            <th>Ultima Modificacion</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $item = null;
                    $valor = null;
                    $tipodocs = ControladorTipodocs::ctrMostrarTipodocs($item, $valor);

                    foreach ($tipodocs as $key => $value){
                        echo '<tr>
                                <td>'.($key+1).'</td>
                                <td>'.$value["tipodocs"].'</td>';

                        if($value["estado"] != 0){
                            echo '<td><button class="btn btn-success btn-xs btnActivar" idTipodoc="'.$value["id"].'" estadoTipodoc="1">Activado</button></td>';
                        } else {
                            echo '<td><button class="btn btn-danger btn-xs btnActivar" idTipodoc="'.$value["id"].'" estadoTipodoc="0">Desactivado</button></td>';
                        }

                        echo '<td>'.$value["modificacion"].'</td>
                              <td>'.$value["fecha"].'</td>
                              <td>
                                <div class="btn-group">
                                
                  ';  
                  if($_SESSION["perfil"] == "Administrador" ||
                  $_SESSION["id_coordinacion"] == "11" ||
                  $_SESSION["usuario"] == "agamardo"     //Archivo
                  
                  ){
                  echo '
                                    <button class="btn btn-sm btn-warning btnEditarTipodoc" idTipodoc="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarTipodoc"><i class="fa fa-pencil"></i></button>
                    ';}
                    if($_SESSION["perfil"] == "Administrador"

                    ){
                  echo '

                                    <button class="btn btn-sm btn-danger btnEliminarTipodoc" idTipodoc="'.$value["id"].'" tipodoc="'.$value["tipodocs"].'"><i class="fa fa-times"></i></button>
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

<!-- Modal Agregar -->
<div id="modalAgregarTipodoc" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">Agregar Tipo de Documento</h5>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span> 
                                <input type="text" class="form-control input-lg" name="nuevoTipodoc" id="nuevoTipodoc" placeholder="Ingresar tipo de documento" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                <?php
                $crearTipodoc = new ControladorTipodocs();
                $crearTipodoc -> ctrCrearTipodoc();
                ?>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div id="modalEditarTipodoc" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Tipo de Documento</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span> 
                                <input type="text" class="form-control input-lg" id="editarTipodoc" name="editarTipodoc" required>
                                <input type="hidden" id="idTipodoc" name="idTipodoc">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </div>
                <?php
                $editarTipodoc = new ControladorTipodocs();
                $editarTipodoc -> ctrEditarTipodoc();
                ?>
            </form>
        </div>
    </div>
</div>

<?php
$borrar = new ControladorTipodocs();
$borrar -> ctrBorrarTipodoc();
?>