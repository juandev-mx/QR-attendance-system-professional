<?php

require "config/database.php";
require "phpqrcode/qrlib.php";

$id_empleado = $_GET['id'];

$sql = "SELECT * FROM empleados WHERE id = :id";
$stmt = $conexion->prepare($sql);
$stmt->execute(['id'=>$id_empleado]);

$empleado = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$empleado){
    die("Empleado no encontrado");
}

if(empty($empleado['qr_token'])){

$token = bin2hex(random_bytes(32));

$sql="UPDATE empleados SET qr_token=:token WHERE id=:id";

$stmt=$conexion->prepare($sql);

$stmt->execute([
'token'=>$token,
'id'=>$empleado['id']
]);

}else{

$token=$empleado['qr_token'];

}

$contenidoQR=$token;

$archivo = "qr/".$empleado['numero_empleado'].".png";

QRcode::png($contenidoQR, $archivo, QR_ECLEVEL_L, 10);

echo "<h2>QR generado</h2>";
echo "<img src='$archivo'>";