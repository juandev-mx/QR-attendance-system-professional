<?php
// Detectar de forma precisa si el código corre dentro de Docker
$es_contenedor = (getenv('KUBERNETES_SERVICE_HOST') || file_exists('/.dockerenv') || gethostname() === 'qr-attendance-app');

// Configuración de variables según el entorno
$host     = $es_contenedor ? "mysql" : "127.0.0.1";
$dbname   = "control_asistencias_qr";
$user     = "root";
$password = $es_contenedor ? "root" : "root"; 
$port     = $es_contenedor ? "3306" : "3307"; // 3306 dentro de Docker, 3307 desde Windows externo

try {
    // Conexión principal unificada
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
