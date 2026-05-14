<?php

session_start();

?>
<!DOCTYPE html>
<html>
<head>
  
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
  <title>Atencion al cliente - Ait</title>
  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="icon" href="vistas/img/plantilla/icono-negro.png">

  <!-------------- PLUGINS  DE CSS --------------->

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/dist/css/AdminLTE.css">
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- DataTables -->
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">

  <!-- Date Range Picker (dependencias: moment.js) -->
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap.min.js"></script>
  <!-- DateRangePicker CSS (Bootstrap 3 compatible) -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- DateRangePicker CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  

<!---------------- PLUGINS DE JAVASCRIPT -------->

<!-- jQuery 3 -->
<script src="vistas/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="vistas/dist/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
<script src="vistas/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
<!-- SweetAlert 2 -->
<script src="vistas/plugins/sweetalert2/sweetalert2.all.js"></script>

<!-- Select2 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
  <!-- Select2 Bootstrap 3 Theme (opcional, mejora la integración) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css">

  <!-- Select2 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <!-- Select2 Spanish (opcional) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/es.js"></script>




</head>


<!--<body class="hold-transition skin-black sidebar-mini login-page" style="background-color:white;"> --> 

<body class="hold-transition skin-black sidebar-mini login-page" style="background-image: url('vistas/img/plantilla/fondo.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">



  <?php

if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {

  echo '<div class="wrapper">';

    include "modulos/cabezote.php";
    include "modulos/menu.php";
    include "modulos/archivo_funciones.php";

   if(isset($_GET["ruta"])){

      if($_GET["ruta"] == "inicio" ||
         $_GET["ruta"] == "usuarios" ||
         $_GET["ruta"] == "medios" ||
         $_GET["ruta"] == "status" ||
         $_GET["ruta"] == "prioridad" ||
         $_GET["ruta"] == "coordinacion" ||
         $_GET["ruta"] == "entes" ||
         $_GET["ruta"] == "servicios" ||
         $_GET["ruta"] == "item" ||
         $_GET["ruta"] == "ticket" ||
         $_GET["ruta"] == "ticketcoordinacion" ||
         $_GET["ruta"] == "ticketusuario" ||
         $_GET["ruta"] == "ticketstatus" ||
         $_GET["ruta"] == "ticketservicios" ||
         $_GET["ruta"] == "tickets" ||
         $_GET["ruta"] == "reportesTicket" ||
         $_GET["ruta"] == "reportesCoordinacion" ||
         $_GET["ruta"] == "reportesUsuario" ||
         $_GET["ruta"] == "reportesServicio" ||
         $_GET["ruta"] == "reportesActividad" ||
         $_GET["ruta"] == "tipodocs" || 
         $_GET["ruta"] == "documento" ||
         $_GET["ruta"] == "historial" ||
         $_GET["ruta"] == "actividad" ||
         $_GET["ruta"] == "prueba" ||
         $_GET["ruta"] == "salir"){

        include "modulos/".$_GET["ruta"].".php";
      
      }else{
     
         include "modulos/404.php";
      }     

    }else{

      include "modulos/inicio.php";
  }

  /*--- FOOTER ---*/    

      include "modulos/footer.php";

      echo '</div>';

 }else{

      include "modulos/login.php";

  }

 ?>



<script src="vistas/js/plantilla.js"></script>
<script src="vistas/js/usuarios.js"></script>
<script src="vistas/js/prueba.js"></script>
<script src="vistas/js/medio.js"></script>
<script src="vistas/js/status.js"></script>
<script src="vistas/js/prioridad.js"></script>
<script src="vistas/js/coordinacion.js"></script>
<script src="vistas/js/entes.js"></script>
<script src="vistas/js/servicios.js"></script>
<script src="vistas/js/item.js"></script>
<script src="vistas/js/ticket.js"></script>

<script src="vistas/js/ticketcoordinacion.js"></script>
<script src="vistas/js/ticketusuario.js"></script>
<script src="vistas/js/ticketstatus.js"></script>
<script src="vistas/js/ticketservicios.js"></script>
<script src="vistas/js/ticketevidencia.js"></script>

<script src="vistas/js/actividad.js"></script>

<script src="vistas/js/tipodocs.js"></script>


</body>
</html>