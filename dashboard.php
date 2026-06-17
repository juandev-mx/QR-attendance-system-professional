<?php
require "config/database.php";
require "auth/auth.php"; 

try {
    $total_empleados = $conexion->query("SELECT COUNT(*) FROM empleados")->fetchColumn();
    $asistencias_hoy = $conexion->query("SELECT COUNT(*) FROM asistencias WHERE fecha = CURDATE()")->fetchColumn();
    $retardos_hoy = $conexion->query("SELECT COUNT(*) FROM asistencias WHERE fecha = CURDATE() AND retardo = 1")->fetchColumn();
    $faltas = $conexion->query("SELECT COUNT(*) FROM empleados WHERE id NOT IN (SELECT empleado_id FROM asistencias WHERE fecha = CURDATE())")->fetchColumn();

    $sql_asistencias = "SELECT e.nombre, e.apellido_paterno, a.fecha, a.hora_entrada, a.hora_salida, a.retardo
            FROM asistencias a JOIN empleados e ON a.empleado_id = e.id
            ORDER BY a.fecha DESC, a.hora_entrada DESC LIMIT 10";
    $stmt = $conexion->query($sql_asistencias);

    $sql_grafica = "SELECT fecha, COUNT(*) as total FROM asistencias GROUP BY fecha ORDER BY fecha ASC LIMIT 7";
    $data_grafica = $conexion->query($sql_grafica)->fetchAll(PDO::FETCH_ASSOC);

    $sql_retardos = "SELECT fecha, COUNT(*) as total FROM asistencias WHERE retardo = 1 GROUP BY fecha ORDER BY fecha ASC LIMIT 7";
    $data_retardos = $conexion->query($sql_retardos)->fetchAll(PDO::FETCH_ASSOC);

    $sql_top = "SELECT e.nombre, COUNT(*) as asistencias FROM asistencias a JOIN empleados e ON a.empleado_id = e.id 
                WHERE a.retardo = 0 GROUP BY e.id ORDER BY asistencias DESC LIMIT 5";
    $top_puntuales = $conexion->query($sql_top)->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Analítico - Sistema QR</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: 0.3s; }
        .card:hover { transform: translateY(-5px); }
        .table-container { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); height: 100%; }
        .bg-gradient-warning { background: linear-gradient(45deg, #f39c12, #f1c40f); }
    </style>
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-4">📊 Panel Analítico de Asistencia</h2>

    <!-- FILA 1: TARJETAS DE MÉTRICAS -->
    <div class="row text-center mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white"><div class="card-body"><h6>Total Empleados</h6><h2><?php echo $total_empleados; ?></h2></div></div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white"><div class="card-body"><h6>Asistencias Hoy</h6><h2><?php echo $asistencias_hoy; ?></h2></div></div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white"><div class="card-body"><h6>Retardos Hoy</h6><h2><?php echo $retardos_hoy; ?></h2></div></div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white"><div class="card-body"><h6>Faltas Hoy</h6><h2><?php echo $faltas; ?></h2></div></div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="table-container">
                <h5>Tendencia de Asistencias (7 días)</h5>
                <canvas id="grafica_asistencias"></canvas>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="table-container text-warning">
                <h5 class="text-dark">Histórico de Retardos</h5>
                <canvas id="grafica_retardos"></canvas>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="table-container">
                <h5>Últimos Registros</h5>
                <table class="table table-hover mt-3">
                    <thead class="table-dark">
                        <tr><th>Empleado</th><th>Hora Entrada</th><th>Salida</th><th>Estado</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($stmt as $row): ?>
                        <tr>
                            <td><?php echo $row['nombre']." ".$row['apellido_paterno']; ?></td>
                            <td><span class="badge bg-light text-dark"><?php echo $row['hora_entrada']; ?></span></td>
                            <td><?php echo $row['hora_salida'] ?: '--:--'; ?></td>
                            <td><?php echo $row['retardo'] ? '<span class="badge bg-danger">RETARDO</span>' : '<span class="badge bg-success">PUNTUAL</span>'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="table-container">
                <h5>🏆 Top Puntuales</h5>
                <ul class="list-group list-group-flush mt-3">
                    <?php foreach($top_puntuales as $top): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo $top['nombre']; ?>
                        <span class="badge bg-success rounded-pill"><?php echo $top['asistencias']; ?> asist.</span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-container">
                <h5>🔔 Notificaciones en tiempo real</h5>
                <ul id="notificaciones" class="list-group list-group-flush mt-2"></ul>
            </div>
        </div>
    </div>
</div>

<script>
    new Chart(document.getElementById('grafica_asistencias'), {
        type: 'bar',
        data: {
            labels: [<?php foreach($data_grafica as $d) echo "'".$d['fecha']."',"; ?>],
            datasets: [{ label: 'Asistencias', data: [<?php foreach($data_grafica as $d) echo $d['total'].","; ?>], backgroundColor: '#0d6efd' }]
        }
    });

    new Chart(document.getElementById('grafica_retardos'), {
        type: 'line',
        data: {
            labels: [<?php foreach($data_retardos as $r) echo "'".$r['fecha']."',"; ?>],
            datasets: [{ label: 'Retardos', data: [<?php foreach($data_retardos as $r) echo $r['total'].","; ?>], borderColor: '#ffc107', fill: false, tension: 0.3 }]
        }
    });

    // Sistema de Notificaciones
    function cargarNotificaciones(){
        fetch("api/notificaciones.php").then(res=>res.json()).then(data=>{
            let lista = document.getElementById("notificaciones");
            lista.innerHTML="";
            data.forEach(n=>{
                lista.innerHTML += `<li class="list-group-item small">🔹 ${n.mensaje} <span class="text-muted float-end">${n.fecha}</span></li>`;
            });
        });
    }
    setInterval(cargarNotificaciones, 5000);
    cargarNotificaciones();
</script>
</body>
</html>
