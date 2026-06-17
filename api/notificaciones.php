<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . "/../vendor/autoload.php";

require_once __DIR__ . "/../config/database.php";

use PDO;

$sql = "SELECT * FROM notificaciones 
        ORDER BY fecha DESC 
        LIMIT 5";

$stmt = $conexion->query($sql);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
