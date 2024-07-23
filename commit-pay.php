<?php
session_start();
require './config/conexion.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>FERREMAS</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Power Tools Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/magnific-popup.css">
    <script type="text/javascript" src="js/move-top.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){        
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top},1200);
            });
        });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
            $().UItoTop({ easingType: 'easeOutQuart' });
    });
    </script>

</head>
<body>
    <!-- header -->
    <div class="banner-compra">
        <div class="container">
            <div class="header">
                <div class="H1">
                    <H1>FERREMAS</H1>
                </div>
                <?php include('navbar.php'); ?>
            </div>    
                
        </div> 
    </div>
    <!-- header -->
    <!-- prasent -->
        
    <!-- prasent -->
    <!-- gravida -->
    <div class="gravida-pago">
        <h1>Comprobante de pago</h1>
        <div class="container">
            <div id="voucher" class="m-5">
                <?php
                $userId = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['token_ws']) && isset($_POST['response'])) {
                        $token = htmlspecialchars($_POST['token_ws']);
                        $response = json_decode($_POST['response'], true);
                
                        if ($response && isset($response['status'])) {
                            if ($response['status'] === 'AUTHORIZED') {
                                $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
                                
                                if ($userId && !empty($cart)) {
                                    $invoiceDate = date('Y-m-d H:i:s');
                                    $invoiceTotal = array_sum(array_map(function($item) {
                                        return $item['price'] * $item['quantity'];
                                    }, $cart));

                                    // Calcular el IVA
                                    $iva = $invoiceTotal * 0.19;
                                    $totalConIva = $invoiceTotal + $iva;
                                    
                                    try {
                                        // Inicia la transacción
                                        $pdo->beginTransaction();
                
                                        // Verificar si el usuario existe en la base de datos
                                        $stmt_user = $pdo->prepare("SELECT * FROM usuario WHERE usuario_id = ?");
                                        $stmt_user->execute([$userId]);
                                        $userExists = $stmt_user->fetch();
                
                                        if (!$userExists) {
                                            throw new Exception("El usuario con ID $userId no existe.");
                                        }
                
                                        // Insertar en la tabla boleta
                                        $stmt = $pdo->prepare("INSERT INTO boleta (boleta_fecha, boleta_total, usuario_id) VALUES (?, ?, ?)");
                                        $stmt->execute([$invoiceDate, $totalConIva, $userId]);
                
                                        // Obtener el último ID insertado
                                        $invoiceId = $pdo->lastInsertId();
                
                                        if ($invoiceId) {
                                            // Insertar en la tabla productos_boletas
                                            $stmt_product = $pdo->prepare("INSERT INTO productos_boletas (boleta_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
                                            $stmt_stock = $pdo->prepare("UPDATE producto SET producto_stock = producto_stock - ? WHERE producto_id = ?");
                                            foreach ($cart as $product_id => $item) {
                                                $quantity = $item['quantity'];
                                                $unit_price = $item['price'];
                                                $stmt_product->execute([$invoiceId, $product_id, $quantity, $unit_price]);
                                                $stmt_stock->execute([$quantity, $product_id]);
                                            }
                                            
                                            // Confirmar la transacción
                                            $pdo->commit();
                
                                            echo "<p>El pago se a realizado con exito, el carrito esta vacio.</p>";
                                            echo "<h3>Detalles de la boleta</h3>";
                                            echo "<p>ID de la boleta: $invoiceId</p>";
                                            echo "<p>Fecha: $invoiceDate</p>";
                                            echo "<p>Total: $" . number_format($totalConIva, 0, '', '.') . " CLP</p>";
                                            echo "<h4>Productos:</h4>";
                                            echo "<ul>";
                                            foreach ($cart as $item) {
                                                echo "<li>{$item['name']} - Cantidad: {$item['quantity']} - Precio unitario: $" . number_format($item['price'], 0, '', '.') . " CLP</li>";
                                            }
                                            echo "</ul>";
                
                                            // Vaciar el carrito
                                            unset($_SESSION['cart']);
                                        } else {
                                            throw new Exception("Error al obtener el ID de la boleta.");
                                        }
                                    } catch (Exception $e) {
                                        // Deshacer la transacción en caso de error
                                        $pdo->rollBack();
                                        echo "<p>Hubo un error en crear la boleta: " . $e->getMessage() . "</p>";
                                    }
                                } else {
                                    echo "<p>Hubo un error en crear la boleta, intentalo mas tarde.</p>";
                                }
                            } elseif ($response['status'] === 'FAILED') {
                                echo "<p>El pago no se a realizado, intentalo de nuevo.</p>";
                            } else {
                                echo "<p>Unrecognized transaction status.</p>";
                            }
                        } else {
                            echo 'Invalid response format.';
                        }
                    } else {
                        echo 'No data received.';
                    }
                } else {
                    echo 'Invalid request method.';
                }
                ?>
            </div>
        </div>
    </div>
    <noscript>
        We are sorry, your browser does not support JavaScript or it is disabled, so the site will have issues functioning properly.
    </noscript>
    <!-- gravida -->

    <!-- footer -->
    <!-- footer -->
</body>
</html>
