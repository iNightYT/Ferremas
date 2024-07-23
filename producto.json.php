<?php
require './config/conexion.php'; // Incluye la conexión a la base de datos

// Obtener el ID del producto desde la URL
$producto_id = isset($_GET['producto_id']) ? intval($_GET['producto_id']) : 0;

if ($producto_id > 0) {
    $sql = $pdo->prepare("SELECT producto_id, producto_nombre, producto_descripcion, producto_precio, producto_foto, producto_stock FROM producto WHERE producto_id = :producto_id");
    $sql->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
    $sql->execute();
    $producto = $sql->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        echo json_encode($producto);
    } else {
        echo json_encode(['error' => 'Producto no encontrado']);
    }
} else {
    echo json_encode(['error' => 'ID de producto inválido']);
}
?>
