<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="active"><a href="inicio"><i class="fa fa-home"></i><span>Inicio</span></a></li>
            
            <?php
            // ADMINISTRAR TICKET
            if ($_SESSION["perfil"] == "Administrador" ||
                $_SESSION["id_coordinacion"] == "9" ||
                $_SESSION["usuario"] == "agamardo"
            ) {
                echo '<li><a href="tickets"><i class="fa fa-ticket"></i> <span>Administrar Tickets</span></a></li>';
            }
            
            echo '<li><a href="historial"><i class="fa fa-history"></i> <span>Historial de Tickets</span></a></li>
            <li><a href="actividad"><i class="fa fa-history"></i> <span>Historial de Actividades</span></a></li>';
            
            // ADMINISTRAR USUARIO
            if ($_SESSION["perfil"] == "Administrador") {
                echo '<li><a href="usuarios"><i class="fa fa-users"></i><span>Administrar Usuarios</span></a></li>';
            }
            
            // AJUSTE TICKETS
            if ($_SESSION["perfil"] == "Administrador" || $_SESSION["id_coordinacion"] == "9") {
                echo '
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-list-ul"></i><span>Ajustes</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="medios"><i class="fa fa-circle-o"></i><span>Medios</span></a></li>
                        <li><a href="status"><i class="fa fa-circle-o"></i><span>Status</span></a></li>
                        <li><a href="prioridad"><i class="fa fa-circle-o"></i><span>Prioridad</span></a></li>
                        <li><a href="coordinacion"><i class="fa fa-circle-o"></i><span>Coordinaciones</span></a></li>
                        <li><a href="entes"><i class="fa fa-circle-o"></i><span>Entes</span></a></li>
                        <li><a href="servicios"><i class="fa fa-circle-o"></i><span>Tipos de servicios</span></a></li>
                        <li><a href="item"><i class="fa fa-circle-o"></i><span>Tipos de equipos</span></a></li>
                    </ul>
                </li>';
            }
            
            // AJUSTE TICKETS PARA COORDINACION
            if ($_SESSION["perfil"] == "Coordinacion") {
                echo '
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-list-ul"></i><span>Ajustes</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="servicios"><i class="fa fa-circle-o"></i><span>Tipos de servicios</span></a></li>
                        <li><a href="item"><i class="fa fa-circle-o"></i><span>Tipos de equipos</span></a></li>
                    </ul>
                </li>';
            }
            
            // TICKETS
            if ($_SESSION["perfil"] == "Administrador") {
                echo '
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-sort-numeric-asc"></i><span>Tickets</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="ticketcoordinacion"><i class="fa fa-circle-o"></i><span>Coordinacion</span></a></li>
                        <li><a href="ticketusuario"><i class="fa fa-circle-o"></i><span>Usuario</span></a></li>
                        <li><a href="ticketstatus"><i class="fa fa-circle-o"></i><span>Status</span></a></li>
                        <li><a href="ticketservicios"><i class="fa fa-circle-o"></i><span>Servicios</span></a></li>
                    </ul>
                </li>';
            }
            
            // REPORTES DE TICKETS
            if ($_SESSION["perfil"] == "Administrador" ||
                $_SESSION["perfil"] == "Coordinacion" ||
                $_SESSION["id_coordinacion"] == "9" ||
                $_SESSION["id_coordinacion"] == "7"
            ) {
                echo '
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bar-chart"></i><span>Reportes</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="reportesTicket"><i class="fa fa-circle-o"></i><span>Tickets</span></a></li>
                        <li><a href="reportesCoordinacion"><i class="fa fa-circle-o"></i><span>Coordinacion</span></a></li>
                        <li><a href="reportesUsuario"><i class="fa fa-circle-o"></i><span>Usuario</span></a></li>
                        <li><a href="reportesServicio"><i class="fa fa-circle-o"></i><span>Servicios y items</span></a></li>
                        <li><a href="reportesActividad"><i class="fa fa-tasks"></i> Reporte de Actividades</a></li>
                    </ul>
                </li>';
            }
            
            // GESTION DE ARCHIVOS
            if ($_SESSION["perfil"] == "Administrador" ||
                $_SESSION["id_coordinacion"] == "12" ||
                $_SESSION["id_coordinacion"] == "9" ||
                $_SESSION["id_coordinacion"] == "7" ||
                $_SESSION["usuario"] == "agamardo"
            ) {
                echo '
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-files-o"></i><span>Gestion de Archivos</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="documento"><i class="fa fa-circle-o"></i><span>Administrar Documentos</span></a></li>
                        <li><a href="tipodocs"><i class="fa fa-circle-o"></i><span>Tipos de Documentos</span></a></li>
                    </ul>
                </li>';
            }
            ?>
        </ul>
    </section>
</aside>