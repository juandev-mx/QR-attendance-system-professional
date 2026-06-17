<?php
session_start();
require "../config/database.php";

require "../vendor/autoload.php";
require "../config/jwt.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if($_SERVER['REQUEST_METHOD']=="POST"){

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE email=:email AND activo=1";

$stmt = $conexion->prepare($sql);
$stmt->execute(['email'=>$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user && password_verify($password, $user['password'])){
    $payload = [
        "iss" => "sistema_asistencias",
        "iat" => time(),
        "exp" => time() + 3600,
        "user_id" => $user['id'],
        "email" => $user['email']
    ];

    $jwt = JWT::encode($payload, $jwt_secret, 'HS256');
    
    header('Content-Type: application/json');
    echo json_encode(["token" => $jwt]);
    exit();
}

}else{

$error="Credenciales incorrectas";

}

?>

<h2>Login Administrador</h2>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<form method="POST">

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit">Entrar</button>

</form>

<?php if(isset($error)) echo $error; ?>