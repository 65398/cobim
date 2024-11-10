<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Consulta para obtener el usuario
    $sql = "SELECT * FROM Usuarios WHERE correo = '$correo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifica la contraseña
        if (password_verify($password, $user['password'])) {
            // Establece las variables de sesión
            $_SESSION['cedula'] = $user['cedula']; // Cambia a cedula
            $_SESSION['rol'] = $user['rol'];

            // Redirige según el rol del usuario
            if ($user['rol'] == 'administrador') {
                header("Location: admin_dashboard.php"); // Cambia a la página de administrador
            } else {
                header("Location: socio_dashboard.php"); // Cambia a la página de socios
            }
            exit; // Asegúrate de usar exit después de header
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Correo no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <style>
        /* Estilos Globales */
        body {
            font-family: Arial, sans-serif;
            background-color: #A3C1DA; /* Celeste pastel */
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2 {
            color: #008CBA; /* Celeste para el título */
            margin-bottom: 20px;
            text-align: center;
        }

        /* Estilo del contenedor del formulario */
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 350px; /* Ancho máximo del formulario */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Estilo de las etiquetas */
        label {
            display: block;
            font-size: 14px;
            color: #333;
            margin-bottom: 8px;
        }

        /* Estilo de los campos de texto */
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box; /* Asegura que el padding no afecte el ancho */
        }

        input:focus {
            border-color: #008CBA;
            outline: none;
        }

        /* Estilo del botón */
        button {
            background-color: #008CBA; /* Celeste */
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #005f73; /* Verde oscuro */
        }

        /* Estilo para los enlaces adicionales */
        .extra-links {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .extra-links a {
            color: #008CBA;
            text-decoration: none;
            display: block;
            margin: 5px 0;
        }

        .extra-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Iniciar Sesión</h2>
        <form action="login.php" method="POST">
            <label for="correo">Correo:</label>
            <input type="email" name="correo" required placeholder="Ingresa tu correo">
            
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required placeholder="Ingresa tu contraseña">
            
            <button type="submit">Ingresar</button>
        </form>

        <div class="extra-links">
            <a href="recuperar_contrasena.php">¿Olvidaste tu contraseña?</a>
            <a href="registro_socio.php">¿No estás registrado? Regístrate aquí</a>
            <a href="index.php">Regresar</a>
        </div>
    </div>
</body>
</html>
