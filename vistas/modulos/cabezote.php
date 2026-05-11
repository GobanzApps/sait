<header class="main-header">

<!------- LOGOTIPO -------->

<a href="inicio" class="logo">

    <!--- logo mini --->

    <span class="logo-mini">
        
        <img src="vistas/img/plantilla/icono-blanco.png" class="img-responsive" style="padding:10px">

    </span>

    <!--- logo normal --->

    <span class="logo-lg">
        
        <img src="vistas/img/plantilla/logo-blanco-lineal.png" class="img-responsive" style="padding:10px 0px;">

    </span>

</a>

<!------- BARRA DE NAVEGACION -------->

<nav class="navbar navbar-static-top" role="navigation">

    <!--- BOTON DE NAVEGACION SIDEBAR --->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>

    <!--- PERFIL DE USUARIO --->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                    <?php 
                    if(isset($_SESSION["foto"]) && !empty($_SESSION["foto"])): 
                    ?>
                        <img src="<?php echo $_SESSION["foto"]; ?>" class="user-image" alt="User Image">
                    <?php else: ?>
                        <img src="vistas/img/usuarios/default/anonymous.png" class="user-image" alt="User Image">
                    <?php endif; ?>
                    <span class="hidden-xs"><?php echo $_SESSION["nombre"]; ?></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="user-header">
                        <?php 
                        if(isset($_SESSION["foto"]) && !empty($_SESSION["foto"])): 
                        ?>
                            <img src="<?php echo $_SESSION["foto"]; ?>" class="img-circle" alt="User Image">
                        <?php else: ?>
                            <img src="vistas/img/usuarios/default/anonymous.png" class="img-circle" alt="User Image">
                        <?php endif; ?>
                        <p>
                            <?php 
                            echo $_SESSION["nombre"]." ".$_SESSION["apellido"];
                            ?>
                            <small><?php echo $_SESSION["id_coordinacion"]; ?></small>
                        </p>
                    </li>
                    <!-- Botón para cambiar contraseña -->
                    <li class="user-footer text-center" style="border-bottom: 1px solid #f4f4f4; padding: 8px;">
                        <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#modalCambiarPassword">
                            <i class="fa fa-key"></i> Cambiar Contraseña
                        </button>
                    </li>
                    <li class="user-footer">
                        <div class="pull-right">
                            <a href="salir" class="btn btn-default btn-flat">Salir</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

</nav>

</header>

<!-- Modal Cambiar Contraseña -->
<div class="modal fade" id="modalCambiarPassword" tabindex="-1" role="dialog" aria-labelledby="modalCambiarPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
                <h4 class="modal-title" id="modalCambiarPasswordLabel">
                    <i class="fa fa-key"></i> Cambiar Contraseña
                </h4>
            </div>
            <form id="formCambiarPassword" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="passwordActual">Contraseña Actual</label>
                        <input type="password" class="form-control" id="passwordActual" name="passwordActual" placeholder="Ingrese su contraseña actual" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="nuevaPassword">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="nuevaPassword" name="nuevaPassword" placeholder="Mínimo 4 caracteres" required autocomplete="off">
                        <small class="text-muted">Solo letras y números, mínimo 4 caracteres</small>
                    </div>
                    <div class="form-group">
                        <label for="confirmarPassword">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="confirmarPassword" name="confirmarPassword" placeholder="Repita la nueva contraseña" required autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Actualizar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script para manejar el cambio de contraseña -->
<script>
$(document).ready(function() {
    
    $('#formCambiarPassword').on('submit', function(e) {
        e.preventDefault();
        
        var passwordActual = $('#passwordActual').val();
        var nuevaPassword = $('#nuevaPassword').val();
        var confirmarPassword = $('#confirmarPassword').val();
        
        // Validación básica
        if(passwordActual === '' || nuevaPassword === '' || confirmarPassword === '') {
            swal({
                type: 'error',
                title: 'Campos incompletos',
                text: 'Por favor complete todos los campos'
            });
            return false;
        }
        
        if(nuevaPassword !== confirmarPassword) {
            swal({
                type: 'error',
                title: 'Las contraseñas no coinciden',
                text: 'La nueva contraseña y su confirmación deben ser iguales'
            });
            return false;
        }
        
        if(nuevaPassword.length < 4) {
            swal({
                type: 'error',
                title: 'Contraseña muy corta',
                text: 'La nueva contraseña debe tener al menos 4 caracteres'
            });
            return false;
        }
        
        // Validar que la nueva contraseña solo tenga letras y números
        var regex = /^[a-zA-Z0-9]+$/;
        if(!regex.test(nuevaPassword)) {
            swal({
                type: 'error',
                title: 'Formato inválido',
                text: 'La contraseña solo puede contener letras y números'
            });
            return false;
        }
        
        // Enviar datos con AJAX
        var datos = new FormData();
        datos.append("cambiarPassword", true);
        datos.append("passwordActual", passwordActual);
        datos.append("nuevaPassword", nuevaPassword);
        datos.append("confirmarPassword", confirmarPassword);
        
        $.ajax({
            url: "ajax/usuarios.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta) {
                if(respuesta.status === "success") {
                    swal({
                        type: 'success',
                        title: '¡Contraseña actualizada!',
                        text: respuesta.mensaje,
                        confirmButtonText: 'Aceptar'
                    }).then(function() {
                        $('#modalCambiarPassword').modal('hide');
                        $('#formCambiarPassword')[0].reset();
                    });
                } else {
                    swal({
                        type: 'error',
                        title: 'Error',
                        text: respuesta.mensaje,
                        confirmButtonText: 'Aceptar'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                console.error("Respuesta:", xhr.responseText);
                swal({
                    type: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo procesar la solicitud. Intente nuevamente.',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
    
    // Limpiar formulario al cerrar modal
    $('#modalCambiarPassword').on('hidden.bs.modal', function() {
        $('#formCambiarPassword')[0].reset();
    });
});
</script>