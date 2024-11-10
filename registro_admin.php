<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Socios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #008CBA; /* Celeste */
        }
        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #008CBA; /* Celeste */
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #005f73; /* Verde */
        }
    </style>
</head>
<body>
    <h1>Registro de Socios</h1>
    <form action="procesar_registro_administrador.php" method="POST">
        <label for="cedula">Cédula:</label>
        <input type="text" name="cedula" required>

        <label for="nombres">Nombres:</label>
        <input type="text" name="nombres" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono">

        <label for="correo">Correo:</label>
        <input type="email" name="correo" required>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion">

        <label for="laborando">¿Está laborando actualmente?</label>
        <select name="laborando" required>
            <option value="si">Sí</option>
            <option value="no">No</option>
        </select>

        <div id="trabajo" style="display: none;">
            <label for="lugar_trabajo">Lugar de trabajo:</label>
            <input type="text" name="lugar_trabajo">

            <label for="cargo">Cargo:</label>
            <input type="text" name="cargo">
        </div>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>

        <button type="submit">Registrar Administrador</button>
    </form>

    <script>
        const laborandoSelect = document.querySelector('select[name="laborando"]');
        const trabajoDiv = document.getElementById('trabajo');

        laborandoSelect.addEventListener('change', function() {
            if (this.value === 'si') {
                trabajoDiv.style.display = 'block';
            } else {
                trabajoDiv.style.display = 'none';
            }
        });
    </script>
</body>
</html>
