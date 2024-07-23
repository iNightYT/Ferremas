<?php
session_start();
require_once 'config/conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener el ID de la boleta desde la URL
$boleta_id = isset($_GET['boleta_id']) ? intval($_GET['boleta_id']) : 0;

if ($boleta_id > 0) {
    // Obtener los detalles de la boleta
    $sql = "SELECT b.boleta_id, b.boleta_fecha, b.boleta_total, 
                   p.producto_nombre, pb.cantidad, pb.precio_unitario
            FROM boleta b
            JOIN productos_boletas pb ON b.boleta_id = pb.boleta_id
            JOIN producto p ON pb.producto_id = p.producto_id
            WHERE b.boleta_id = :boleta_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':boleta_id', $boleta_id, PDO::PARAM_INT);
    $stmt->execute();
    $boleta = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($boleta) {
        $boleta_info = $boleta[0]; // Asumimos que solo hay un registro en la boleta
    } else {
        echo "Boleta no encontrada.";
        exit();
    }
} else {
    echo "ID de boleta no válido.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de la Boleta</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
    <!-- Navbar -->
    <div class="banner1">
        <div class="container">
            <div class="header">
                <div class="H1">
                    <h1>FERREMAS</h1>
                </div>
                <?php include('navbar.php'); ?>
                <div class="clearfix"> </div>
            </div>    
        </div> 
    </div>
    <!-- Navbar -->

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Detalle de la Boleta</h1>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID de Boleta</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo htmlspecialchars($boleta_info['boleta_id']); ?></td>
                                    <td><?php echo htmlspecialchars($boleta_info['boleta_fecha']); ?></td>
                                    <td>$<?php echo number_format($boleta_info['boleta_total'], 0, '', '.'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <h2>Productos</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($boleta as $item) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['producto_nombre']); ?></td>
                                        <td><?php echo htmlspecialchars($item['cantidad']); ?></td>
                                        <td>$<?php echo number_format($item['precio_unitario'], 0, '', '.'); ?></td>
                                        <td>$<?php echo number_format($item['cantidad'] * $item['precio_unitario'], 0, '', '.'); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>
