<?php

require "config/database.php";
require "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$sql="SELECT e.nombre,a.fecha,a.hora_entrada,a.hora_salida
FROM asistencias a
JOIN empleados e ON e.id=a.empleado_id";

$data=$conexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$excel=new Spreadsheet();
$sheet=$excel->getActiveSheet();

$sheet->setCellValue('A1','Empleado');
$sheet->setCellValue('B1','Fecha');
$sheet->setCellValue('C1','Entrada');
$sheet->setCellValue('D1','Salida');

$row=2;

foreach($data as $d){

$sheet->setCellValue("A$row",$d['nombre']);
$sheet->setCellValue("B$row",$d['fecha']);
$sheet->setCellValue("C$row",$d['hora_entrada']);
$sheet->setCellValue("D$row",$d['hora_salida']);

$row++;

}

$writer=new Xlsx($excel);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="asistencias.xlsx"');

$writer->save('php://output');