<?php
session_start();

// Verificar si el usuario NO ha iniciado sesión, redirigir a la página de inicio de sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Incluir el archivo de configuración de la base de datos
require_once 'config/conexion.php';

// Obtener el historial de compras del usuario actual
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT c.*, p.producto_nombre, p.producto_precio, b.boleta_id, b.boleta_fecha
        FROM productos_boletas c 
        JOIN producto p ON c.producto_id = p.producto_id
        JOIN boleta b ON c.boleta_id = b.boleta_id
        WHERE b.usuario_id = :usuario_id
        ORDER BY b.boleta_fecha DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
$stmt->execute();
$compras = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Compras</title>
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
                    <h1>Historial de Compras</h1>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Fecha de Compra</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Total</th>
                                    <th>Boleta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($compras as $compra) { ?>
                                    <tr>
                                        <td><?php echo $compra['boleta_fecha']; ?></td>
                                        <td><?php echo $compra['producto_nombre']; ?></td>
                                        <td><?php echo $compra['cantidad']; ?></td>
                                        <td>$<?php echo number_format($compra['producto_precio'], 0, '', '.'); ?></td>
                                        <td>$<?php echo number_format($compra['cantidad'] * $compra['producto_precio'], 0, '', '.'); ?></td>
                                        <td><a href="ver_boleta.php?boleta_id=<?php echo $compra['boleta_id']; ?>">Ver Boleta</a></td>
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
