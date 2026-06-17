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
function onScanSuccess(decodedText) {

fetch("api/attendance.php", {

    method: "POST",

    headers: {
        "Content-Type": "application/json"
    },

    body: JSON.stringify({
        codigo: decodedText
    })

})
.then(response => response.json())

.then(data => {

    const mensaje =
        document.getElementById("mensaje");

    if (data.success) {

        mensaje.innerHTML =
            "✅ Asistencia registrada correctamente";

        mensaje.className =
            "alert alert-success mt-3";

    } else {

        mensaje.innerHTML =
            "❌ " + data.message;

        mensaje.className =
            "alert alert-danger mt-3";
    }

    setTimeout(() => {

        mensaje.innerHTML = "";
        mensaje.className = "";

    }, 3000);

})
.catch(error => {

    console.error(error);

    const mensaje =
        document.getElementById("mensaje");

    mensaje.innerHTML =
        "❌ Error al conectar con la API";

    mensaje.className =
        "alert alert-danger mt-3";

});

}
let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", // Debe coincidir con el id del div <div id="reader">
    { fps: 3, qrbox: {width: 250, height: 250} },
    false
);

html5QrcodeScanner.render(onScanSuccess);

</script>
<div id="mensaje"></div>
</body>
</html>
