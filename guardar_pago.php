<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario'];
    $mes = $_POST['mes'];
    $anio = $_POST['anio'];
    $estado = $_POST['estado'];

    $sql = "INSERT INTO Pagos (id_usuario, mes, anio, estado) VALUES ('$id_usuario', '$mes', '$anio', '$estado')";

    if ($conn->query($sql) === TRUE) {
        echo "Pago registrado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
