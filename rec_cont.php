<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de inicio de sesión</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="col-md-6">
            <h2>Recuperar contraseña</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Recuperar contraseña</button>
            </form>
        </div>
    </div>
    </div>

</body>
</html>
<?php
include("conexion.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = $_POST['email'];
    $conn = connect();
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    if ($num_rows > 0) {
        header("Location: success.php?email=" . urlencode($email) . "&token=" . urlencode($token));
        exit();
    } else {
        echo "<p class='text-danger'>El correo electrónico proporcionado no está registrado.</p>";
    }
}
