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
    <script>
        function actualizarFecha() {
            const fechaInput = document.querySelector('input[name="fecha_pago"]');
            const diaInput = document.querySelector('input[name="dia"]');
            const mesInput = document.querySelector('input[name="mes"]');
            const anioInput = document.querySelector('input[name="anio"]');

            // Obtener la fecha seleccionada en formato UTC
            const fechaSeleccionada = new Date(fechaInput.value + "T00:00:00Z");
            const dia = fechaSeleccionada.getUTCDate(); // Obtiene el día correctamente
            const mes = fechaSeleccionada.getUTCMonth(); // Los meses comienzan desde 0
            const anio = fechaSeleccionada.getUTCFullYear();

            // Convertir el número del mes a texto
            const meses = [
                "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
            ];

            // Autocompletar los campos de día, mes y año
            diaInput.value = dia; // Este ahora debería mostrar correctamente el día
            mesInput.value = meses[mes]; // Usar el array para obtener el nombre del mes
            anioInput.value = anio;
        }
    </script>
</head>
<body>
    <nav>

        <a href="visualizar_pagos.php">Visualizar Pagos</a>
        <a href="login.php">Cerrar Sesión</a>
    </nav>
    <h1>Registro de Pagos</h1>
    <form action="registrar_pago.php" method="POST">
        <label for="cedula">Cédula:</label>
        <input type="text" name="cedula" required>

        <label for="fecha_pago">Fecha de Pago:</label>
        <input type="date" name="fecha_pago" onchange="actualizarFecha()" required>

        <label for="dia">Día:</label>
        <input type="text" name="dia" readonly>

        <label for="mes">Mes:</label>
        <input type="text" name="mes" readonly>

        <label for="anio">Año:</label>
        <input type="text" name="anio" readonly>

        <label for="monto">Monto:</label>
        <input type="number" name="monto" required>

        <button type="submit">Registrar Pago</button>
    </form>
</body>
</html>
