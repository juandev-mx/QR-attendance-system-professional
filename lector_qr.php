<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<title>Escanear QR</title>

<script src="https://unpkg.com/html5-qrcode"></script>

</head>

<body>

<h2>Escaneo de asistencia</h2>

<div id="reader" style="width:400px"></div>
<script>
// Variable de control para evitar peticiones duplicadas simultáneas
let procesandoEscaneo = false;

function onScanSuccess(decodedText) {
    // Si ya estamos procesando un QR, ignoramos los escaneos fantasmas de la cámara
    if (procesandoEscaneo) return;
    procesandoEscaneo = true;

    // 1. Pausamos el escáner visualmente para que el usuario sepa que ya se leyó
    html5QrcodeScanner.clear(); 

    fetch("api/attendance.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            codigo: decodedText
        })
    })
    .then(response => {
        // Validamos si la respuesta no es un JSON válido (por ejemplo, si da error 500)
        if (!response.ok) {
            throw new Error("Respuesta del servidor no válida");
        }
        return response.json();
    })
    .then(data => {
        const mensaje = document.getElementById("mensaje");

        if (data.success) {
            mensaje.innerHTML = "✅ Asistencia registrada correctamente";
            mensaje.className = "alert alert-success mt-3";
        } else {
            mensaje.innerHTML = "❌ " + data.message;
            mensaje.className = "alert alert-danger mt-3";
        }

        // 2. Esperamos 3 segundos mostrando el mensaje, limpiamos y reactivamos la cámara
        setTimeout(() => {
            mensaje.innerHTML = "";
            mensaje.className = "";
            procesandoEscaneo = false;
            
            // Renderizamos el escáner nuevamente para el siguiente empleado
            html5QrcodeScanner.render(onScanSuccess);
        }, 3000);

    })
    .catch(error => {
        console.error(error);
        const mensaje = document.getElementById("mensaje");
        mensaje.innerHTML = "❌ Error al conectar con la API";
        mensaje.className = "alert alert-danger mt-3";

        // Reactivamos en caso de error de red
        setTimeout(() => {
            mensaje.innerHTML = "";
            mensaje.className = "";
            procesandoEscaneo = false;
            html5QrcodeScanner.render(onScanSuccess);
        }, 3000);
    });
}

// Configuración inicial del escáner
let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", 
    { 
        fps: 3, // Lee 3 cuadros por segundo (ideal para no saturar el procesador)
        qrbox: {width: 250, height: 250},
        rememberLastUsedCamera: true // Evita pedir permisos a cada rato
    },
    false
);

html5QrcodeScanner.render(onScanSuccess);
</script>

<div id="mensaje"></div>
</body>
</html>
