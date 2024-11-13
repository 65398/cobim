<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si el campo 'fecha_pago' está presente en los datos del formulario
    if (isset($_POST['fecha_pago'])) {
        $cedula = $_POST['cedula'];
        $dia = $_POST['dia'];
        $mes = $_POST['mes'];
        $anio = $_POST['anio'];
        $monto = $_POST['monto'];
        $fecha_pago = $_POST['fecha_pago']; // Asegurarse de que la fecha de pago está siendo recibida
        $mes_cancelado = $_POST['mes_cancelado'];

        // Establecer el estado de pago como "Cancelado" automáticamente
        $estado_pago = 'Cancelado';

        // Validación básica para asegurarse de que los campos no estén vacíos
        if (empty($cedula) || empty($monto) || empty($fecha_pago) || empty($mes_cancelado)) {
            echo "Todos los campos son obligatorios.";
            exit;
        }

        // Preparar la consulta para insertar el pago
        $sql = "INSERT INTO Pagos (cedula, dia, mes, anio, monto, fecha_pago, mes_cancelado, estado_pago) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la declaración
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }

        // Vincular los parámetros
        $stmt->bind_param("ssssssss", $cedula, $dia, $mes, $anio, $monto, $fecha_pago, $mes_cancelado, $estado_pago);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Pago registrado correctamente.";
        } else {
            echo "Error al registrar el pago: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "El campo 'fecha_pago' no se ha recibido correctamente.";
    }
}

// Cerrar la conexión
$conn->close();
?>
