<?php
// Archivo: vistas/modulos/generar_pdf_ticket.php
// Generador de PDF independiente

// Configurar la ruta base
$rootPath = dirname(__FILE__) . '/../../';

// Incluir la conexión a la base de datos
require_once $rootPath . 'modelos/conexion.php';

// Incluir FPDF
require_once $rootPath . 'vistas/fpdf/fpdf.php';

// Iniciar sesión para verificar permisos
session_start();

// Limpiar cualquier salida previa
ob_clean();

// Definir la URL base del proyecto
$baseUrl = '/';

// Obtener el ID del ticket
$idTicket = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Función para mostrar alerta y redirigir
function mostrarAlertaYRedirigir($icono, $titulo, $mensaje, $url) {
    // Limpiar cualquier salida previa
    ob_clean();
    
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: "' . $icono . '",
                title: "' . $titulo . '",
                text: "' . $mensaje . '",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "' . $url . '";
                } else {
                    window.location.href = "' . $url . '";
                }
            });
        </script>
    </body>
    </html>';
    exit();
}

// Validación 1: ID válido
if ($idTicket == 0) {
    mostrarAlertaYRedirigir("error", "ID Inválido", "El ID del ticket no es válido", $baseUrl);
}

// ==================== FUNCIONES AUXILIARES ====================

function conectarDB() {
    return Conexion::conectar();
}

function obtenerDatosTicket($idTicket) {
    try {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT * FROM ticket WHERE id = :id");
        $stmt->bindParam(":id", $idTicket, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return null;
    }
}

function obtenerCoordinacionesDelTicket($idTicket) {
    $coordinaciones = [];
    try {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT id_coordinacion FROM ticketcoordinacion WHERE id_ticket = :id_ticket");
        $stmt->bindParam(":id_ticket", $idTicket, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($results as $row) {
            $coordinaciones[] = $row['id_coordinacion'];
        }
    } catch (Exception $e) {
        // Ignorar errores
    }
    return $coordinaciones;
}

// ==================== VERIFICAR PERMISOS ====================

$ticketInfo = obtenerDatosTicket($idTicket);

// Validación 2: Ticket existe
if (!$ticketInfo) {
    mostrarAlertaYRedirigir("error", "Ticket No Encontrado", "El ticket que intentas acceder no existe", $baseUrl);
}

// Validación 3: Ticket debe estar finalizado
if ($ticketInfo['finalizado'] == 'no') {
    mostrarAlertaYRedirigir("error", "Ticket No Finalizado", "Si el ticket no esta finalizado no puede generar PDF", $baseUrl);
}

// Validación 4: Verificar permisos de usuario
$coordinacionesTicket = obtenerCoordinacionesDelTicket($idTicket);
$tienePermiso = false;

if (isset($_SESSION["perfil"]) && $_SESSION["perfil"] == "Administrador") {
    $tienePermiso = true;
}

if (isset($_SESSION["id_coordinacion"]) && $_SESSION["id_coordinacion"] == "9") {
    $tienePermiso = true;
}

if (isset($_SESSION["id_coordinacion"]) && in_array($_SESSION["id_coordinacion"], $coordinacionesTicket)) {
    $tienePermiso = true;
}
elseif (isset($_SESSION["id_apoyo"]) && in_array($_SESSION["id_apoyo"], $coordinacionesTicket)) {
    $tienePermiso = true;
}

if (!$tienePermiso) {
    mostrarAlertaYRedirigir("warning", "Acceso Denegado", "No tienes permisos para acceder a este ticket", $baseUrl);
}

// ==================== OBTENER DATOS ADICIONALES ====================

function obtenerNombreEnte($idEnte) {
    try {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT entes FROM entes WHERE id = :id");
        $stmt->bindParam(":id", $idEnte, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['entes'] : 'No especificado';
    } catch (Exception $e) {
        return 'No especificado';
    }
}

function obtenerNombreMedio($idMedio) {
    try {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT medio FROM medio WHERE id = :id");
        $stmt->bindParam(":id", $idMedio, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['medio'] : 'No especificado';
    } catch (Exception $e) {
        return 'No especificado';
    }
}

function obtenerDatosPrioridad($idPrioridad) {
    try {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT prioridad, color FROM prioridad WHERE id = :id");
        $stmt->bindParam(":id", $idPrioridad, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : ['prioridad' => 'No especificado', 'color' => '#000000'];
    } catch (Exception $e) {
        return ['prioridad' => 'No especificado', 'color' => '#000000'];
    }
}

function obtenerUltimoStatusTicket($idTicket) {
    try {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT id_status FROM ticketstatus WHERE id_ticket = :id_ticket ORDER BY id DESC LIMIT 1");
        $stmt->bindParam(":id_ticket", $idTicket, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $stmt2 = $db->prepare("SELECT status, color FROM status WHERE id = :id");
            $stmt2->bindParam(":id", $result['id_status'], PDO::PARAM_INT);
            $stmt2->execute();
            $status = $stmt2->fetch(PDO::FETCH_ASSOC);
            return $status ? $status : ['status' => 'Pendiente', 'color' => '#f0ad4e'];
        }
        return ['status' => 'Pendiente', 'color' => '#f0ad4e'];
    } catch (Exception $e) {
        return ['status' => 'Pendiente', 'color' => '#f0ad4e'];
    }
}

function obtenerNombreUsuario($idUsuario) {
    try {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT nombre, apellido FROM usuarios WHERE id = :id");
        $stmt->bindParam(":id", $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['nombre'] . ' ' . $result['apellido'] : 'No especificado';
    } catch (Exception $e) {
        return 'No especificado';
    }
}

function obtenerCoordinacionesTicket($idTicket) {
    $coordinaciones = [];
    try {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT id_coordinacion FROM ticketcoordinacion WHERE id_ticket = :id_ticket");
        $stmt->bindParam(":id_ticket", $idTicket, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($results as $row) {
            $stmt2 = $db->prepare("SELECT coordinacion FROM coordinacion WHERE id = :id");
            $stmt2->bindParam(":id", $row['id_coordinacion'], PDO::PARAM_INT);
            $stmt2->execute();
            $coord = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ($coord) {
                $coordinaciones[] = $coord['coordinacion'];
            }
        }
    } catch (Exception $e) {
        // Ignorar errores
    }
    return $coordinaciones;
}

function obtenerUsuariosTicket($idTicket) {
    $usuarios = [];
    try {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT id_usuario FROM ticketusuario WHERE id_ticket = :id_ticket");
        $stmt->bindParam(":id_ticket", $idTicket, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($results as $row) {
            $stmt2 = $db->prepare("SELECT nombre, apellido FROM usuarios WHERE id = :id");
            $stmt2->bindParam(":id", $row['id_usuario'], PDO::PARAM_INT);
            $stmt2->execute();
            $user = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                $usuarios[] = $user['nombre'] . ' ' . $user['apellido'];
            }
        }
    } catch (Exception $e) {
        // Ignorar errores
    }
    return $usuarios;
}

function obtenerServiciosTicket($idTicket) {
    $servicios = [];
    try {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT id_servicios, id_item, descripcion, cantidad FROM ticketservicios WHERE id_ticket = :id_ticket");
        $stmt->bindParam(":id_ticket", $idTicket, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($results as $row) {
            $stmt2 = $db->prepare("SELECT servicios FROM servicios WHERE id = :id");
            $stmt2->bindParam(":id", $row['id_servicios'], PDO::PARAM_INT);
            $stmt2->execute();
            $serv = $stmt2->fetch(PDO::FETCH_ASSOC);
            
            $stmt3 = $db->prepare("SELECT item FROM item WHERE id = :id");
            $stmt3->bindParam(":id", $row['id_item'], PDO::PARAM_INT);
            $stmt3->execute();
            $item = $stmt3->fetch(PDO::FETCH_ASSOC);
            
            $servicios[] = [
                'servicio' => $serv ? $serv['servicios'] : 'No especificado',
                'item' => $item ? $item['item'] : 'No especificado',
                'descripcion' => $row['descripcion'],
                'cantidad' => $row['cantidad']
            ];
        }
    } catch (Exception $e) {
        // Ignorar errores
    }
    return $servicios;
}

function obtenerDocumentosTicket($idTicket) {
    $documentos = [];
    try {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT * FROM documento WHERE id_ticket = :id_ticket");
        $stmt->bindParam(":id_ticket", $idTicket, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($results as $row) {
            $stmt2 = $db->prepare("SELECT tipodocs FROM tipodocs WHERE id = :id");
            $stmt2->bindParam(":id", $row['id_tipodocs'], PDO::PARAM_INT);
            $stmt2->execute();
            $tipo = $stmt2->fetch(PDO::FETCH_ASSOC);
            
            $documentos[] = [
                'documento' => $row['documento'],
                'tipo' => $tipo ? $tipo['tipodocs'] : 'No especificado',
                'fecha' => $row['fecha'],
                'emision' => $row['emision'],
                'remitente' => $row['remitente'],
                'destinatario' => $row['destinatario'],
                'asunto' => $row['asunto']
            ];
        }
    } catch (Exception $e) {
        // Ignorar errores
    }
    return $documentos;
}

function obtenerEvidenciasTicket($idTicket) {
    $evidencias = [];
    try {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT id, ticketevidencia, fecha_subida FROM ticketevidencia WHERE id_ticket = :id_ticket ORDER BY id ASC");
        $stmt->bindParam(":id_ticket", $idTicket, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($results as $row) {
            $evidencias[] = [
                'id' => $row['id'],
                'ruta' => $row['ticketevidencia'],
                'fecha_subida' => $row['fecha_subida']
            ];
        }
    } catch (Exception $e) {
        // Ignorar errores
    }
    return $evidencias;
}

$nombreEnte = obtenerNombreEnte($ticketInfo['id_ente']);
$nombreMedio = obtenerNombreMedio($ticketInfo['id_medio']);
$datosPrioridad = obtenerDatosPrioridad($ticketInfo['id_prioridad']);
$datosStatus = obtenerUltimoStatusTicket($idTicket);
$coordinaciones = obtenerCoordinacionesTicket($idTicket);
$usuarios = obtenerUsuariosTicket($idTicket);
$servicios = obtenerServiciosTicket($idTicket);
$documentos = obtenerDocumentosTicket($idTicket);
$evidencias = obtenerEvidenciasTicket($idTicket);
$nombreUsuarioCreador = obtenerNombreUsuario($ticketInfo['id_usuario']);

function obtenerPrimerUsuarioAsignado($idTicket) {
    try {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT id_usuario FROM ticketusuario WHERE id_ticket = :id_ticket ORDER BY id ASC LIMIT 1");
        $stmt->bindParam(":id_ticket", $idTicket, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return obtenerNombreUsuario($result['id_usuario']);
        }
        return '_____________________';
    } catch (Exception $e) {
        return '_____________________';
    }
}

$primerUsuarioAsignado = obtenerPrimerUsuarioAsignado($idTicket);

// ==================== CLASE PDF PERSONALIZADA ====================

class PDF_Ticket extends FPDF {
    private $rutaImagen;
    private $primerUsuario;
    public $numeroTicket;
    
    const MARGEN_SUPERIOR = 20;
    const MARGEN_INFERIOR = 30;
    const MARGEN_IZQUIERDO = 25;
    const MARGEN_DERECHO = 25;
    
    function __construct($primerUsuario = '') {
        parent::__construct('P', 'mm', 'Letter');
        $this->SetMargins(self::MARGEN_IZQUIERDO, self::MARGEN_SUPERIOR, self::MARGEN_DERECHO);
        $this->SetAutoPageBreak(true, self::MARGEN_INFERIOR);
        $this->primerUsuario = $primerUsuario;
        $this->numeroTicket = '';
    }
    
    function setPrimerUsuario($primerUsuario) {
        $this->primerUsuario = $primerUsuario;
    }

    function Header() {
        if ($this->PageNo() == 1) {
            $rutaImagen = dirname(__FILE__) . '/../img/plantilla/icono-negro.png';
            if (file_exists($rutaImagen)) {
                $this->Image($rutaImagen, self::MARGEN_IZQUIERDO, self::MARGEN_SUPERIOR - 15, 30);
            }
            
            $this->SetY(self::MARGEN_SUPERIOR);
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(0, 10, utf8_decode('Sistema de Gestion de Tickets - AIT'), 0, 1, 'C');
            $this->SetFont('Arial', '', 11);
            $this->Cell(0, 6, utf8_decode('Direccion de Automatizacion, Informatica y Telecomunicaciones'), 0, 1, 'C');
            $this->Cell(0, 6, utf8_decode('Gobernacion del Estado Anzoategui'), 0, 1, 'C');
            
            $this->Ln(5);
            $rutaImagenPrincipal = dirname(__FILE__) . '/../img/plantilla/logo-blanco-pdf.png';
            if (file_exists($rutaImagenPrincipal)) {
                $anchoImagen = 35;
                $xCentro = ($this->GetPageWidth() - $anchoImagen) / 2;
                $this->Image($rutaImagenPrincipal, $xCentro, $this->GetY(), $anchoImagen);
                $this->SetY($this->GetY() + 30);
            } else {
                $this->Ln(10);
            }
            $this->Ln(1);
        }
    }

    function Footer() {
        $this->SetY(-self::MARGEN_INFERIOR + 10);
        $this->SetFont('Arial', 'I', 8);
        if (!empty($this->numeroTicket)) {
            $this->Cell(0, 10, utf8_decode('Ticket #' . $this->numeroTicket . ' - Página ') . $this->PageNo(), 0, 0, 'C');
        } else {
            $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
        }
    }
    
    function agregarTablaFirmas() {
        $alturaRequerida = 70;
        $posicionActualY = $this->GetY();
        $restoPagina = $this->GetPageHeight() - $posicionActualY - self::MARGEN_INFERIOR;
        
        if ($restoPagina < $alturaRequerida) {
            $this->AddPage();
        }
        
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('VALIDACIONES DEL SERVICIO'), 0, 1, 'C');
        $this->Ln(1);
        
        $this->SetFont('Arial', 'B', 11);
        
        $anchoDisponible = $this->GetPageWidth() - self::MARGEN_IZQUIERDO - self::MARGEN_DERECHO;
        $anchoColumna = $anchoDisponible / 3;
        
        $this->SetFillColor(240, 240, 240);
        $this->Cell($anchoColumna, 10, utf8_decode('ELABORADO POR'), 1, 0, 'C', true);
        $this->Cell($anchoColumna, 10, utf8_decode('REVISADO POR'), 1, 0, 'C', true);
        $this->Cell($anchoColumna, 10, utf8_decode('APROBADO POR'), 1, 1, 'C', true);
        
        $this->SetFont('Arial', '', 9);
        $this->Cell($anchoColumna, 25, '', 1, 0, 'C');
        $this->Cell($anchoColumna, 25, '', 1, 0, 'C');
        $this->Cell($anchoColumna, 25, '', 1, 1, 'C');
        
        $this->SetFont('Arial', '', 10);
        $this->Cell($anchoColumna, 10, utf8_decode($this->primerUsuario), 1, 0, 'C');
        $this->Cell($anchoColumna, 10, utf8_decode('T.S.U. Miguel Garcia'), 1, 0, 'C');
        $this->Cell($anchoColumna, 10, utf8_decode('Ing. Carlos Adueza'), 1, 1, 'C');
    }
    
    function agregarEvidencias($evidencias) {
        if (empty($evidencias)) {
            return;
        }
        
        // Verificar espacio disponible
        $alturaRequerida = 100;
        $posicionActualY = $this->GetY();
        $restoPagina = $this->GetPageHeight() - $posicionActualY - self::MARGEN_INFERIOR;
        
        if ($restoPagina < $alturaRequerida) {
            $this->AddPage();
        }
        
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('EVIDENCIAS FOTOGRÁFICAS'), 0, 1, 'C');
        $this->Ln(5);
        
        // Obtener la ruta base correcta
        $basePath = dirname(__FILE__) . '/../../';
        
        // Calcular dimensiones - AJUSTA AQUÍ LAS DIMENSIONES FIJAS
        $anchoDisponible = $this->GetPageWidth() - self::MARGEN_IZQUIERDO - self::MARGEN_DERECHO;
        $anchoImagen = 75;  // ← Cambia este valor para ajustar el ancho (70-85mm recomendado)
        $altoImagen = 60;   // ← Cambia este valor para ajustar el alto (50-70mm recomendado)
        $espacioEntreImagenes = 15;
        
        // Mostrar título con la cantidad de imágenes
//        $this->SetFont('Arial', '', 10);
//        $this->Cell(0, 6, utf8_decode('Se encontraron ' . count($evidencias) . ' imagen(es) asociada(s) al ticket.'), 0, 1, 'C');
//        $this->Ln(8);
        
        // CASO: 2 imágenes (una al lado de la otra)
        if (count($evidencias) == 2) {
            $xInicial = self::MARGEN_IZQUIERDO;
            $yInicial = $this->GetY();
            
            // PRIMERA IMAGEN
            $rutaImagen1 = $basePath . $evidencias[0]['ruta'];
            
            // Texto ARRIBA de la primera imagen
//            $this->SetXY($xInicial, $yInicial);
//            $this->SetFont('Arial', 'B', 9);
//            $this->Cell($anchoImagen, 6, utf8_decode('Imagen 1'), 0, 1, 'C');
            
            // Imagen
            $yImagen = $this->GetY();
            if (file_exists($rutaImagen1)) {
                $this->Image($rutaImagen1, $xInicial, $yImagen, $anchoImagen, $altoImagen);
            } else {
                $this->SetXY($xInicial, $yImagen);
                $this->SetFont('Arial', '', 8);
                $this->Cell($anchoImagen, $altoImagen, utf8_decode('Imagen no encontrada'), 1, 0, 'C');
            }
            
            // Texto DEBAJO de la primera imagen
            $yTextoDebajo = $yImagen + $altoImagen + 3;
//            $this->SetXY($xInicial, $yTextoDebajo);
//            $this->SetFont('Arial', 'I', 8);
//            $this->Cell($anchoImagen, 5, utf8_decode('Subida: ' . $evidencias[0]['fecha_subida']), 0, 1, 'C');
            
            // SEGUNDA IMAGEN
            $xSegundaImagen = $xInicial + $anchoImagen + $espacioEntreImagenes;
            $rutaImagen2 = $basePath . $evidencias[1]['ruta'];
            
            // Texto ARRIBA de la segunda imagen
//            $this->SetXY($xSegundaImagen, $yInicial);
//            $this->SetFont('Arial', 'B', 9);
//            $this->Cell($anchoImagen, 6, utf8_decode('Imagen 2'), 0, 1, 'C');
            
            // Imagen
            if (file_exists($rutaImagen2)) {
                $this->Image($rutaImagen2, $xSegundaImagen, $yImagen, $anchoImagen, $altoImagen);
            } else {
                $this->SetXY($xSegundaImagen, $yImagen);
                $this->SetFont('Arial', '', 8);
                $this->Cell($anchoImagen, $altoImagen, utf8_decode('Imagen no encontrada'), 1, 0, 'C');
            }
            
            // Texto DEBAJO de la segunda imagen
//            $this->SetXY($xSegundaImagen, $yTextoDebajo);
//            $this->SetFont('Arial', 'I', 8);
//            $this->Cell($anchoImagen, 5, utf8_decode('Subida: ' . $evidencias[1]['fecha_subida']), 0, 1, 'C');
            
            // Avanzar Y después de ambas imágenes
            $this->SetY($yTextoDebajo + 2);
            
        } 
        // CASO: 1 imagen (centrada)
        else if (count($evidencias) == 1) {
            $xCentro = ($this->GetPageWidth() - $anchoImagen) / 2;
            $yInicial = $this->GetY();
            $rutaImagen = $basePath . $evidencias[0]['ruta'];
            
            // Texto ARRIBA de la imagen
//            $this->SetXY($xCentro, $yInicial);
//            $this->SetFont('Arial', 'B', 10);
//            $this->Cell($anchoImagen, 6, utf8_decode('Evidencia Fotográfica'), 0, 1, 'C');
            
            // Imagen
            $yImagen = $this->GetY();
            if (file_exists($rutaImagen)) {
                $this->Image($rutaImagen, $xCentro, $yImagen, $anchoImagen, $altoImagen);
            } else {
                $this->SetXY($xCentro, $yImagen);
                $this->SetFont('Arial', '', 8);
                $this->Cell($anchoImagen, $altoImagen, utf8_decode('Imagen no encontrada'), 1, 0, 'C');
            }
            
            // Texto DEBAJO de la imagen
            $yTextoDebajo = $yImagen + $altoImagen + 3;
//            $this->SetXY($xCentro, $yTextoDebajo);
//            $this->SetFont('Arial', 'I', 8);
//            $this->Cell($anchoImagen, 5, utf8_decode('Subida: ' . $evidencias[0]['fecha_subida']), 0, 1, 'C');
            
            // Avanzar Y después de la imagen
            $this->SetY($yTextoDebajo + 15);
        }
        // CASO: 3 o más imágenes (grid 2x2 máximo)
        else {
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 6, utf8_decode('Hay ' . count($evidencias) . ' imágenes disponibles. Mostrando las primeras 4:'), 0, 1, 'L');
            $this->Ln(5);
            
            // Mostrar máximo 4 imágenes en grid 2x2
            $maxImagenes = min(4, count($evidencias));
            $imagenesPorFila = 2;
            
            // Calcular espacio horizontal para centrar el grid si es necesario
            $anchoTotalGrid = ($anchoImagen * $imagenesPorFila) + ($espacioEntreImagenes * ($imagenesPorFila - 1));
            $xInicial = ($this->GetPageWidth() - $anchoTotalGrid) / 2;
            
            $yActual = $this->GetY();
            
            for ($i = 0; $i < $maxImagenes; $i++) {
                $columna = $i % $imagenesPorFila;
                $fila = floor($i / $imagenesPorFila);
                
                $x = $xInicial + ($columna * ($anchoImagen + $espacioEntreImagenes));
                $y = $yActual + ($fila * ($altoImagen + 20)); // 20 para textos
                
                $rutaImagen = $basePath . $evidencias[$i]['ruta'];
                
                // Texto arriba
                $this->SetXY($x, $y);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell($anchoImagen, 5, utf8_decode('Imagen ' . ($i+1)), 0, 1, 'C');
                
                // Imagen
                $yImagen = $y + 5;
                if (file_exists($rutaImagen)) {
                    $this->Image($rutaImagen, $x, $yImagen, $anchoImagen, $altoImagen);
                } else {
                    $this->SetXY($x, $yImagen);
                    $this->SetFont('Arial', '', 7);
                    $this->Cell($anchoImagen, $altoImagen, utf8_decode('No encontrada'), 1, 0, 'C');
                }
                
                // Texto debajo
                $this->SetXY($x, $yImagen + $altoImagen + 2);
                $this->SetFont('Arial', 'I', 7);
                $fechaCorta = substr($evidencias[$i]['fecha_subida'], 0, 10);
                $this->Cell($anchoImagen, 4, utf8_decode($fechaCorta), 0, 1, 'C');
            }
            
            $this->SetY($yActual + (ceil($maxImagenes / $imagenesPorFila) * ($altoImagen + 25)));
        }
        
        $this->Ln(5);
    }
    
    // Función para dibujar línea punteada
    function LineaPunteada($y, $x1 = null, $x2 = null) {
        if ($x1 === null) $x1 = self::MARGEN_IZQUIERDO;
        if ($x2 === null) $x2 = $this->GetPageWidth() - self::MARGEN_DERECHO;
        
        $this->SetDrawColor(150, 150, 150);
        $this->SetLineWidth(0.3);
        
        $espacio = 3; // Espacio entre puntos (mm)
        $longitud = $x2 - $x1;
        $numPuntos = floor($longitud / $espacio);
        
        for ($i = 0; $i <= $numPuntos; $i++) {
            $x = $x1 + ($i * $espacio);
            $this->Line($x, $y, $x + 1, $y);
        }
    }
}

// ==================== CREAR Y GENERAR PDF ====================

$pdf = new PDF_Ticket($primerUsuarioAsignado);
$pdf->numeroTicket = $ticketInfo['id'];
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Título
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, utf8_decode('INFORME DE SERVICIO TÉCNICO'), 0, 1, 'C');

// Fecha actual formateada
$pdf->SetFont('Arial', '', 10);
$fechaActual = date('d');
$mesActual = date('n');
$anioActual = date('Y');

$meses = array(
    1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
    5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
    9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
);

$fechaFormateada = 'Barcelona, ' . $fechaActual . ' de ' . $meses[$mesActual] . ' del ' . $anioActual;
$pdf->Cell(0, 6, utf8_decode($fechaFormateada), 0, 1, 'C');
$pdf->Ln(5);

// Datos del ticket
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 8, utf8_decode('Datos del Ticket #' . $ticketInfo['id']), 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);

$pdf->Cell(50, 6, utf8_decode('Dependencia:'), 0, 0, 'L');
$pdf->Cell(0, 6, utf8_decode($nombreEnte), 0, 1, 'L');

$pdf->Cell(50, 6, utf8_decode('Solicitante:'), 0, 0, 'L');
$pdf->Cell(0, 6, utf8_decode($ticketInfo['solicitante']), 0, 1, 'L');

$pdf->Cell(50, 6, utf8_decode('Descripción:'), 0, 0, 'L');
$pdf->MultiCell(0, 6, utf8_decode($ticketInfo['descripcion']), 0, 'L');

$pdf->Cell(50, 6, utf8_decode('Medio:'), 0, 0, 'L');
$pdf->Cell(0, 6, utf8_decode($nombreMedio), 0, 1, 'L');

$pdf->Cell(50, 6, utf8_decode('Fecha Creación:'), 0, 0, 'L');
$pdf->Cell(0, 6, $ticketInfo['fecha'], 0, 1, 'L');

$pdf->Cell(50, 6, utf8_decode('Creado por:'), 0, 0, 'L');
$pdf->Cell(0, 6, utf8_decode($nombreUsuarioCreador), 0, 1, 'L');

$pdf->Ln(5);

// Documentos
if (!empty($documentos)) {
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 8, utf8_decode('Documentos Adjuntos'), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    
    foreach ($documentos as $doc) {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, utf8_decode($doc['documento']), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln(3);
    }
    $pdf->Ln(5);
}

// Coordinaciones
if (!empty($coordinaciones)) {
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 8, utf8_decode('Coordinaciones Asignadas'), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    foreach ($coordinaciones as $coord) {
        $pdf->Cell(10, 6, '', 0, 0, 'L');
        $pdf->Cell(0, 6, utf8_decode('- ' . $coord), 0, 1, 'L');
    }
    $pdf->Ln(5);
}

// Usuarios
if (!empty($usuarios)) {
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 8, utf8_decode('Especialistas Asignados'), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    foreach ($usuarios as $user) {
        $pdf->Cell(10, 6, '', 0, 0, 'L');
        $pdf->Cell(0, 6, utf8_decode('- ' . $user), 0, 1, 'L');
    }
    $pdf->Ln(5);
}

// Servicios con líneas punteadas como separador
if (!empty($servicios)) {
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 8, utf8_decode('Servicios'), 0, 1, 'L');
    $pdf->Ln(2);
    
    $contadorServicios = count($servicios);
    $indice = 0;
    
    foreach ($servicios as $serv) {
        $indice++;
        
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, utf8_decode($serv['servicio'] . ' - ' . $serv['item']), 0, 1, 'L');
        
        $pdf->SetFont('Arial', 'I', 9);
        $pdf->Cell(30, 5, utf8_decode('Cantidad:'), 0, 0, 'R');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 5, $serv['cantidad'], 0, 1, 'L');
        
        $pdf->SetFont('Arial', 'I', 9);
        $pdf->Cell(30, 5, utf8_decode('Descripción:'), 0, 0, 'R');
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(0, 5, utf8_decode($serv['descripcion']), 0, 'L');
        
        // Dibujar línea punteada después de cada servicio (excepto después del último)
        if ($indice < $contadorServicios) {
            $yActual = $pdf->GetY();
            $pdf->LineaPunteada($yActual + 2);
            $pdf->Ln(4);
        } else {
            $pdf->Ln(3);
        }
    }
    $pdf->Ln(5);
}

// EVIDENCIAS (IMÁGENES)
if (!empty($evidencias)) {
    $pdf->agregarEvidencias($evidencias);
}

// Tabla de firmas
$pdf->agregarTablaFirmas();

// Generar PDF
$pdf->Output('I', 'Ticket_' . $idTicket . '.pdf');
?>