<?php
include("conexion.php");
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['email'])) {
    // Recuperar el correo electrónico de la URL
    $email = $_GET['email'];

    // Realizar una consulta para obtener el token correspondiente al correo electrónico
    $conn = connect();
    $stmt = $conn->prepare("SELECT token FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($token);
        $stmt->fetch();
    } else {
        header("Location: rec_cont.php");
        exit();
    }
} else {
    header("Location: rec_cont.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de contraseña - Token</title>
</head>
<body>
    <h1>Codigo de recuperación de contraseña</h1>
    <p>Se ha generado un token del usuario:</p>
    <p>El token es: <?php echo $token; ?></p>
    <p>Por favor, copia este token y pégalo en el formulario para cambiar la contraseña.</p>
    <a type="button" href="recovery_token.php"><b>Continuar</b></a>
</body>
</html>