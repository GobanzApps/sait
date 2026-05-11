<script>
$(document).ready(function() {
    // Inicializar Select2 para el campo de usuario
    $('.select2-usuario').select2({
        theme: 'bootstrap',
        placeholder: 'Seleccione un usuario',
        language: 'es',
        dropdownParent: $('#modalAgregarTicketusuario'),
        escapeMarkup: function(markup) {
            return markup; // Permitir HTML
        },
        templateResult: formatUsuario,
        templateSelection: formatUsuarioSelection
    });
    
    // Función para formatear las opciones del select2 (muestra nombre y apellido)
    function formatUsuario(option) {
        if (!option.id) {
            return option.text;
        }
        var nombre = $(option.element).data('nombre');
        var apellido = $(option.element).data('apellido');
        if (nombre && apellido) {
            var $option = $(
                '<div><i class="fa fa-user"></i> ' + nombre + ' ' + apellido + '</div>'
            );
            return $option;
        }
        return option.text;
    }
    
    // Función para formatear la selección (muestra nombre y apellido con ícono)
    function formatUsuarioSelection(option) {
        if (!option.id) {
            return option.text;
        }
        var nombre = $(option.element).data('nombre');
        var apellido = $(option.element).data('apellido');
        if (nombre && apellido) {
            // Crear un elemento HTML directamente
            var $selection = $('<span><i class="fa fa-user"></i> ' + nombre + ' ' + apellido + '</span>');
            return $selection;
        }
        return option.text;
    }
    
    // Eliminar ticket usuario
    $('.btnEliminarTicketusuario').on('click', function() {
        var idTicketusuario = $(this).attr('idTicketusuario');
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
                window.location = "index.php?ruta=ticket&id=" + idTicket + "&idTicketusuario=" + idTicketusuario;
            }
        });
    });
    
    // Al abrir el modal, refrescar el select2
    $('#modalAgregarTicketusuario').on('shown.bs.modal', function() {
        $('.select2-usuario').select2('open').select2('close');
    });
    
    // Limpiar el select2 cuando se cierra el modal
    $('#modalAgregarTicketusuario').on('hidden.bs.modal', function() {
        $('.select2-usuario').val('').trigger('change');
    });
});
</script>

<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Usuario    
            <?php 
            if($ticketInfo["finalizado"] != "si") {
                echo '
                <button type="button" class="btn btn-xs" data-toggle="modal" data-target="#modalAgregarTicketusuario">
                    <i class="fa fa-plus"></i> Añadir
                </button>';
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
        <div class="col-md-12">
            <?php
            $ticketusuario = null;
            $valor = null;
            $ticketusuario = ControladorTicketusuario::ctrMostrarTicketusuario($ticketusuario, $valor);
            
            foreach ($ticketusuario as $key => $value){
                if ($value["id_ticket"] != $ticketInfo["id"]) continue;
                    
                echo '
                <button 
                    idTicketusuario="'.$value["id"].'"
                    idTicket="'.$value["id_ticket"].'"
                    class="btn btn-xs btn-primary';
                
                if($ticketInfo["finalizado"] != "si" && 
                    ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Coordinacion" || $_SESSION["id_coordinacion"] == "9")) {
                    echo ' btnEliminarTicketusuario"><i class="fa fa-times"></i> ';
                } else { 
                    echo '">'; 
                }
                
                echo obtenerDatosUsuario($value["id_usuario"])['nombre'] . ' ' . obtenerDatosUsuario($value["id_usuario"])['apellido'] . '
                </button>';
            }
            ?>
        </div>
    </div>
</div>

<!--- Modal de crear --->
<div id="modalAgregarTicketusuario" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">Agregar Usuario</h5>
                </div>

                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control input-lg" name="nuevoId_ticket" value="<?php echo $ticketInfo["id"];?>" required>
                            <label><i class="fa fa-user"></i> Seleccionar Usuario</label>
                            <select class="form-control select2-usuario" name="nuevoId_usuario" style="width: 100%;">
                                <option value="0">Seleccionar Usuario</option>
                                <?php
                                $usuario = ControladorUsuarios::ctrMostrarUsuarios(null, null);
                                foreach ($usuario as $key => $valueUsuario){
                                    if ($valueUsuario["estado"] != "1") continue;
                                    echo '<option 
                                        value="'.$valueUsuario["id"].'"
                                        data-nombre="'.$valueUsuario["nombre"].'"
                                        data-apellido="'.$valueUsuario["apellido"].'"
                                        >' . $valueUsuario["nombre"] . ' ' . $valueUsuario["apellido"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary">Guardar ticketusuario</button>
                </div>

                <?php
                $crearTicketusuario = new ControladorTicketusuario();
                $crearTicketusuario->ctrCrearTicketusuario();
                ?>
            </form>
        </div>
    </div>
</div>