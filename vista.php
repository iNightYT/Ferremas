<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$producto_id = isset($_GET['producto_id']) ? intval($_GET['producto_id']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Power Tools Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
    <script src="js/jquery.min.js"></script>
</head>
<body class="bg-background text-foreground font-body">
    <!-- header -->
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
    <!-- header -->    
    <div class="container mx-auto p-4">
        <div id="producto-details" class="grid md:grid-cols-2 gap-8 lg:gap-16 items-start max-w-7xl mx-auto py-8">
            <!-- Detalles del producto se cargarán aquí -->
        </div>
    </div>
    <script>
    $(document).ready(function() {
        var productoId = <?php echo $producto_id; ?>;
        if (productoId > 0) {
            $.getJSON('producto.json.php?producto_id=' + productoId, function(data) {
                if (data.error) {
                    $('#producto-details').html('<div class="text-center"><p class="text-xl">' + data.error + '</p></div>');
                } else {
                    var imagen = 'INVENTARIO-main/img/producto/' + data.producto_foto;
                    if (!imagenExists(imagen)) {
                        imagen = 'no_existe.jpg';
                    }
                    
                    var productoHtml = '<div>' +
                        '<img src="' + imagen + '" alt="Product Image" class="aspect-[2/3] object-cover border w-full rounded-lg overflow-hidden" />' +
                        '</div>' +
                        '<div class="grid gap-8">' +
                        '<div>' +
                        '<h1 class="font-bold text-4xl lg:text-5xl">' + data.producto_nombre + '</h1>' +
                        '<p class="text-muted-foreground text-lg lg:text-xl">' + data.producto_descripcion + '</p>' +
                        '</div>' +
                        '<div class="flex items-center justify-between">' +
                        '<div class="text-5xl font-bold">$' + parseFloat(data.producto_precio).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.') + '</div>' +
                        (data.producto_stock > 0 ? 
                            '<span class="badge-outline px-4 py-2 border rounded text-lg text-green-600">Disponible (' + data.producto_stock + ')</span>' :
                            '<span class="badge-outline px-4 py-2 border rounded text-lg text-red-600">Agotado</span>') +
                        '</div>' +
                        '<div class="grid gap-6">' +
                        (data.producto_stock > 0 ? 
                            '<form method="post" action="carrito.php">' +
                            '<div class="grid gap-4">' +
                            '<label for="quantity" class="text-lg lg:text-xl">Cantidad</label>' +
                            '<select id="quantity" name="quantity" class="w-32 border p-3 rounded">' +
                            getQuantityOptions(data.producto_stock) +
                            '</select>' +
                            '</div>' +
                            '<input type="hidden" name="producto_id" value="' + data.producto_id + '">' +
                            '<input type="hidden" name="producto_nombre" value="' + data.producto_nombre + '">' +
                            '<input type="hidden" name="producto_precio" value="' + data.producto_precio + '">' +
                            '<input type="hidden" name="producto_stock" value="' + data.producto_stock + '">' +
                            '<button type="submit" name="buy_now" class="bg-blue-500 text-white py-3 px-6 rounded-lg text-xl">Comprar</button>' +
                            '</form>' :
                            '') +
                        '</div>' +
                        '</div>';

                    $('#producto-details').html(productoHtml);
                }
            });
        }

        function imagenExists(url) {
            var http = new XMLHttpRequest();
            http.open('HEAD', url, false);
            http.send();
            return http.status != 404;
        }

        function getQuantityOptions(maxQuantity) {
            var options = '';
            for (var i = 1; i <= maxQuantity; i++) {
                options += '<option value="' + i + '">' + i + '</option>';
            }
            return options;
        }
    });
    </script>
</body>
</html>
