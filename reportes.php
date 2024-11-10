<?php
session_start();
include 'conexion.php';

// Verifica si el usuario ha iniciado sesión y tiene el rol adecuado
if (!isset($_SESSION['rol'])) {
    echo "No hay sesión iniciada.";
    exit;
} elseif ($_SESSION['rol'] != 'administrador' && $_SESSION['rol'] != 'socio') {
    echo "Acceso denegado.";
    exit;
}

// Variables para filtros
$mes = isset($_POST['mes']) ? $_POST['mes'] : '';
$anio = isset($_POST['anio']) ? $_POST['anio'] : '';
$socio = isset($_POST['socio']) ? $_POST['socio'] : '';

// Consulta inicial
$sql = "SELECT p.cedula, p.fecha_pago, p.monto, u.nombres, u.apellidos 
        FROM Pagos p 
        JOIN Usuarios u ON p.cedula = u.cedula 
        WHERE 1=1";

// Filtros por mes, año y socio
if ($mes) {
    $sql .= " AND MONTH(p.fecha_pago) = $mes";  // Usando la columna 'fecha_pago'
}

if ($anio) {
    $sql .= " AND YEAR(p.fecha_pago) = $anio";  // Usando la columna 'fecha_pago'
}

if ($socio) {
    $sql .= " AND p.cedula = '$socio'";  // Usando la columna 'cedula'
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de Pagos</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* Diseño general */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1000px;
            padding: 30px;
            margin-top: 30px;
        }

        h2 {
            text-align: center;
            color: #1e2a3a;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            justify-content: center;
        }

        label {
            font-weight: bold;
            color: #1e2a3a;
        }

        select, input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 150px;
            transition: border-color 0.3s;
        }

        select:focus, input:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            background-color: #005f73;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #008CBA;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #005f73;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #005f73;
            text-decoration: none;
            font-size: 16px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .print-button, .share-button {
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .print-button {
            background-color: #005f73;
            color: white;
        }

        .print-button:hover {
            background-color: #008CBA;
        }

        .share-button {
            background-color: #005f73;
            color: white;
        }

        .share-button:hover {
            background-color: #008CBA;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reportes de Pagos</h2>

        <!-- Formulario para elegir filtros -->
        <form method="post" action="">
            <div class="form-group">
                <div>
                    <label for="mes">Mes:</label>
                    <select name="mes" id="mes">
                        <option value="">Todos</option>
                        <option value="1" <?php echo ($mes == '1') ? 'selected' : ''; ?>>Enero</option>
                        <option value="2" <?php echo ($mes == '2') ? 'selected' : ''; ?>>Febrero</option>
                        <option value="3" <?php echo ($mes == '3') ? 'selected' : ''; ?>>Marzo</option>
                        <option value="4" <?php echo ($mes == '4') ? 'selected' : ''; ?>>Abril</option>
                        <option value="5" <?php echo ($mes == '5') ? 'selected' : ''; ?>>Mayo</option>
                        <option value="6" <?php echo ($mes == '6') ? 'selected' : ''; ?>>Junio</option>
                        <option value="7" <?php echo ($mes == '7') ? 'selected' : ''; ?>>Julio</option>
                        <option value="8" <?php echo ($mes == '8') ? 'selected' : ''; ?>>Agosto</option>
                        <option value="9" <?php echo ($mes == '9') ? 'selected' : ''; ?>>Septiembre</option>
                        <option value="10" <?php echo ($mes == '10') ? 'selected' : ''; ?>>Octubre</option>
                        <option value="11" <?php echo ($mes == '11') ? 'selected' : ''; ?>>Noviembre</option>
                        <option value="12" <?php echo ($mes == '12') ? 'selected' : ''; ?>>Diciembre</option>
                    </select>
                </div>

                <div>
                    <label for="anio">Año:</label>
                    <select name="anio" id="anio">
                        <option value="">Todos</option>
                        <option value="2023" <?php echo ($anio == '2023') ? 'selected' : ''; ?>>2023</option>
                        <option value="2024" <?php echo ($anio == '2024') ? 'selected' : ''; ?>>2024</option>
                    </select>
                </div>

                <div>
                    <label for="socio">Socio:</label>
                    <input type="text" name="socio" id="socio" value="<?php echo $socio; ?>" placeholder="Cédula del socio">
                </div>

                <div>
                    <button type="submit">Filtrar</button>
                </div>
            </div>
        </form>

        <?php
        if ($result->num_rows > 0) {
            echo "<div id='reportTable'>";
            echo "<table>";
            echo "<tr><th>Cédula</th><th>Nombres y Apellidos</th><th>Fecha</th><th>Monto</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['cedula'] . "</td>";
                echo "<td>" . $row['nombres'] . " " . $row['apellidos'] . "</td>";
                echo "<td>" . $row['fecha_pago'] . "</td>";
                echo "<td>" . $row['monto'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo "<p>No se encontraron registros de pagos.</p>";
        }

        $conn->close();
        ?>
        
        <div class="button-container">
            <button class="print-button" onclick="printReport()">Imprimir Reporte</button>
            <button class="share-button" onclick="shareReport()">Compartir Reporte</button>
        </div>

        <a href="admin_dashboard.php" class="back-link">Agregar pagos</a>
    </div>

    <script>
        // Función para imprimir el reporte
        function printReport() {
            const printContent = document.getElementById('reportTable');
            const printWindow = window.open('', '', 'height=600,width=800');
            
            // Crear el contenido HTML para la ventana de impresión
            printWindow.document.write('<html><head><title>Imprimir Reporte</title>');
            
            // Añadir los estilos CSS de la página para que se apliquen en la impresión
            printWindow.document.write(`
                <style>
                    body {
                        font-family: 'Roboto', sans-serif;
                        background-color: #f4f7fc;
                        color: #333;
                        margin: 0;
                        padding: 0;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 100vh;
                    }

                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }

                    table, th, td {
                        border: 1px solid #ddd;
                    }

                    th, td {
                        padding: 12px;
                        text-align: left;
                    }

                    th {
                        background-color: #007bff;
                        color: white;
                    }

                    td {
                        background-color: #f9f9f9;
                    }
                </style>
            `);
            
            printWindow.document.write('</head><body>');
            printWindow.document.write(printContent.innerHTML);  // Contenido de la tabla
            printWindow.document.write('</body></html>');
            
            printWindow.document.close(); // Cierra el documento de la ventana
            printWindow.print(); // Ejecuta la acción de imprimir
        }

        // Función para compartir el reporte
        function shareReport() {
            const url = window.location.href;  // Obtener la URL actual
            const text = "Revisa el reporte de pagos: ";  // Texto para compartir
            if (navigator.share) {
                navigator.share({
                    title: 'Reporte de Pagos',
                    text: text,
                    url: url
                }).catch(console.error);
            } else {
                alert("Tu navegador no soporta la función de compartir.");
            }
        }
    </script>
</body>
</html>
