<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para obtener el usuario
    $sql = "SELECT * FROM Usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifica la contraseña
        if (password_verify($password, $user['password'])) {
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['rol'] = $user['rol'];

            // Redirige según el rol
            if ($user['rol'] == 'administrador') {
                header("Location: admin_dashboard.php"); // Redirige a la página de administración
            } else {
                header("Location: pagos.php"); // Redirige a la página de pagos para los socios
            }
            exit; // Asegúrate de terminar el script después de la redirección
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>
