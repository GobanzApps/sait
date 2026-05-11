<?php
// Archivo: vistas/modales/actividad.php
?>

<!-- Modal AGREGAR Actividad -->
<div id="modalAgregarActividad" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" id="formAgregarActividad" method="post">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">Agregar Actividad</h5>
                </div>

                <div class="modal-body">
                    <div class="box-body">
                        <!-- Campo: Nombre de la Actividad -->
                        <div class="form-group">
                            <label>Nombre de la Actividad</label>
                            <input type="text" class="form-control" name="nuevoActividad" id="nuevoActividad" placeholder="Ingresar nombre de la actividad" required>
                        </div>
                        
                        <!-- Campo: Usuarios Asignados -->
                        <div class="form-group">
                            <label>Usuarios Asignados (Múltiple)</label>
                            <select class="form-control select2-usuarios-agregar" name="nuevoIdUsuario[]" multiple="multiple" style="width: 100%" required>
                                <?php
                                $usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);
                                foreach ($usuarios as $user){
                                    if($user["estado"] == 1){
                                        echo '<option value="'.$user["id"].'">'.$user["nombre"].' '.$user["apellido"].' ('.$user["usuario"].')</option>';
                                    }
                                }
                                ?>
                            </select>
                            <p class="help-block">Puede seleccionar múltiples usuarios.</p>
                        </div>

                        <!-- Campo: Servicios Relacionados -->
                        <div class="form-group">
                            <label>Servicios Relacionados (Múltiple)</label>
                            <select class="form-control select2-servicios-agregar" name="nuevoIdServicios[]" multiple="multiple" style="width: 100%" required>
                                <?php
                                $servicios = ControladorServicios::ctrMostrarServicios(null, null);
                                foreach ($servicios as $serv){
                                    if($serv["estado"] == 1){
                                        echo '<option value="'.$serv["id"].'">'.$serv["servicios"].'</option>';
                                    }
                                }
                                ?>
                            </select>
                            <p class="help-block">Puede seleccionar múltiples servicios.</p>
                        </div>

                        <!-- Campo: Entes Relacionados -->
                        <div class="form-group">
                            <label>Entes Relacionados (Múltiple)</label>
                            <select class="form-control select2-entes-agregar" name="nuevoIdEnte[]" multiple="multiple" style="width: 100%" required>
                                <?php
                                $entes = ControladorEntes::ctrMostrarEntes(null, null);
                                foreach ($entes as $ente){
                                    if($ente["estado"] == 1){
                                        echo '<option value="'.$ente["id"].'">'.$ente["entes"].'</option>';
                                    }
                                }
                                ?>
                            </select>
                            <p class="help-block">Puede seleccionar múltiples entes.</p>
                        </div>

                        <!-- Campo: Descripción -->
                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea class="form-control" name="nuevaDescripcion" rows="5" placeholder="Descripción detallada de la actividad" required></textarea>
                        </div>
                        
                        <!-- Nota informativa -->
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> <strong>Nota:</strong> La coordinación se asignará automáticamente desde tu perfil de usuario.
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary">Guardar Actividad</button>
                </div>

                <?php
                $crearActividad = new ControladorActividad();
                $crearActividad->ctrCrearActividad();
                ?>
            </form>
        </div>
    </div>
</div>

<!-- Modal EDITAR Actividad -->
<div id="modalEditarActividad" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" id="formEditarActividad" method="post">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Actividad</h4>
                </div>

                <div class="modal-body">
                    <div class="box-body">
                        <input type="hidden" id="idActividad" name="idActividad">
                        
                        <!-- Campo: Nombre de la Actividad -->
                        <div class="form-group">
                            <label>Nombre de la Actividad</label>
                            <input type="text" class="form-control" id="editarActividad" name="editarActividad" required>
                        </div>
                        
                        <!-- Campo: Usuarios Asignados -->
                        <div class="form-group">
                            <label>Usuarios Asignados (Múltiple)</label>
                            <select class="form-control select2-usuarios-editar" name="editarIdUsuario[]" multiple="multiple" style="width: 100%" required>
                                <?php
                                $usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);
                                foreach ($usuarios as $user){
                                    if($user["estado"] == 1){
                                        echo '<option value="'.$user["id"].'">'.$user["nombre"].' '.$user["apellido"].' ('.$user["usuario"].')</option>';
                                    }
                                }
                                ?>
                            </select>
                            <p class="help-block">Puede seleccionar múltiples usuarios.</p>
                        </div>

                        <!-- Campo: Servicios Relacionados -->
                        <div class="form-group">
                            <label>Servicios Relacionados (Múltiple)</label>
                            <select class="form-control select2-servicios-editar" name="editarIdServicios[]" multiple="multiple" style="width: 100%" required>
                                <?php
                                $servicios = ControladorServicios::ctrMostrarServicios(null, null);
                                foreach ($servicios as $serv){
                                    if($serv["estado"] == 1){
                                        echo '<option value="'.$serv["id"].'">'.$serv["servicios"].'</option>';
                                    }
                                }
                                ?>
                            </select>
                            <p class="help-block">Puede seleccionar múltiples servicios.</p>
                        </div>

                        <!-- Campo: Entes Relacionados -->
                        <div class="form-group">
                            <label>Entes Relacionados (Múltiple)</label>
                            <select class="form-control select2-entes-editar" name="editarIdEnte[]" multiple="multiple" style="width: 100%" required>
                                <?php
                                $entes = ControladorEntes::ctrMostrarEntes(null, null);
                                foreach ($entes as $ente){
                                    if($ente["estado"] == 1){
                                        echo '<option value="'.$ente["id"].'">'.$ente["entes"].'</option>';
                                    }
                                }
                                ?>
                            </select>
                            <p class="help-block">Puede seleccionar múltiples entes.</p>
                        </div>

                        <!-- Campo: Descripción -->
                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea class="form-control" id="editarDescripcion" name="editarDescripcion" rows="5" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary">Modificar Actividad</button>
                </div>

                <?php
                $editarActividad = new ControladorActividad();
                $editarActividad->ctrEditarActividad();
                ?>
            </form>
        </div>
    </div>
</div>