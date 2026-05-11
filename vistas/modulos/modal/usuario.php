 <!-- MODAL CREAR -->
<div class="modal fade" id="modalAgregarUsuario" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form role="form" method="post" enctype="multipart/form-data">

            <div class="modal-header" style="background:#3c8dbc; color:white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-user-plus"></i> Agregar usuario</h4>
            </div>
                
            <div class="modal-body">
                <div class="form-group">
                    <label><i class="fa fa-user"></i> Ingresar usuario</label>
                    <input type="text" class="form-control" name="nuevoUsuario" placeholder="Ingresar usuario" id="nuevoUsuario" required>
                </div>
                    
                <div class="row">
                        
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-user-circle"></i> Ingresar nombre</label>
                            <input type="text" class="form-control" name="nuevoNombre" placeholder="Ingresar nombre" required>
                        </div>
                    </div>
                        
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label><i class="fa fa-user-circle"></i> Ingresar Apellido</label>
                        <input type="text" class="form-control" name="nuevoApellido" placeholder="Ingresar Apellido" id="nuevoApellido" required>
                    </div>
                </div>
            </div>
                        
            <div class="form-group">
                <label><i class="fa fa-lock"></i> Ingresar contraseña</label>
                <input type="password" class="form-control" name="nuevoPassword" placeholder="Ingresar contraseña" required>
            </div>
                
            <div class="form-group">
                <label><i class="fa fa-building"></i> Seleccionar Coordinación</label>
                <select class="form-control" name="nuevoId_coordinacion" id="nuevoId_coordinacion">
                    <option value="0">Seleccionar Coordinacion</option>
                    <?php
                    $coordinacion = ControladorCoordinacion::ctrMostrarCoordinacion(null, null);
                    foreach ($coordinacion as $key => $valueCoordinacion){
                      if ($valueCoordinacion["estado"] != "1") continue;
                      echo '<option value="'.$valueCoordinacion["id"].'">'.$valueCoordinacion["coordinacion"].'</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label><i class="fa fa-users"></i> Seleccionar Apoyo</label>
                <select class="form-control" name="nuevoId_apoyo" id="nuevoId_apoyo">
                    <option value="0">Seleccionar Apoyo</option>
                    <?php
                    $coordinacion = ControladorCoordinacion::ctrMostrarCoordinacion(null, null);
                    foreach ($coordinacion as $key => $valueCoordinacion){
                      if ($valueCoordinacion["estado"] != "1") continue;
                      echo '<option value="'.$valueCoordinacion["id"].'">'.$valueCoordinacion["coordinacion"].'</option>';
                    }
                    ?>
                </select>
            </div>
                
            <div class="form-group">
                <label><i class="fa fa-id-badge"></i> Seleccionar perfil</label>
                <select class="form-control" name="nuevoPerfil">
                    <option value="0">Seleccionar perfil</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Coordinacion">Coordinador</option>
                    <option value="Tecnico">Tecnico</option>
                </select>
            </div>
                
            <div class="upload-section">
                <label><i class="fa fa-upload"></i> SUBIR FOTO</label>
                <div class="input-group">
                    <label class="input-group-btn">
                    <span class="btn btn-default btn-file">Seleccionar archivo <input type="file" style="display: none;" name="nuevaFoto">                        </span>
                    </label>
                    <input type="text" class="form-control" readonly placeholder="Sin archivos seleccionados">
                </div>
                    
                <div class="max-size">
                    <i class="fa fa-info-circle"></i> Peso máximo de la foto 2MB
                </div>
            </div>
                
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Guardar usuario</button>
        </div>

        <?php
          $crearUsuario = new ControladorUsuarios();
          $crearUsuario -> ctrCrearUsuario();
        ?>
            
        </form>
       
        </div>
    </div>
</div>
        





 <!-- MODAL EDITAR -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form role="form" method="post" enctype="multipart/form-data">

            <div class="modal-header" style="background:#3c8dbc; color:white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-user-plus"></i> Editar usuario</h4>
            </div>
                
            <div class="modal-body">
                <div class="form-group">
                    <label><i class="fa fa-user"></i> Ingresar usuario</label>
                    <input type="text" class="form-control" id="editarUsuario" name="editarUsuario" value="" readonly>
                </div>
                    
                <div class="row">
                        
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-user-circle"></i> Ingresar nombre</label>
                            <input type="text" class="form-control" id="editarNombre" name="editarNombre" value="" required>
                        </div>
                    </div>
                        
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label><i class="fa fa-user-circle"></i> Ingresar Apellido</label>
                        <input type="text" class="form-control" id="editarApellido" name="editarApellido" value="" required>
                    </div>
                </div>
            </div>
                        
            <div class="form-group">
                <label><i class="fa fa-lock"></i> Ingresar contraseña</label>
                <input type="password" class="form-control" name="editarPassword" placeholder="Escriba la nueva contraseña">
                <input type="hidden" id="passwordActual" name="passwordActual">
            </div>
                
            <div class="form-group">
                <label><i class="fa fa-building"></i> Seleccionar Coordinación</label>
                    <select class="form-control" id="editarId_coordinacion" name="editarId_coordinacion">
                        <?php
                        $coordinacion = ControladorCoordinacion::ctrMostrarCoordinacion(null, null);
                        foreach ($coordinacion as $key => $valueCoordinacion2){
                        if ($valueCoordinacion2["estado"] != "1") continue;
                        echo '<option value="'.$valueCoordinacion2["id"].'">'.$valueCoordinacion2["coordinacion"].'</option>';
                        }
                        ?>
                    </select>
            </div>

            <div class="form-group">
                <label><i class="fa fa-users"></i> Seleccionar Apoyo</label>
                    <select class="form-control" id="editarId_apoyo" name="editarId_apoyo">
                        <option value="0">Seleccionar Apoyo</option>
                        <?php
                        $coordinacion = ControladorCoordinacion::ctrMostrarCoordinacion(null, null);
                        foreach ($coordinacion as $key => $valueCoordinacion2){
                        if ($valueCoordinacion2["estado"] != "1") continue;
                        echo '<option value="'.$valueCoordinacion2["id"].'">'.$valueCoordinacion2["coordinacion"].'</option>';
                        }
                        ?>
                    </select>
            </div>
                
            <div class="form-group">
                <label><i class="fa fa-id-badge"></i> Seleccionar perfil</label>
                <select class="form-control" name="editarPerfil">
                    <option value="" id="editarPerfil"></option>
                    <option value="Administrador">Administrador</option>
                    <option value="Coordinacion">Coordinador</option>
                    <option value="Tecnico">Tecnico</option>
                </select>
            </div>
                
            <div class="upload-section">
                <label><i class="fa fa-upload"></i> SUBIR FOTO</label>
                <div class="input-group">
                    <label class="input-group-btn">
                    <span class="btn btn-default btn-file">Seleccionar archivo <input type="file" style="display: none;" name="editarFoto">                        </span>
                    </label>
                    <input type="text" class="form-control" readonly placeholder="Sin archivos seleccionados">
                    <input type="hidden" name="fotoActual" id="fotoActual">
                </div>
                    
                <div class="max-size">
                    <i class="fa fa-info-circle"></i> Peso máximo de la foto 2MB
                </div>
            </div>
                
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Editar usuario</button>
        </div>

        <?php
          $editarUsuario = new ControladorUsuarios();
          $editarUsuario -> ctrEditarUsuario();
        ?>
            
        </form>
       
        </div>
    </div>
</div>
        