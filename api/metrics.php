<?php
// Forzar la salida en texto plano limpia para Prometheus
header("Content-Type: text/plain; charset=utf-8");

// 1. Capturar y destruir cualquier echo o warning del archivo de base de datos original
ob_start();
require_once __DIR__ . '/../config/database.php';
ob_end_clean();

// 2. Forzar reconexión con las credenciales explícitas del contenedor de Docker
try {
    $es_contenedor = (getenv('KUBERNETES_SERVICE_HOST') || file_exists('/.dockerenv'));
    
    $host_env = $es_contenedor ? 'mysql' : '127.0.0.1';
    $port_env = $es_contenedor ? '3306' : '3307'; 
    
    $db_name  = 'control_asistencias_qr';
    $db_user  = 'root';
    $db_pass  = $es_contenedor ? 'root' : 'juan123'; 

    $conexion = new PDO("mysql:host=$host_env;port=$port_env;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    try {
        $db_pass_alt = $es_contenedor ? 'juan123' : 'root';
        $conexion = new PDO("mysql:host=$host_env;port=$port_env;dbname=$db_name;charset=utf8", $db_user, $db_pass_alt);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e2) {
        http_response_code(500);
        echo "qr_attendance_system_up 0\n";
        echo "# ERROR DE CONEXIÓN ABSOLUTO: " . $e2->getMessage() . "\n";
        exit;
    }
}

// 3. Ejecución de consultas utilizando tu estructura exacta de la base de datos
try {
    // Consultas utilizando tus tablas en español confirmadas
    $employees     = $conexion->query("SELECT COUNT(*) FROM empleados")->fetchColumn();
    $attendance    = $conexion->query("SELECT COUNT(*) FROM asistencias")->fetchColumn();
    $companies     = $conexion->query("SELECT COUNT(*) FROM empresas")->fetchColumn();
    $notifications = $conexion->query("SELECT COUNT(*) FROM notificaciones")->fetchColumn(); // <-- LÍNEA NUEVA 1
    
    // Consulta exacta usando tu columna 'retardo'
    $late = $conexion->query("SELECT COUNT(*) FROM asistencias WHERE retardo = 1")->fetchColumn();

    // Impresión con formato oficial de Prometheus limpio y correcto
    echo "employees_total " . (int)$employees . "\n";
    echo "attendance_total " . (int)$attendance . "\n";
    echo "late_arrivals_total " . (int)$late . "\n";
    echo "companies_total " . (int)$companies . "\n";
    echo "notifications_total " . (int)$notifications . "\n"; // <-- LÍNEA NUEVA 2
    echo "qr_attendance_system_up 1\n";

} catch (PDOException $e) {
    http_response_code(500);
    echo "qr_attendance_system_up 0\n";
    echo "# ERROR AL CONSULTAR TABLAS: " . $e->getMessage() . "\n";
}
