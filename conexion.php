<?php
$servername = "localhost";
$username = "root"; // Por defecto, el usuario de XAMPP es root
$password = ""; // Deja vacío por defecto
$dbname = "sistema_pagos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
