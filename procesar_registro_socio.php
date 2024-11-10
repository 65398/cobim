<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['cedula'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $laborando = $_POST['laborando'];
    $lugar_trabajo = isset($_POST['lugar_trabajo']) ? $_POST['lugar_trabajo'] : null;
    $cargo = isset($_POST['cargo']) ? $_POST['cargo'] : null;
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Cifrar contraseña

    $sql = "INSERT INTO Usuarios (cedula, nombres, apellidos, telefono, correo, direccion, laborando, lugar_trabajo, cargo, rol, password)
            VALUES ('$cedula', '$nombres', '$apellidos', '$telefono', '$correo', '$direccion', '$laborando', '$lugar_trabajo', '$cargo', 'socio', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Socio registrado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
