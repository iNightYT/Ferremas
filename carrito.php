<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['producto_id'];
    $product_name = $_POST['producto_nombre'];
    $product_price = $_POST['producto_precio'];
    $product_stock = $_POST['producto_stock'];

    $quantity_in_cart = isset($_SESSION['cart'][$product_id]) ? $_SESSION['cart'][$product_id]['quantity'] : 0;

    if ($quantity_in_cart + 1 > $product_stock) {
        echo "<script>
                alert('No puedes agregar más de este producto al carrito, el stock es limitado.');
                window.location.href='catalogo.php';
              </script>";
    } else {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity']++;
        } else {
            $_SESSION['cart'][$product_id] = array(
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => 1
            );
        }

        header("Location: catalogo.php"); // Redirect back to catalog
        exit();
    }
}

if (isset($_POST['buy_now'])) {
    $product_id = $_POST['producto_id'];
    $product_name = $_POST['producto_nombre'];
    $product_price = $_POST['producto_precio'];
    $product_stock = $_POST['producto_stock'];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    if ($quantity > $product_stock) {
        echo "<script>
                alert('No puedes agregar más de este producto al carrito, el stock es limitado.');
                window.location.href='vista.php?producto_id={$product_id}';
              </script>";
        exit();
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$product_id])) {
        if ($_SESSION['cart'][$product_id]['quantity'] + $quantity > $product_stock) {
            echo "<script>
                    alert('No puedes agregar más de este producto al carrito, el stock es limitado.');
                    window.location.href='vista.php?producto_id={$product_id}';
                  </script>";
            exit();
        }
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = array(
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $quantity
        );
    }

    header("Location: carrito.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $product_id = $_GET['id'];
    if (isset($_SESSION['cart'][$product_id])) {
        if ($_SESSION['cart'][$product_id]['quantity'] > 1) {
            $_SESSION['cart'][$product_id]['quantity']--;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
    }
    header("Location: carrito.php");
    exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Carrito de Compras</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/catalogo.css" rel="stylesheet" type="text/css" media="all" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Power Tools Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
    <script src="js/jquery.min.js"></script>
</head>
<body>
    <!-- header -->
    <div class="banner1">
        <div class="container">
            <div class="header">
                <div class="H1">
                    <H1>FERREMAS</H1>
                </div>
                <?php include('navbar.php'); ?>
                <div class="clearfix"> </div>
            </div>    
        </div> 
    </div>
    <!-- header -->    
    <!-- content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Carrito de Compras</h1>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio unitario</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                if (!empty($_SESSION['cart'])) {
                                    foreach ($_SESSION['cart'] as $product_id => $product) {
                                        $product_name = $product['name'];
                                        $product_price = $product['price'];
                                        $product_quantity = $product['quantity'];
                                        $subtotal = $product_price * $product_quantity;
                                        $total += $subtotal;
                                        echo "<tr>
                                                <td>$product_name</td>
                                                <td>$".number_format($product_price, 0, '', '.')." CLP</td>
                                                <td>$product_quantity</td>
                                                <td>$".number_format($subtotal, 0, '', '.')." CLP</td>
                                                <td><a href='carrito.php?action=remove&id=$product_id'>Eliminar</a></td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Tu carrito está vacío</td></tr>";
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <?php
                                $iva = $total * 0.19;
                                $total_con_iva = $total + $iva;
                                ?>
                                <tr>
                                    <th colspan="3">Subtotal</th>
                                    <th colspan="2">$<?php echo number_format($total, 0, '', '.'); ?> CLP</th>
                                </tr>
                                <tr>
                                    <th colspan="3">IVA (19%)</th>
                                    <th colspan="2">$<?php echo number_format($iva, 0, '', '.'); ?> CLP</th>
                                </tr>
                                <tr>
                                    <th colspan="3">Total con IVA</th>
                                    <th colspan="2">$<?php echo number_format($total_con_iva, 0, '', '.'); ?> CLP</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- Botón para procesar pago -->
                    <?php if (!empty($_SESSION['cart'])): ?>
                        <div class="text-center">
                            <form action="pagar.php" method="post">
                                <input type="hidden" name="total" value="<?php echo $total_con_iva; ?>">
                                <button type="submit" class="btn btn-success btn-lg">Pagar</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    <!-- <div class="footer"> -->
        <!-- Footer content -->
    <!-- </div> -->
    <!-- footer -->

    <style>
    /* Estilo personalizado para las tarjetas de productos */
    .product-card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .product-card img {
        width: 50%;
        height: auto;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    .product-card .card-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .product-card .card-text {
        font-size: 16px;
        color: #666;
        margin-bottom: 15px;
    }

    .product-card .add-to-cart-btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 8px 12px;
        border-radius: 3px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .product-card .add-to-cart-btn:hover {
        background-color: #0056b3;
    }
    </style>
</body>
</html>
