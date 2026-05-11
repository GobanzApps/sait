<?php

if($_SESSION["perfil"] != "Administrador" &&
  $_SESSION["perfil"] != "Coordinacion" &&
   $_SESSION["id_coordinacion"] != "9"			//Centro deAtencion
   
){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}

?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>Administrar Servicios</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar servicios</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarServicios">Agregar Servicios</button>
      </div>
      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
          <tr>
           <th style="width:10px">#</th>
           <th>Servicios</th>
           <th>Coordinación</th>
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
        $servicios = ControladorServicios::ctrMostrarServicios($item, $valor);

        foreach ($servicios as $key => $value){
         
          echo '<tr>
                   <td>'.($key+1).'</td>
                   <td>'.$value["servicios"].'</td>
                   <td>'.($value["nombre_coordinacion"] ?? 'No asignada').'</td>';

          if($value["estado"] != 0){
            echo '<td><button class="btn btn-success btn-xs btnActivar" idServicios="'.$value["id"].'" estadoServicios="0">Activado</button></td>';
          }else{
            echo '<td><button class="btn btn-danger btn-xs btnActivar" idServicios="'.$value["id"].'" estadoServicios="1">Desactivado</button></td>';
          }             

          echo '<td>'.$value["modificacion"].'</td>
                <td>'.$value["fecha"].'</td>
                <td>
                  <div class="btn-group">
                    <button class="btn btn-sm btn-warning btnEditarServicios" idServicios="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarServicios"><i class="fa fa-pencil"></i></button>
                  ';  
          if($_SESSION["perfil"] == "Administrador"){
            echo '<button class="btn btn-sm btn-danger btnEliminarServicios" idServicios="'.$value["id"].'" servicios="'.$value["servicios"].'"><i class="fa fa-times"></i></button>';
          }
          echo '
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

<!-- Modal de crear -->
<div id="modalAgregarServicios" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h5 class="modal-title">Agregar Servicios</h5>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tag"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoServicios" id="nuevoServicios" placeholder="Ingresar servicios" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                <select class="form-control input-lg select2" name="nuevoIdCoordinacion" id="nuevoIdCoordinacion" style="width:100%">
                  <option value="">Seleccionar Coordinación</option>
                  <?php
                  $coordinaciones = ControladorCoordinacion::ctrMostrarCoordinacion(null, null);
                  foreach ($coordinaciones as $key => $value) {
                    echo '<option value="'.$value["id"].'">'.$value["coordinacion"].'</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar servicios</button>
        </div>
        <?php
          $crearServicios = new ControladorServicios();
          $crearServicios -> ctrCrearServicios();
        ?>
      </form>
    </div>
  </div>
</div>





<!-- Modal de editar -->
<div id="modalEditarServicios" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Servicios</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tag"></i></span> 
                <input type="text" class="form-control input-lg" id="editarServicios" name="editarServicios" value="">
                <input type="hidden" id="idServicios" name="idServicios" value="">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                <select class="form-control input-lg select2" name="editarIdCoordinacion" id="editarIdCoordinacion" style="width:100%">
                  <option value="">Seleccionar Coordinación</option>
                  <?php
                  $coordinaciones = ControladorCoordinacion::ctrMostrarCoordinacion(null, null);
                  foreach ($coordinaciones as $key => $value) {
                    // Seleccionar automáticamente la coordinación guardada (opcional, pero útil)
                    $selected = (isset($valueSeleccionada) && $valueSeleccionada == $value["id"]) ? "selected" : "";
                    echo '<option value="'.$value["id"].'">'.$value["coordinacion"].'</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Modificar servicios</button>
        </div>
        <?php
          $editarServicios = new ControladorServicios();
          $editarServicios -> ctrEditarServicios();
        ?> 
      </form>
    </div>
  </div>
</div>






<?php
  $borrar = new ControladorServicios();
  $borrar -> ctrBorrarServicios();
?> 

<script>
  // Inicializar Select2 para los selects de coordinación
  $(document).ready(function() {
    $('#nuevoIdCoordinacion').select2({
      dropdownParent: $('#modalAgregarServicios'),
      language: "es",
      placeholder: "Seleccionar Coordinación",
      allowClear: true
    });
    
    $('#editarIdCoordinacion').select2({
      dropdownParent: $('#modalEditarServicios'),
      language: "es",
      placeholder: "Seleccionar Coordinación",
      allowClear: true
    });
  });
</script>