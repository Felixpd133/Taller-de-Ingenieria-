<?php
// Forzar a PHP a mostrar cualquier error en pantalla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar la sesión de forma global para controlar el acceso de usuarios
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = '127.0.0.1'; 
$db   = 'refugio_mascotas';
$user = 'root';
$pass = 'root'; 
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
     die("Error de conexión crítico: " . $e->getMessage());
}

/**
 * FUNCIÓN REUTILIZABLE PARA LA BITÁCORA (Requerimiento 7)
 * Registra automáticamente Fecha/Hora, Usuario, Tipo de evento, Detalle e IP.
 */
function registrarBitacora($pdo, $tipo, $detalle) {
    // 7.2 Nombre de Usuario (Si no ha iniciado sesión, ej: al registrarse o fallar login, es 'Invitado')
    $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Invitado';
    
    // 7.5 Obtener la IP del cliente/host
    $ip = $_SERVER['REMOTE_ADDR'];
    if ($ip === '::1') {
        $ip = '127.0.0.1'; // Normalizar la IP local de Codespaces/Localhost
    }

    try {
        $sql = "INSERT INTO bitacora (usuario, tipo, detalle, ip_host_cliente) 
                VALUES (:usuario, :tipo, :detalle, :ip)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':usuario' => $usuario,
            ':tipo'    => $tipo,
            ':detalle' => $detalle,
            ':ip'      => $ip
        ]);
    } catch (\PDOException $e) {
        // En caso de error, lo envía al log del servidor para no romper la app
        error_log("Error en bitácora: " . $e->getMessage());
    }
}
?>