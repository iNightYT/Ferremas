<?php
session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
<title>FERREMAS</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Power Tools Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
 <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script src="js/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/magnific-popup.css">
<script type="text/javascript" src="js/move-top.js"></script>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
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
				/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
				};
				*/
		$().UItoTop({ easingType: 'easeOutQuart' });
});
</script>

</head>
<body>
	<!-- header -->
	<div class="banner">
		<div class="container">
			<div class="header">
				<div class="H1">
					<H1>FERREMAS</H1>
				</div>
				<div class="user">
				<?php if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']): ?>
					<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            Cuenta <span class="caret"></span>
        </button>
        <ul class="dropdown-menu custom-dropdown-menu" role="menu">
            <li><a href="\web\Login_registro_ferramas\login.php">Iniciar Sesión</a></li>
            <!-- Puedes agregar más opciones aquí -->
        </ul>
    </div>
					
					<?php else: ?>
        <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>. Estás logueado.</p>
		<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            Cuenta <span class="caret"></span>
        </button>
        <ul class="dropdown-menu custom-dropdown-menu" role="menu">
		<li>
			<a href=".\config\cerrar_sesion.php">Cerrar Sesión</a>
		</li>
		<li>
			<a href=".\historial_de_compras.php">Ver historial de compras</a>
		</li>
		<li>
			<a href="">Opciones</a>
		</li>
            <!-- Puedes agregar más opciones aquí -->
        </ul>
    </div>
    <?php endif; ?>
				</div>
				<?php include('navbar.php'); ?>
				<div class="clearfix"> </div>
						<!-- script-for-nav -->
					<script>
						$( "span.menu" ).click(function() {
						  $( ".head-nav ul" ).slideToggle(300, function() {
							// Animation complete.
						  });
						});
					</script>
				<!-- script-for-nav --> 	
			</div>	
			<div class="top-slide">
				<section class="slider">
						<div class="flexslider">
							<ul class="slides">
								<li>
									<div class="tittle">
										<h1>Amplia Gama de Productos</h1>
										<h2>Herramientas, Materiales de Construcción y Más</h2>
									</div>
								</li>
								<li>
									<div class="tittle">
										<h1>Calidad y Servicio</h1>
										<h2>Las Mejores Marcas del Mercado</h2>
									</div>
								</li>
								<li>	
									<div class="tittle">
										<h1>Experiencia y Confianza</h1>
										<h2>Más de 40 Años en el Sector</h2>	
									</div>
								</li>
							</ul>
						</div>
					</section>
				</div>
						<!-- FlexSlider -->
							  <script defer src="js/jquery.flexslider.js"></script>
							  <script type="text/javascript">
								$(function(){
								  SyntaxHighlighter.all();
								});
								$(window).load(function(){
								  $('.flexslider').flexslider({
									animation: "slide",
									start: function(slider){
									  $('body').removeClass('loading');
									}
								  });
								});
							  </script>
						<!-- FlexSlider -->
		</div> 
	</div>
<!-- header -->
<!-- prasent -->
	<div class="prasent">
		<div class="container">
			<h2>Distribuidora de Productos de Ferretería y Construcción</h2>
		</div>
	</div>
<!-- prasent -->
<!-- gravida -->
	<div class="gravida">
		<div class="container">
			<div class="col-md-6 gravida-left">
				<img src="images/img8.jpg" class="img-responsive" alt=""/>
					<div class="gravida-1">
						<p>FERREMAS ofrece una amplia variedad de herramientas y materiales de construcción. Contamos con productos de las mejores marcas del mercado, asegurando calidad y durabilidad en cada uno de ellos.</p>
						<a href="single.php" class="btn  btn-1c btn1 btn-1d">Más Información</a>
					</div>
			</div>
			<div class="col-md-6 gravida-right">
				<div class="gravida-botom">
					<div class="grabotom-left">
						<a href="#"><img src="images/img2.jpg" class="img-responsive" alt=""/></a>
					</div>
					<div class="grabotom-right">
						<h4><a href="services.php">Herramientas Manuales</a></h4>
						<p>Ofrecemos una amplia gama de herramientas manuales de marcas reconocidas como Bosch, Makita y Stanley, asegurando eficiencia y comodidad en su uso.</p>
							<a href="single.php" class="link">Leer Más</a>
					</div>
						<div class="clearfix"> </div>
				</div>
				<div class="gravida-botom">
					<div class="grabotom-left">
						<a href="#"><img src="images/img3.jpg" class="img-responsive" alt=""/></a>
					</div>
					<div class="grabotom-right">
						<h4><a href="services.php">Materiales de Construcción</a></h4>
						<p>Desde cemento y ladrillos hasta pinturas y materiales eléctricos, FERREMAS tiene todo lo que necesita para sus proyectos de construcción y renovación.</p>
							<a href="single.php" class="link">Leer Más</a>
					</div>
						<div class="clearfix"> </div>
				</div>
				<div class="gravida-botom">
					<div class="grabotom-left">
						<a href="#"><img src="images/img4.jpg" class="img-responsive" alt=""/></a>
					</div>
					<div class="grabotom-right">
						<h4><a href="services.php">Accesorios y Artículos de Seguridad</a></h4>
						<p>Proteja su inversión y seguridad con nuestros accesorios y artículos de seguridad. Trabajamos con las mejores marcas para garantizar su tranquilidad.</p>
							<a href="single.php" class="link">Leer Más</a>
					</div>
						<div class="clearfix"> </div>
				</div>
			</div>
		</div>
	</div>
<!-- gravida -->
<!-- product -->
	<div class="product">
		<div class="container">
			<h3>Nuestros Productos Destacados</h3>
				<div class="col-md-4 product-left">
					<div class="product-main">
						<a href="#"><img src="images/p1.jpg" alt="" class="img-responsive"></a>
						<div class="product-bottom">
							<h4>Taladro Inalámbrico Bosch</h4>
							<p>Alta eficiencia y durabilidad para trabajos pesados.</p>
								<a href="#" class="btn  btn-1c btn1 btn-1d">Ver Detalles</a>
						</div>
					</div>
				</div>
				<div class="col-md-4 product-left">
					<div class="product-main">
						<a href="#"><img src="images/p2.jpg" alt="" class="img-responsive"></a>
						<div class="product-bottom">
							<h4>Mezcladora de Concreto</h4>
							<p>Ideal para proyectos de construcción grandes y pequeños.</p>
								<a href="#" class="btn  btn-1c btn1 btn-1d">Ver Detalles</a>
						</div>
					</div>
				</div>
				<div class="col-md-4 product-left">
					<div class="product-main">
						<a href="#"><img src="images/p3.jpg" alt="" class="img-responsive"></a>
						<div class="product-bottom">
							<h4>Cortadora de Azulejos Makita</h4>
							<p>Precisión y potencia para cortes perfectos.</p>
								<a href="#" class="btn  btn-1c btn1 btn-1d">Ver Detalles</a>
						</div>
					</div>
				</div>
				<div class="clearfix"> </div>
		</div>
	</div>
<!-- product -->
<!-- client -->
	<div class="client">
		<div class="container">
			<div class="clearfix"> </div>
		</div>
	</div>
<!-- client -->
<!-- contact -->
	<div class="contact">
	</div>
<!-- contact -->
<!-- footer -->
<div class="footer">
	<div class="container">
		<div class="col-md-4 footer-left">
			<h4>Acerca de FERREMAS</h4>
			<p>FERREMAS es su distribuidor de confianza para todas sus necesidades de ferretería y construcción. Con más de 40 años en el mercado, ofrecemos productos de alta calidad y un servicio excepcional.</p>
		</div>
		<div class="col-md-4 footer-left">
			<h4>Enlaces Rápidos</h4>
			<ul>
				<li><a href="#">Inicio</a></li>
				<li><a href="#">Productos</a></li>
				<li><a href="#">Servicios</a></li>
				<li><a href="#">Contacto</a></li>
			</ul>
		</div>
		<div class="col-md-4 footer-left">
			<h4>Contacto</h4>
			<ul>
				<li><i class="glyphicon glyphicon-map-marker" aria-hidden="true"></i> Dirección: Calle Falsa 123, Ciudad</li>
				<li><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i> Teléfono: (123) 456-7890</li>
				<li><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i> Correo: contacto@ferremas.com</li>
			</ul>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
<!-- footer -->
</body>
</html>
