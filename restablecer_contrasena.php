<?php
session_start();
include 'conexion.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verifica si el token existe y no ha expirado
    $sql = "SELECT * FROM Usuarios WHERE token = ? AND token_expiry > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $newPassword = $_POST['password'];
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Actualiza la contraseña en la base de datos
            $sqlUpdate = "UPDATE Usuarios SET password = ?, token = NULL, token_expiry = NULL WHERE token = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("ss", $hashedPassword, $token);
            $stmtUpdate->execute();

            echo "Contraseña actualizada exitosamente. Puedes iniciar sesión con tu nueva contraseña.";
        }
    } else {
        echo "El enlace de recuperación es inválido o ha expirado.";
    }
} else {
    echo "Token no proporcionado.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <style>
        /* Estilos similares a los del login */
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Restablecer Contraseña</h2>
        <form action="restablecer_contrasena.php?token=<?php echo htmlspecialchars($_GET['token']); ?>" method="POST">
            <label for="password">Nueva Contraseña:</label>
            <input type="password" name="password" required placeholder="Ingresa tu nueva contraseña">
            <button type="submit">Actualizar Contraseña</button>
        </form>
    </div>
</body>
</html>
