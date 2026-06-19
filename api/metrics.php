<?php
header("Content-Type: text/plain; charset=utf-8");

ob_start();
require_once __DIR__ . '/../config/database.php';
ob_end_clean();
$es_contenedor = file_exists('/.dockerenv') || (gethostname() === 'qr-attendance-app') || (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Prometheus') !== false);

$host_env = $es_contenedor ? 'mysql' : '127.0.0.1'; 
$port_env = $es_contenedor ? '3306'  : '3307';  
$db_name  = 'control_asistencias_qr';
$db_user  = 'root';
$db_pass  = 'root';  

try {
    $conexion = new PDO("mysql:host=$host_env;port=$port_env;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo "qr_attendance_system_up 0\n";
    echo "# ERROR DE CONEXION EN RED DOCKER: " . $e->getMessage() . "\n";
    exit;
}

try {
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $employees     = $conexion->query("SELECT COUNT(*) FROM empleados")->fetchColumn();
    $attendance    = $conexion->query("SELECT COUNT(*) FROM asistencias")->fetchColumn();
    $companies     = $conexion->query("SELECT COUNT(*) FROM empresas")->fetchColumn();
    $notifications = $conexion->query("SELECT COUNT(*) FROM notificaciones")->fetchColumn(); 
    $late          = $conexion->query("SELECT COUNT(*) FROM asistencias WHERE retardo = 1")->fetchColumn();

    echo "employees_total " . (int)$employees . "\n";
    echo "attendance_total " . (int)$attendance . "\n";
    echo "late_arrivals_total " . (int)$late . "\n";
    echo "companies_total " . (int)$companies . "\n";
    echo "notifications_total " . (int)$notifications . "\n"; 
    echo "qr_attendance_system_up 1\n";

} catch (PDOException $e) {
    http_response_code(500);
    echo "qr_attendance_system_up 0\n";
    echo "# ERROR AL CONSULTAR TABLAS: " . $e->getMessage() . "\n";
}
