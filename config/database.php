<?php
$es_contenedor = (getenv('KUBERNETES_SERVICE_HOST') || file_exists('/.dockerenv') || gethostname() === 'app');

$host = $es_contenedor ? "mysql" : "127.0.0.1";
$dbname = "control_asistencias_qr";
$user = "root";

$password = $es_contenedor ? "root" : "juan123"; 

try {
    $conexion = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $password
    );
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    if ($es_contenedor) {
        try {
            $conexion = new PDO("mysql:host=host.docker.internal;dbname=$dbname;charset=utf8", "root", "juan123");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e2) {
            die("Error de conexión crítica en Docker: " . $e2->getMessage());
        }
    } else {
        die("Error de conexión local en Windows: " . $e->getMessage());
    }
}
?>

