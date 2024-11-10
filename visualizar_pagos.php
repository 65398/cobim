<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php"); // Redirige si no es administrador
    exit;
}

// Consulta para obtener los pagos y los nombres de los socios
$sql = "SELECT Pagos.cedula, Pagos.mes, Pagos.anio, Pagos.monto, Pagos.fecha_pago, 
               Usuarios.nombres, Usuarios.apellidos 
        FROM Pagos 
        INNER JOIN Usuarios ON Pagos.cedula = Usuarios.cedula"; // Verifica que 'cedula' sea la columna adecuada en ambas tablas

$result = $conn->query($sql);

// Verifica si la consulta tuvo éxito
if (!$result) {
    echo "Error en la consulta: " . $conn->error; // Muestra el error de la consulta
    exit; // Detiene la ejecución si hay un error
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Pagos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #005f73; /* Azul más oscuro */
        }
        /* Estilo de la barra de navegación */
        .navbar {
            display: flex;
            justify-content: flex-end;
            background-color: #005f73; /* Azul más oscuro */
            padding: 10px;
        }
        .navbar a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            margin-left: 15px;
        }
        .navbar a:hover {
            background-color: #008CBA; /* Celeste */
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }
        th {
            background-color: #008CBA; /* Celeste */
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

    <!-- Barra de Navegación -->
    <div class="navbar">
        <a href="admin_dashboard.php">Registrar Pago</a>
        <a href="visualizar_pagos.php">Visualizar Pagos</a>
        <a href="login.php">Cerrar Sesión</a>
    </div>

    <h1>Visualizar Pagos</h1>

    <table>
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombres</th>
                <th>Apellido</th>
                <th>Mes</th>
                <th>Año</th>
                <th>Monto</th>
                <th>Fecha de Pago</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['cedula']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombres']); ?></td>
                        <td><?php echo htmlspecialchars($row['apellidos']); ?></td>
                        <td><?php echo htmlspecialchars($row['mes']); ?></td>
                        <td><?php echo htmlspecialchars($row['anio']); ?></td>
                        <td><?php echo htmlspecialchars($row['monto']); ?></td>
                        <td><?php echo htmlspecialchars($row['fecha_pago']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No hay pagos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>

<?php
$conn->close();
?>
