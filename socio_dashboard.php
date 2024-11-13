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

// Obtener el historial de pagos del socio con detalles
$sqlPagos = "SELECT fecha_pago, mes_cancelado, monto, estado_pago, anio, mes 
             FROM Pagos 
             WHERE cedula = ? ORDER BY anio DESC, mes DESC";
$stmtPagos = $conn->prepare($sqlPagos);

// Verificar si la consulta se preparó correctamente
if ($stmtPagos === false) {
    die('Error al preparar la consulta: ' . $conn->error);
}

$stmtPagos->bind_param("s", $cedula);
$stmtPagos->execute();
$resultPagos = $stmtPagos->get_result();

$pagosRealizados = [];
while ($row = $resultPagos->fetch_assoc()) {
    $pagosRealizados[] = $row;
}

// Obtener el año actual para mostrar el historial del año actual
$anioActual = date('Y');
$meses = [
    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
];
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
            background-color: #00986c; /* Verde luminoso */
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
            color: #000000; /* Amarillo para resaltar */
        }

        /* Estilos de contenido */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: rgba(92, 92, 92, 0.8); /* Gris oscuro con transparencia */
            color: #FFFF; /* Blanco grisáceo */
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #FFFF; /* Blanco grisáceo */
            font-size: 26px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #8a8a8a; /* Azul oscuro */
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        th, td {
            padding: 12px;
            border: 1px solid #616161; /* Gris más claro */
            text-align: center;
        }
        th {
            background-color: #00986c; /* Verde luminoso */
            color: white;
        }
        .estado-pendiente {
            color: #FF5252; /* Rojo claro */
            font-weight: bold;
        }
        .estado-cancelado {
            color: #76FF03; /* Verde más tenue */
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #616161; /* Gris más claro */
        }
        tr:hover {
            background-color: #757575; /* Resalta con un gris más claro */
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
            <th>Fecha de Pago</th>
            <th>Mes Cancelado</th>
            <th>Estado</th>
            <th>Valor Cancelado</th>
        </tr>
        <?php
        // Mostrar el historial de pagos
        foreach ($pagosRealizados as $pago) {
            $fechaPago = date("d-m-Y", strtotime($pago['fecha_pago']));
            $estadoPago = $pago['estado_pago'] == 'Cancelado' ? 'Cancelado' : 'Pendiente';
            $estadoClass = strtolower($estadoPago);
            
            echo "<tr>";
            echo "<td>{$fechaPago}</td>";
            echo "<td>{$pago['mes_cancelado']}</td>";
            echo "<td class='estado-{$estadoClass}'>{$estadoPago}</td>";
            echo "<td>{$pago['monto']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
