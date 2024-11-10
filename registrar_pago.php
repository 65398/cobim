<?php
session_start();
include 'conexion.php'; // Asegúrate de que la conexión a la base de datos esté bien configurada

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['cedula'];
    $dia = $_POST['dia'];
    $mes = $_POST['mes']; // Esto ahora debería corresponder al mes en letras
    $anio = $_POST['anio'];
    $monto = $_POST['monto'];
    $fecha_pago = $_POST['fecha_pago'];

    // Inserta el pago en la base de datos
    $sql = "INSERT INTO Pagos (cedula, dia, mes, anio, monto, fecha_pago) VALUES (?, ?, ?, ?, ? , ?)";

    // Usar consultas preparadas para evitar inyecciones SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $cedula, $dia, $mes, $anio, $monto, $fecha_pago);

    if ($stmt->execute()) {
        echo "Pago registrado correctamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
