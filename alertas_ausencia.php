<?php
require "config/database.php";
require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$fecha = date("Y-m-d");

$sql = "SELECT nombre FROM empleados WHERE id NOT IN (SELECT empleado_id FROM asistencias WHERE fecha = :fecha)";
$stmt = $conexion->prepare($sql);
$stmt->execute(['fecha' => $fecha]);
$faltantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$faltantes) {
    die("No hay faltas registradas hoy. El sistema no enviará correo porque todos asistieron.");
}

$mail = new PHPMailer(true); 

try {
$mail->isSMTP();
$mail->Host='smtp.gmail.com';
$mail->SMTPAuth=true;
$mail->Username='correo@gmail.com';
$mail->Password='password';
$mail->SMTPSecure='tls';
$mail->Port=587;

$mail->setFrom('sistema@empresa.com', 'Sistema QR');
$mail->addAddress('rh@empresa.com');
    
    $mail->isHTML(false); 
    $mail->Subject = "Reporte de Faltas - " . $fecha;

    $mensaje = "Los siguientes empleados no registraron asistencia hoy:\n\n";
    foreach($faltantes as $f){
        $mensaje .= "- " . $f['nombre'] . "\n";
    }

    $mail->Body = $mensaje;

    if($mail->send()){
        echo "¡Correo enviado con éxito!";
    }

} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
