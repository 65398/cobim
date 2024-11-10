<?php
session_start();
include 'conexion.php';

// Verificar si el usuario está autenticado y es un socio
if (!isset($_SESSION['cedula']) || $_SESSION['rol'] !== 'socio') {
    header("Location: login.php");
    exit;
}

// Obtener la cédula del socio de la sesión
$cedula = $_SESSION['cedula'];

// Obtener el nombre del socio
$sql = "SELECT nombres FROM Usuarios WHERE cedula = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cedula);
$stmt->execute();
$result = $stmt->get_result();
$socio = $result->fetch_assoc();
$nombre_socio = $socio['nombres'];

// Configurar los meses para mostrar en la tabla
$meses = [
    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
];

// Obtener el historial de pagos del socio
$sqlPagos = "SELECT mes, anio FROM Pagos WHERE cedula = ?";
$stmtPagos = $conn->prepare($sqlPagos);
$stmtPagos->bind_param("s", $cedula);
$stmtPagos->execute();
$resultPagos = $stmtPagos->get_result();

$pagosRealizados = [];
while ($row = $resultPagos->fetch_assoc()) {
    $pagosRealizados[$row['anio']][$row['mes']] = 'Cancelado';
}

// Obtener el año actual para mostrar el historial del año actual
$anioActual = date('Y');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Pagos</title>
    <style>
        /* Barra de navegación */
        .navbar {
            display: flex;
            justify-content: flex-end;
            background-color: #003366; /* Azul oscuro */
            padding: 20px;
            color: white;
        }
        .navbar a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
            font-weight: bold;
        }
        .navbar a:hover {
            text-decoration: underline;
        }

        /* Estilos de contenido */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #003366; /* Azul oscuro */
            font-size: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #003366;
            color: white;
        }
        .estado-pendiente {
            color: red;
            font-weight: bold;
        }
        .estado-cancelado {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="socio_dashboard.php">Inicio</a>
        <a href="login.php">Cerrar Sesión</a>
    </div>

    <h1>Hola, <?php echo htmlspecialchars($nombre_socio); ?>. Este es tu historial de pagos</h1>

    <table>
        <tr>
            <th>Mes</th>
            <th>Año</th>
            <th>Estado</th>
        </tr>
        <?php
        foreach ($meses as $mesNombre) {
            // Verificar si el pago se realizó para el mes actual y año actual
            $estadoPago = isset($pagosRealizados[$anioActual][$mesNombre]) ? 'Cancelado' : 'Pendiente';
            echo "<tr>";
            echo "<td>{$mesNombre}</td>";
            echo "<td>{$anioActual}</td>";
            echo "<td class='estado-" . strtolower($estadoPago) . "'>{$estadoPago}</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
