<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];

    // Consulta para verificar si el correo existe
    $sql = "SELECT * FROM Usuarios WHERE correo = ?";
    if ($stmt = $conn->prepare($sql)) { // Verifica si la consulta se prepara correctamente
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Genera un token único para el restablecimiento
            $token = bin2hex(random_bytes(50));
            $expiry = date("Y-m-d H:i:s", strtotime('+1 hour')); // El token vence en 1 hora

            // Consulta para actualizar el token y su fecha de expiración
            $sqlToken = "UPDATE Usuarios SET token = ?, token_expiry = ? WHERE correo = ?";
            if ($stmtToken = $conn->prepare($sqlToken)) { // Verifica si la consulta se prepara correctamente
                $stmtToken->bind_param("sss", $token, $expiry, $correo);
                $stmtToken->execute();

                // Enviar el enlace de restablecimiento de contraseña al correo
                $resetLink = "http://tu-dominio.com/restablecer_contrasena.php?token=" . $token;

                // Configura el correo
                $to = $correo;
                $subject = "Recuperación de Contraseña";
                $message = "Hemos recibido una solicitud para restablecer tu contraseña. Haz clic en el siguiente enlace para restablecerla:\n\n" . $resetLink;
                $headers = "From: no-reply@tu-dominio.com";

                if (mail($to, $subject, $message, $headers)) {
                    echo "Se ha enviado un enlace de restablecimiento a tu correo.";
                } else {
                    echo "Error al enviar el correo.";
                }
            } else {
                echo "Error al preparar la consulta para actualizar el token: " . $conn->error;
            }
        } else {
            echo "Correo no encontrado.";
        }
    } else {
        echo "Error al preparar la consulta de verificación del correo: " . $conn->error;
    }

    $stmt->close(); // Cerrar el statement después de su uso
    $conn->close(); // Cerrar la conexión
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #008CBA;
            text-align: center;
        }
        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #008CBA;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #005f73;
        }
    </style>
</head>
<body>
    <h2>Recuperar Contraseña</h2>
    <form action="recuperar_contrasena.php" method="POST">
        <label for="correo">Ingresa tu correo electrónico:</label>
        <input type="email" name="correo" required>

        <button type="submit">Recuperar Contraseña</button>
    </form>
</body>

</html>
