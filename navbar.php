<!-- navbar.php -->

<div class="head-nav">
    <span class="menu"> </span>
    <ul class="cl-effect-15">
        <li><a href="index.php">INICIO</a></li>
        <li><a href="catalogo.php" data-hover="CATALOGO">CATALOGO</a></li>
        <li><a href="about.php" data-hover="NOSOTROS">NOSOTROS</a></li>
        <li><a href="contact.php" data-hover="CONTACTO">CONTACTO</a></li>
        <li>
                        <a href="carrito.php" data-hover="CARRITO">
                            CARRITO <?php echo (!empty($_SESSION['cart'])) ? '(' . count($_SESSION['cart']) . ')' : ''; ?>
                        </a>
                    </li>
        <div class="clearfix"> </div>
    </ul>
</div>
<script>
    $( "span.menu" ).click(function() {
        $( ".head-nav ul" ).slideToggle(300, function() {
            // Animation complete.
        });
    });
</script>
