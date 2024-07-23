<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$hay_productos_sin_stock = false;
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Lista de Productos</title>
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
                <h2>Productos en Stock</h2>
                <div id="productos-en-stock"></div>
            </div>
            <div class="row">
                <h2>Productos Sin Stock</h2>
                <div id="productos-sin-stock"></div>
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

    .product-card.out-of-stock .out-of-stock-text {
        font-size: 16px;
        color: red;
        font-weight: bold;
    }
    </style>

    <script>
    $(document).ready(function() {
        $.getJSON('json.php', function(data) {
            var productosEnStock = '';
            var productosSinStock = '';

            $.each(data, function(index, producto) {
                var imagen = 'INVENTARIO-main/img/producto/' + producto.producto_foto;
                if (!imagenExists(imagen)) {
                    imagen = 'no_existe.jpg';
                }

                var productCard = '<div class="col-md-3">' +
                    '<div class="product-card">' +
                    '<img src="' + imagen + '" class="card-img-top" alt="Producto">' +
                    '<div class="card-body">' +
                    '<a href="vista.php?producto_id=' + producto.producto_id + '">' +
                    '<h5 class="card-title">' + producto.producto_nombre + '</h5>' +
                    '</a>' +
                    '<p class="card-text">Precio: $' + producto.producto_precio.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.') + '</p>' +
                    (producto.producto_stock > 0 ? 
                        '<form method="post" action="carrito.php">' +
                        '<input type="hidden" name="producto_id" value="' + producto.producto_id + '">' +
                        '<input type="hidden" name="producto_nombre" value="' + producto.producto_nombre + '">' +
                        '<input type="hidden" name="producto_precio" value="' + producto.producto_precio + '">' +
                        '<input type="hidden" name="producto_stock" value="' + producto.producto_stock + '">' +
                        '<input type="submit" name="add_to_cart" value="Añadir al Carrito" class="add-to-cart-btn">' +
                        '</form>' : 
                        '<p class="out-of-stock-text">Sin stock</p>'
                    ) +
                    '</div>' +
                    '</div>' +
                    '</div>';

                if (producto.producto_stock > 0) {
                    productosEnStock += productCard;
                } else {
                    productosSinStock += productCard;
                }
            });

            $('#productos-en-stock').html(productosEnStock);
            $('#productos-sin-stock').html(productosSinStock);
        });

        function imagenExists(url) {
            var http = new XMLHttpRequest();
            http.open('HEAD', url, false);
            http.send();
            return http.status != 404;
        }
    });
    </script>
</body>
</html>
