<?php
$es_contenedor = (getenv('KUBERNETES_SERVICE_HOST') || file_exists('/.dockerenv') || gethostname() === 'qr-attendance-app');

// Prioriza las variables de Render/Aiven en la nube. Si no existen, usa las locales.
$host     = getenv('DB_HOST')     ?: ($es_contenedor ? "mysql" : "127.0.0.1");
$port     = getenv('DB_PORT')     ?: ($es_contenedor ? "3306"  : "3307");
$user     = getenv('DB_USER')     ?: "root";
$password = getenv('DB_PASSWORD') ?: "root";
$dbname   = getenv('DB_NAME')     ?: "control_asistencias_qr";

try {
    $conexion = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",
        $user,
        $password
    );
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Mensaje de error claro y directo sin reintentos con contraseñas viejas
    $entorno = $es_contenedor ? "Docker (Host: $host, Port: $port)" : "Windows Local (Host: $host, Port: $port)";
    die("Error crítico de conexión en [ $entorno ]: " . $e->getMessage());
}
?>
