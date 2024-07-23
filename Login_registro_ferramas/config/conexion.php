<?php
$servername = "localhost"; // Cambia esto si tu servidor no es localhost
$username = "root"; // Cambia esto a tu nombre de usuario de MySQL
$password = ""; // Cambia esto a tu contraseña de MySQL
$dbname = "inventario"; // Cambia esto al nombre de tu base de datos
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>