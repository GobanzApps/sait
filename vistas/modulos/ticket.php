<?php   
/* TABLA TICKET*/
$item = "id";
$valor = $_GET["id"];
$ticketInfo = ControladorTicket::ctrMostrarTicket($item, $valor);

$countidcoordinacion = "0";
$tieneCoincidencia = false;  // Bandera para saber si hubo coincidencia

$ticketcoordinacion2 = ControladorTicketcoordinacion::ctrMostrarTicketcoordinacion(null, null);

foreach ($ticketcoordinacion2 as $key => $value){

    if($ticketInfo["id"] != $value["id_ticket"]) continue;

    $tieneCoincidencia = true;  // Marcamos que sí hay coincidencia
      
    if($value["id_coordinacion"] == $_SESSION["id_coordinacion"] || $value["id_coordinacion"] == $_SESSION["id_apoyo"]){
        $countidcoordinacion++;
    }
    
}

// CORRECCIÓN: Verificar primero si el usuario tiene permisos especiales
$tienePermisoEspecial = false;

if($_SESSION["perfil"] == "Administrador" ||
   $_SESSION["id_coordinacion"] == "9" ||      // Centro de Atencion
   $_SESSION["id_coordinacion"] == "12" ||     // Archivo
   $_SESSION["usuario"] == "agamardo") {       // Angie
    
    $tienePermisoEspecial = true;
}

// Si tiene permiso especial, puede entrar incluso si no hay coordinación asignada
if($tienePermisoEspecial){
    $countidcoordinacion = "1";  // Forzamos que tenga acceso
} else {
    // Si no tiene permiso especial, aplicamos la lógica normal
    if(!$tieneCoincidencia){
        $countidcoordinacion = "0";
    }
}

if($countidcoordinacion == "0"){   
    echo '<script>
        window.location = "inicio";
    </script>';
    return;
}

// =====================================================
// OBTENER TODOS LOS DATOS DEL TICKET DIRECTAMENTE CON SQL
// =====================================================

// Conectar a la base de datos
$db = Conexion::conectar();

// 1. Obtener TODAS las coordinaciones asignadas al ticket
$coordinacionesLista = [];
$stmt = $db->prepare("SELECT c.id, c.coordinacion 
                       FROM ticketcoordinacion tc 
                       INNER JOIN coordinacion c ON tc.id_coordinacion = c.id 
                       WHERE tc.id_ticket = :id_ticket");
$stmt->bindParam(":id_ticket", $ticketInfo["id"], PDO::PARAM_INT);
$stmt->execute();
$coordinacionesResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($coordinacionesResult as $row) {
    $coordinacionesLista[] = $row["coordinacion"];
}

// 2. Obtener TODOS los usuarios asignados al ticket
$usuariosLista = [];
$stmt = $db->prepare("SELECT u.id, u.nombre, u.apellido 
                       FROM ticketusuario tu 
                       INNER JOIN usuarios u ON tu.id_usuario = u.id 
                       WHERE tu.id_ticket = :id_ticket");
$stmt->bindParam(":id_ticket", $ticketInfo["id"], PDO::PARAM_INT);
$stmt->execute();
$usuariosResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($usuariosResult as $row) {
    $usuariosLista[] = $row["nombre"] . " " . $row["apellido"];
}

// 3. Obtener TODOS los servicios del ticket
$serviciosLista = [];
$stmt = $db->prepare("SELECT ts.id_servicios, ts.id_item, ts.descripcion, ts.cantidad,
                             s.servicios as nombre_servicio,
                             i.item as nombre_item
                       FROM ticketservicios ts
                       INNER JOIN servicios s ON ts.id_servicios = s.id
                       INNER JOIN item i ON ts.id_item = i.id
                       WHERE ts.id_ticket = :id_ticket");
$stmt->bindParam(":id_ticket", $ticketInfo["id"], PDO::PARAM_INT);
$stmt->execute();
$serviciosResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($serviciosResult as $row) {
    $serviciosLista[] = [
        "servicio" => $row["nombre_servicio"],
        "item" => $row["nombre_item"],
        "descripcion" => $row["descripcion"],
        "cantidad" => $row["cantidad"]
    ];
}

// 4. Obtener TODOS los documentos del ticket
$documentosLista = [];
$stmt = $db->prepare("SELECT documento FROM documento WHERE id_ticket = :id_ticket");
$stmt->bindParam(":id_ticket", $ticketInfo["id"], PDO::PARAM_INT);
$stmt->execute();
$documentosResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($documentosResult as $row) {
    $documentosLista[] = $row["documento"];
}

// 5. Obtener datos del ente
$nombreEnte = "";
$stmt = $db->prepare("SELECT entes FROM entes WHERE id = :id");
$stmt->bindParam(":id", $ticketInfo["id_ente"], PDO::PARAM_INT);
$stmt->execute();
$enteResult = $stmt->fetch(PDO::FETCH_ASSOC);
$nombreEnte = $enteResult ? $enteResult["entes"] : "No especificado";

// 6. Obtener datos del medio
$nombreMedio = "";
$stmt = $db->prepare("SELECT medio FROM medio WHERE id = :id");
$stmt->bindParam(":id", $ticketInfo["id_medio"], PDO::PARAM_INT);
$stmt->execute();
$medioResult = $stmt->fetch(PDO::FETCH_ASSOC);
$nombreMedio = $medioResult ? $medioResult["medio"] : "No especificado";

// 7. Obtener datos de prioridad
$prioridadNombre = "";
$prioridadColor = "";
$stmt = $db->prepare("SELECT prioridad, color FROM prioridad WHERE id = :id");
$stmt->bindParam(":id", $ticketInfo["id_prioridad"], PDO::PARAM_INT);
$stmt->execute();
$prioridadResult = $stmt->fetch(PDO::FETCH_ASSOC);
if ($prioridadResult) {
    $prioridadNombre = $prioridadResult["prioridad"];
    $prioridadColor = $prioridadResult["color"];
}

// 8. Obtener nombre del usuario creador
$nombreCreador = "";
$stmt = $db->prepare("SELECT nombre, apellido FROM usuarios WHERE id = :id");
$stmt->bindParam(":id", $ticketInfo["id_usuario"], PDO::PARAM_INT);
$stmt->execute();
$creadorResult = $stmt->fetch(PDO::FETCH_ASSOC);
$nombreCreador = $creadorResult ? $creadorResult["nombre"] . " " . $creadorResult["apellido"] : "No especificado";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tablero
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="tickets"><i class="fa fa-dashboard"></i> Administrar Tickets</a></li>
        <li class="active">Tablero</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">

          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-globe"></i> Ticket. #<?php echo $ticketInfo["id"];?>
                <small class="pull-right">
                <?php
                    date_default_timezone_set('America/Caracas');
                    echo "Fecha: " . date("j/n/Y");
                ?>
                </small>
              </h2>

            </div>
          </div>

          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
            <address>
              <strong>Dependencia :  </strong><?php echo $nombreEnte; ?>
              <br><strong>Solicitante :  </strong><?php echo $ticketInfo["solicitante"]; ?>
              <br><strong>Descripcion :  </strong><?php echo $ticketInfo["descripcion"]; ?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <address>
            <strong>Medio :  </strong><?php echo $nombreMedio;?>
            <br><strong>Prioridad :  </strong><?php 
                  echo '<span class="btn btn-xs" style="color: white; background-color: ' . $prioridadColor . ';">' . $prioridadNombre . '</span>';
                  ?>
            <br><strong> Usuario creador :  </strong><?php echo $nombreCreador; ?>  
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Ultima Modificacion : </b><?php echo $ticketInfo["modificacion"];?><br>
          <b>Fecha de Creacion : </b><?php echo $ticketInfo["fecha"];?><br>
            
            <?php 
              if($ticketInfo["finalizado"] == "si"){
                echo '<span class="btn btn-xs btn-success">Finalizado</span>';
              } else {
                echo '<span class="btn btn-xs btn-warning">No Finalizado</span>';
              }
            ?>
          
            <?php
                if($_SESSION["perfil"] == "Administrador" || $_SESSION["id_coordinacion"] == "9"){
                  echo '<button class="btn btn-xs btn-warning btnEditarTicket" data-toggle="modal" data-target="#modalEditarTicket2"><i class="fa fa-pencil"></i></button>';
                }
            ?>

            <!-- Botón Compartir WhatsApp original (resumen básico) -->
            <?php if($_SESSION["perfil"] == "Administrador" || $_SESSION["id_coordinacion"] == "9"): ?>
            <button class="btn btn-xs btn-success" id="btnCompartirWhatsApp" 
                    data-id="<?php echo $ticketInfo['id']; ?>"
                    data-solicitante="<?php echo htmlspecialchars($ticketInfo['solicitante']); ?>"
                    data-ente="<?php echo htmlspecialchars($nombreEnte); ?>"
                    data-descripcion="<?php echo htmlspecialchars($ticketInfo['descripcion']); ?>"
                    data-prioridad="<?php echo htmlspecialchars($prioridadNombre); ?>"
                    data-creador="<?php echo htmlspecialchars($nombreCreador); ?>"
                    data-fecha-creacion="<?php echo $ticketInfo['fecha']; ?>"
                    data-modificacion="<?php echo $ticketInfo['modificacion']; ?>"
                    style="margin-left: 10px;">
                <i class="fa fa-whatsapp"></i> Compartir
            </button>
            <?php endif; ?>



        </div>
        <!-- /.col -->
      </div>
    </div>
  </div>

<?php
      include "ticket/adjunto.php";
      include "ticket/coordinacion.php";
      include "ticket/usuario.php";
      include "ticket/status.php";
      include "ticket/servicios.php";
      include "ticket/evidencia.php";
?>

<!-- Incluir el modal de edición -->
<?php include "modal/EditarTicket2.php"; ?>

<?php if($ticketInfo["finalizado"] == "si") { ?>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"> 
      <a href="vistas/modulos/generar_pdf_ticket.php?id=<?php echo $ticketInfo['id']; ?>" target="_blank" class="btn btn-danger">
        <i class="fa fa-file-pdf-o"></i> Generar Reporte PDF
      </a>
      
      <button class="btn btn-ls btn-success" id="btnWhatsAppCompleto" style="margin-left: 5px;"><i class="fa fa-whatsapp"></i> Informe Completo</button>

    </h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
</div>
<?php } ?>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script>

// Función para enviar el INFORME COMPLETO por WhatsApp (con TODOS los usuarios, coordinaciones y servicios)
$(document).on("click", "#btnWhatsAppCompleto", function(e) {
    e.preventDefault();
    
    // Datos directamente desde PHP (convertidos a JSON con TODOS los elementos)
    var datos = {
        id: <?php echo json_encode($ticketInfo["id"]); ?>,
        ente: <?php echo json_encode($nombreEnte); ?>,
        solicitante: <?php echo json_encode($ticketInfo["solicitante"]); ?>,
        descripcion: <?php echo json_encode($ticketInfo["descripcion"]); ?>,
        medio: <?php echo json_encode($nombreMedio); ?>,
        prioridad: <?php echo json_encode($prioridadNombre); ?>,
        creador: <?php echo json_encode($nombreCreador); ?>,
        fecha: <?php echo json_encode($ticketInfo["fecha"]); ?>,
        modificacion: <?php echo json_encode($ticketInfo["modificacion"]); ?>,
        finalizado: <?php echo json_encode($ticketInfo["finalizado"]); ?>,
        coordinaciones: <?php echo json_encode($coordinacionesLista); ?>,
        usuarios: <?php echo json_encode($usuariosLista); ?>,
        servicios: <?php echo json_encode($serviciosLista); ?>,
        documentos: <?php echo json_encode($documentosLista); ?>
    };
    
    console.log("Datos a enviar:", datos); // Para depuración
    
    // Construir el mensaje completo
    var mensaje = "📋 *INFORME COMPLETO DE SERVICIO TÉCNICO - AIT*\n";
    mensaje += "━━━━━━━━━━━━━\n\n";
    mensaje += "🆔 *Ticket:* #" + datos.id + "\n";
    mensaje += "🏢 *Dependencia:* " + datos.ente + "\n";
    mensaje += "👤 *Solicitante:* " + datos.solicitante + "\n";
    mensaje += "📝 *Descripción:*\n" + datos.descripcion + "\n\n";
    mensaje += "📡 *Medio:* " + datos.medio + "\n";
    mensaje += "⚡ *Prioridad:* " + datos.prioridad + "\n";
    mensaje += "👨‍💻 *Creado por:* " + datos.creador + "\n";
    mensaje += "📅 *Fecha de Creación:* " + datos.fecha + "\n";
    mensaje += "🕒 *Última Modificación:* " + datos.modificacion + "\n";
    mensaje += "✅ *Estado:* " + (datos.finalizado == "si" ? "FINALIZADO" : "PENDIENTE") + "\n\n";
    
    // Agregar COORDINACIONES (TODAS)
    if (datos.coordinaciones && datos.coordinaciones.length > 0) {
        mensaje += "👥 *COORDINACION ASIGNADA:*\n";
        for (var i = 0; i < datos.coordinaciones.length; i++) {
            mensaje += "   • " + datos.coordinaciones[i] + "\n";
        }
        mensaje += "\n";
    } else {
        mensaje += "👥 *COORDINACION ASIGNADA:*\n   • Ninguna\n\n";
    }
    
    // Agregar USUARIOS (TODOS)
    if (datos.usuarios && datos.usuarios.length > 0) {
        mensaje += "👥 *ESPECIALISTAS ASIGNADOS:*\n";
        for (var i = 0; i < datos.usuarios.length; i++) {
            mensaje += "   • " + datos.usuarios[i] + "\n";
        }
        mensaje += "\n";
    } else {
        mensaje += "👥 *ESPECIALISTAS ASIGNADOS:*\n   • Ninguno\n\n";
    }
    
    // Agregar SERVICIOS (TODOS)
    if (datos.servicios && datos.servicios.length > 0) {
        mensaje += "🔧 *SERVICIOS Y DETALLES:*\n";
        mensaje += "━━━━━━━━━━━━━\n";
        for (var i = 0; i < datos.servicios.length; i++) {
            var serv = datos.servicios[i];
            mensaje += "\n   📌 *" + serv.servicio + " - " + serv.item + "*\n";
            mensaje += "      📦 Cantidad: " + serv.cantidad + "\n";
            mensaje += "      📄 Descripción: " + serv.descripcion + "\n";
        }

    } else {
        mensaje += "🔧 *SERVICIOS Y DETALLES:*\n   • Ningún servicio registrado\n\n";
    }
    
    // Agregar DOCUMENTOS (si hay)
    if (datos.documentos && datos.documentos.length > 0) {
        mensaje += "📄 *DOCUMENTOS ASOCIADOS:*\n";
        mensaje += "\n━━━━━━━━━━━━━\n\n";
        for (var i = 0; i < datos.documentos.length; i++) {
            mensaje += "   • " + datos.documentos[i] + "\n";
        }
        mensaje += "\n";
    }
    
    mensaje += "━━━━━━━━━━━━━\n";
    mensaje += "📌 *Este informe es generado automáticamente por el Sistema de Gestión de Tickets AIT.*\n";
    mensaje += "🔗 *Ticket en línea:* " + window.location.href;
    
    // Codificar mensaje para URL
    var mensajeCodificado = encodeURIComponent(mensaje);
    
    // Detectar si es dispositivo móvil
    var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    // Construir URL de WhatsApp
    var whatsappUrl = isMobile 
        ? "https://api.whatsapp.com/send?text=" + mensajeCodificado
        : "https://web.whatsapp.com/send?text=" + mensajeCodificado;
    
    console.log("Abriendo WhatsApp con mensaje de " + mensaje.length + " caracteres");
    
    // Abrir WhatsApp en una nueva pestaña
    window.open(whatsappUrl, "_blank");
});
</script>

<?php
  $borrar = new ControladorTicketcoordinacion();
  $borrar -> ctrBorrarTicketcoordinacion();

  $borrarUsuario = new ControladorTicketusuario();
  $borrarUsuario -> ctrBorrarTicketusuario();

  $borrarStatus = new ControladorTicketstatus();
  $borrarStatus -> ctrBorrarTicketstatus();

  $borrarServicios = new ControladorTicketservicios();
  $borrarServicios -> ctrBorrarTicketservicios();

  $borrarEvidencia = new ControladorTicketevidencia();
  $borrarEvidencia -> ctrBorrarTicketevidencia();
?> 