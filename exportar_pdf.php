<?php
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

try {
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT e.nombre, a.fecha, a.hora_entrada, a.hora_salida
            FROM asistencias a
            JOIN empleados e ON e.id = a.empleado_id";

    $data = $conexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    $excel = new Spreadsheet();
    $sheet = $excel->getActiveSheet();

    // Encabezados
    $sheet->setCellValue('A1', 'Empleado');
    $sheet->setCellValue('B1', 'Fecha');
    $sheet->setCellValue('C1', 'Entrada');
    $sheet->setCellValue('D1', 'Salida');

    $row = 2;
    foreach ($data as $d) {
        $sheet->setCellValue("A$row", $d['nombre']);
        $sheet->setCellValue("B$row", $d['fecha']);
        $sheet->setCellValue("C$row", $d['hora_entrada']);
        $sheet->setCellValue("D$row", $d['hora_salida']);
        $row++;
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="reporte_asistencias_' . date('Y-m-d') . '.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1'); // Necesario para IE sobre SSL
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Fecha en el pasado
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate'); 
    header('Pragma: public'); 

    $writer = new Xlsx($excel);
    $writer->save('php://output');
    exit();

} catch (Exception $e) {
    http_response_code(500);
    die("Error al generar el reporte: " . $e->getMessage());
}
