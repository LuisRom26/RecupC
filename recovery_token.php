<?php
include("conexion.php");
$token_verified = false;
$error_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $entered_token = $_POST['token'];
    $conn = connect();
    $stmt = $conn->prepare("SELECT email FROM users WHERE token = ?");
    $stmt->bind_param("s", $entered_token);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $token_verified = true;
        $stmt->bind_result($email);
        $stmt->fetch();
        header("Location: change_pass.php?email=" . urlencode($email));
        exit();
    } else {
        $error_message = "El token ingresado no es válido. Por favor, intenta nuevamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Token</title>
</head>
<body>
    <h1>Verificar Token</h1>
    <?php if (!$token_verified) { ?>
        <form action="" method="post">
            <div>
                <label for="token">Token generado:</label>
                <input type="text" id="token" name="token" required>
            </div>
            <div>
                <button type="submit" name="submit">Verificar Token</button>
            </div>
        </form>
        <?php if (!empty($error_message)) {
            echo "<p>$error_message</p>";
        } ?>
    <?php } ?>
</body>

</html>
