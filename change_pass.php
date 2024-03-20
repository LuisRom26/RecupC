<?php
include("conexion.php");
$email = "";
$new_password = "";
$confirm_password = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    if ($new_password !== $confirm_password) {
        $error_message = "Las contraseñas no coinciden. Intentalo de nuevo";
    } else {
        $hashed_password = md5($new_password);
        $new_token = generateToken();
        $conn = connect();
        $stmt = $conn->prepare("UPDATE users SET password = ?, token = ? WHERE email = ?");
        $stmt->bind_param("sss", $hashed_password, $new_token, $email);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            header("refresh:0; url=index.html");
            $mensaje = "¡Contraseña cambiada";
?>
            <script>
                alert("<?php echo $mensaje; ?>");
            </script>
<?php
        } else {
            $error_message = "Error al cambiar la contraseña.";
        }
        $stmt->close();
        $conn->close();
    }
}
function generateToken()
{
    return md5(uniqid(mt_rand(), true)); 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
</head>
<body>
    <h1>Cambiar Contraseña</h1>
    <form action="" method="post">
        <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
        <div>
            <label for="new_password">Nueva contraseña:</label>
            <input type="password" id="new_password" name="new_password" required>
        </div>
        <div>
            <label for="confirm_password">Confirmar contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <div>
            <button type="submit" name="submit">Cambiar contraseña</button>
        </div>
        <?php if (!empty($error_message)) {
            echo "<p>$error_message</p>";
        } ?>
    </form>
</body>

</html>