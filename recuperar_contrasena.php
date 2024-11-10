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
    <form action="procesar_recuperar_contrasena.php" method="POST">
        <label for="correo">Ingresa tu correo electrónico:</label>
        <input type="email" name="correo" required>

        <button type="submit">Recuperar Contraseña</button>
    </form>
</body>
</html>
