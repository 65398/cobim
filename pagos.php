<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT mes, anio, estado FROM Pagos WHERE id_usuario = $id_usuario ORDER BY anio, mes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Pagos</title>
</head>
<body>
    <h1>Reporte de Pagos</h1>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Incluir estilos -->
    <table>
        <tr>
            <th>Mes</th>
            <th>Año</th>
            <th>Estado</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['mes']}</td>
                <td>{$row['anio']}</td>
                <td>{$row['estado']}</td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>

