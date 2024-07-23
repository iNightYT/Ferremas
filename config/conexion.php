<?php
// Datos de conexión a la base de datos
$host = 'localhost';
$dbname = 'inventario';
$username = 'root';
$password = '';

// Intentar conectar
try {
    $pdo = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Manejo de errores
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>