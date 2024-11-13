<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Pagos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #005f73; /* Celeste */
        }
        nav {
            background-color: #005f73; /* Celeste */
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end; /* Alinear a la derecha */
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            margin: 0 5px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        nav a:hover {
            background-color: #008CBA; /* Verde */
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
    <nav>
        <a href="reportes.php">Ver Reporte de Pagos</a>
        <a href="login.php">Cerrar Sesión</a>
    </nav>
    <h1>Registro de Pagos</h1>
    <form action="registrar_pago.php" method="POST">
        <label for="cedula">Cédula:</label>
        <input type="text" name="cedula" required>

        <!-- Campos ocultos para la fecha actual -->
        <input type="hidden" name="dia" id="dia">
        <input type="hidden" name="mes" id="mes">
        <input type="hidden" name="anio" id="anio">
        <input type="hidden" name="fecha_pago" id="fecha_pago"> <!-- Campo oculto para la fecha de pago -->

        <label for="mes_cancelado">Mes que se está cancelando:</label>
        <select name="mes_cancelado" required>
            <option value="Enero">Enero</option>
            <option value="Febrero">Febrero</option>
            <option value="Marzo">Marzo</option>
            <option value="Abril">Abril</option>
            <option value="Mayo">Mayo</option>
            <option value="Junio">Junio</option>
            <option value="Julio">Julio</option>
            <option value="Agosto">Agosto</option>
            <option value="Septiembre">Septiembre</option>
            <option value="Octubre">Octubre</option>
            <option value="Noviembre">Noviembre</option>
            <option value="Diciembre">Diciembre</option>
        </select>

        <label for="monto">Monto:</label>
        <input type="number" name="monto" required>

        <button type="submit">Registrar Pago</button>
    </form>

    <script>
        // Establecer automáticamente la fecha actual en los campos ocultos
        const fechaActual = new Date();
        document.getElementById('dia').value = fechaActual.getDate();
        document.getElementById('mes').value = fechaActual.getMonth() + 1; // Mes comienza en 0
        document.getElementById('anio').value = fechaActual.getFullYear();
        document.getElementById('fecha_pago').value = fechaActual.toISOString().split('T')[0]; // Formato YYYY-MM-DD

        // Verificar que la fecha se esté configurando correctamente en el campo oculto
        console.log("Fecha de pago:", document.getElementById('fecha_pago').value);
    </script>
</body>
</html>
