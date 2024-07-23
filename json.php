<?php
require './config/conexion.php';

try {
    // Realizar la consulta
    $sql = $pdo->prepare("SELECT producto_id, producto_nombre, producto_precio, producto_foto, producto_stock FROM producto");
    $sql->execute();

    // Obtener los resultados como un array asociativo
    $productos = $sql->fetchAll(PDO::FETCH_ASSOC);

    // Convertir el array a JSON
    $json_productos = json_encode($productos);

    // Mostrar el JSON
    echo $json_productos;

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>