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

    header("Location: catalogo.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $product_id = $_GET['id'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    header("Location: carrito.php");
    exit();
}

$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $product) {
        $total += $product['price'] * $product['quantity'];
    }
}

$iva = $total * 0.19;
$total_con_iva = $total + $iva;
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Carrito de Compras</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/catologo.css" rel="stylesheet" type="text/css" media="all" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Power Tools Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript">
           function calcularPagoFinal() {
            const total = <?php echo $total_con_iva; ?>;
    const envio = document.getElementById('envio').value;
    let costoEnvio = 0;
    if (envio === 'envio') {
        costoEnvio = 1200;
    }
    const precioFinal = total + costoEnvio;

    // Formatear el precio con separador de miles
    const precioFinalFormateado = precioFinal.toLocaleString('es-CL', { style: 'currency', currency: 'CLP' });

    document.getElementById('precioFinal').innerText = `Precio final: ${precioFinalFormateado} CLP`;
    document.getElementById('hiddenTotal').value = precioFinal;
        }
        var RegionesYcomunas = {

	"regiones": [{
			"NombreRegion": "Arica y Parinacota",
			"comunas": ["Arica", "Camarones", "Putre", "General Lagos"]
	},
		{
			"NombreRegion": "Tarapacá",
			"comunas": ["Iquique", "Alto Hospicio", "Pozo Almonte", "Camiña", "Colchane", "Huara", "Pica"]
	},
		{
			"NombreRegion": "Antofagasta",
			"comunas": ["Antofagasta", "Mejillones", "Sierra Gorda", "Taltal", "Calama", "Ollagüe", "San Pedro de Atacama", "Tocopilla", "María Elena"]
	},
		{
			"NombreRegion": "Atacama",
			"comunas": ["Copiapó", "Caldera", "Tierra Amarilla", "Chañaral", "Diego de Almagro", "Vallenar", "Alto del Carmen", "Freirina", "Huasco"]
	},
		{
			"NombreRegion": "Coquimbo",
			"comunas": ["La Serena", "Coquimbo", "Andacollo", "La Higuera", "Paiguano", "Vicuña", "Illapel", "Canela", "Los Vilos", "Salamanca", "Ovalle", "Combarbalá", "Monte Patria", "Punitaqui", "Río Hurtado"]
	},
		{
			"NombreRegion": "Valparaíso",
			"comunas": ["Valparaíso", "Casablanca", "Concón", "Juan Fernández", "Puchuncaví", "Quintero", "Viña del Mar", "Isla de Pascua", "Los Andes", "Calle Larga", "Rinconada", "San Esteban", "La Ligua", "Cabildo", "Papudo", "Petorca", "Zapallar", "Quillota", "Calera", "Hijuelas", "La Cruz", "Nogales", "San Antonio", "Algarrobo", "Cartagena", "El Quisco", "El Tabo", "Santo Domingo", "San Felipe", "Catemu", "Llaillay", "Panquehue", "Putaendo", "Santa María", "Quilpué", "Limache", "Olmué", "Villa Alemana"]
	},
		{
			"NombreRegion": "Región del Libertador Gral. Bernardo O’Higgins",
			"comunas": ["Rancagua", "Codegua", "Coinco", "Coltauco", "Doñihue", "Graneros", "Las Cabras", "Machalí", "Malloa", "Mostazal", "Olivar", "Peumo", "Pichidegua", "Quinta de Tilcoco", "Rengo", "Requínoa", "San Vicente", "Pichilemu", "La Estrella", "Litueche", "Marchihue", "Navidad", "Paredones", "San Fernando", "Chépica", "Chimbarongo", "Lolol", "Nancagua", "Palmilla", "Peralillo", "Placilla", "Pumanque", "Santa Cruz"]
	},
		{
			"NombreRegion": "Región del Maule",
			"comunas": ["Talca", "ConsVtución", "Curepto", "Empedrado", "Maule", "Pelarco", "Pencahue", "Río Claro", "San Clemente", "San Rafael", "Cauquenes", "Chanco", "Pelluhue", "Curicó", "Hualañé", "Licantén", "Molina", "Rauco", "Romeral", "Sagrada Familia", "Teno", "Vichuquén", "Linares", "Colbún", "Longaví", "Parral", "ReVro", "San Javier", "Villa Alegre", "Yerbas Buenas"]
	},
		{
			"NombreRegion": "Región del Biobío",
			"comunas": ["Concepción", "Coronel", "Chiguayante", "Florida", "Hualqui", "Lota", "Penco", "San Pedro de la Paz", "Santa Juana", "Talcahuano", "Tomé", "Hualpén", "Lebu", "Arauco", "Cañete", "Contulmo", "Curanilahue", "Los Álamos", "Tirúa", "Los Ángeles", "Antuco", "Cabrero", "Laja", "Mulchén", "Nacimiento", "Negrete", "Quilaco", "Quilleco", "San Rosendo", "Santa Bárbara", "Tucapel", "Yumbel", "Alto Biobío", "Chillán", "Bulnes", "Cobquecura", "Coelemu", "Coihueco", "Chillán Viejo", "El Carmen", "Ninhue", "Ñiquén", "Pemuco", "Pinto", "Portezuelo", "Quillón", "Quirihue", "Ránquil", "San Carlos", "San Fabián", "San Ignacio", "San Nicolás", "Treguaco", "Yungay"]
	},
		{
			"NombreRegion": "Región de la Araucanía",
			"comunas": ["Temuco", "Carahue", "Cunco", "Curarrehue", "Freire", "Galvarino", "Gorbea", "Lautaro", "Loncoche", "Melipeuco", "Nueva Imperial", "Padre las Casas", "Perquenco", "Pitrufquén", "Pucón", "Saavedra", "Teodoro Schmidt", "Toltén", "Vilcún", "Villarrica", "Cholchol", "Angol", "Collipulli", "Curacautín", "Ercilla", "Lonquimay", "Los Sauces", "Lumaco", "Purén", "Renaico", "Traiguén", "Victoria", ]
	},
		{
			"NombreRegion": "Región de Los Ríos",
			"comunas": ["Valdivia", "Corral", "Lanco", "Los Lagos", "Máfil", "Mariquina", "Paillaco", "Panguipulli", "La Unión", "Futrono", "Lago Ranco", "Río Bueno"]
	},
		{
			"NombreRegion": "Región de Los Lagos",
			"comunas": ["Puerto Montt", "Calbuco", "Cochamó", "Fresia", "FruVllar", "Los Muermos", "Llanquihue", "Maullín", "Puerto Varas", "Castro", "Ancud", "Chonchi", "Curaco de Vélez", "Dalcahue", "Puqueldón", "Queilén", "Quellón", "Quemchi", "Quinchao", "Osorno", "Puerto Octay", "Purranque", "Puyehue", "Río Negro", "San Juan de la Costa", "San Pablo", "Chaitén", "Futaleufú", "Hualaihué", "Palena"]
	},
		{
			"NombreRegion": "Región Aisén del Gral. Carlos Ibáñez del Campo",
			"comunas": ["Coihaique", "Lago Verde", "Aisén", "Cisnes", "Guaitecas", "Cochrane", "O’Higgins", "Tortel", "Chile Chico", "Río Ibáñez"]
	},
		{
			"NombreRegion": "Región de Magallanes y de la AntárVca Chilena",
			"comunas": ["Punta Arenas", "Laguna Blanca", "Río Verde", "San Gregorio", "Cabo de Hornos (Ex Navarino)", "AntárVca", "Porvenir", "Primavera", "Timaukel", "Natales", "Torres del Paine"]
	},
		{
			"NombreRegion": "Región Metropolitana de Santiago",
			"comunas": ["Cerrillos", "Cerro Navia", "Conchalí", "El Bosque", "Estación Central", "Huechuraba", "Independencia", "La Cisterna", "La Florida", "La Granja", "La Pintana", "La Reina", "Las Condes", "Lo Barnechea", "Lo Espejo", "Lo Prado", "Macul", "Maipú", "Ñuñoa", "Pedro Aguirre Cerda", "Peñalolén", "Providencia", "Pudahuel", "Quilicura", "Quinta Normal", "Recoleta", "Renca", "San Joaquín", "San Miguel", "San Ramón", "Vitacura", "Puente Alto", "Pirque", "San José de Maipo", "Colina", "Lampa", "TilVl", "San Bernardo", "Buin", "Calera de Tango", "Paine", "Melipilla", "Alhué", "Curacaví", "María Pinto", "San Pedro", "Talagante", "El Monte", "Isla de Maipo", "Padre Hurtado", "Peñaflor"]
	}]
}


jQuery(document).ready(function () {

	var iRegion = 0;
	var htmlRegion = '<option value="sin-region">Seleccione región</option><option value="sin-region">--</option>';
	var htmlComunas = '<option value="sin-region">Seleccione comuna</option><option value="sin-region">--</option>';

	jQuery.each(RegionesYcomunas.regiones, function () {
		htmlRegion = htmlRegion + '<option value="' + RegionesYcomunas.regiones[iRegion].NombreRegion + '">' + RegionesYcomunas.regiones[iRegion].NombreRegion + '</option>';
		iRegion++;
	});

	jQuery('#regiones').html(htmlRegion);
	jQuery('#comunas').html(htmlComunas);

	jQuery('#regiones').change(function () {
		var iRegiones = 0;
		var valorRegion = jQuery(this).val();
		var htmlComuna = '<option value="sin-comuna">Seleccione comuna</option><option value="sin-comuna">--</option>';
		jQuery.each(RegionesYcomunas.regiones, function () {
			if (RegionesYcomunas.regiones[iRegiones].NombreRegion == valorRegion) {
				var iComunas = 0;
				jQuery.each(RegionesYcomunas.regiones[iRegiones].comunas, function () {
					htmlComuna = htmlComuna + '<option value="' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '">' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '</option>';
					iComunas++;
				});
			}
			iRegiones++;
		});
		jQuery('#comunas').html(htmlComuna);
	});
	jQuery('#comunas').change(function () {
		if (jQuery(this).val() == 'sin-region') {
			alert('selecciones Región');
		} else if (jQuery(this).val() == 'sin-comuna') {
			alert('selecciones Comuna');
		}
	});
	jQuery('#regiones').change(function () {
		if (jQuery(this).val() == 'sin-region') {
			alert('selecciones Región');
		}
	});

});
    </script>
</head>
<body>
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

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                  
                    
                 <!-- Formulario de pago -->
                 <?php if (!empty($_SESSION['cart'])): ?>
                        <div class="text-center">
                            <h2>Información de Pagos</h2>
                            <label for="envio">Método de Entrega:</label>
                            <select id="envio" class="form-control" onchange="calcularPagoFinal()">
                                <option value="retiro">Retiro en tienda</option>
                                <option value="envio">Envío a domicilio (Costo: $1200 CLP)</option>
                            </select>
                          

                            <form action="./config/integrator_webpay_rest_api.php" method="post" class="mt-3">
                                <input type="hidden" name="amount" id="hiddenTotal" value="<?php echo $total; ?>">
                                
                                <div class="form-group">
                                    <label for="direccion">Dirección:</label>
                                    <input type="text" id="direccion" name="direccion" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="regiones">Región:</label>
                                    <select id="regiones" class="form-control"></select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="comunas">Comuna:</label>
                                    <select id="comunas" class="form-control"></select>
                                </div>
								<div class="form-group">
                                    <label for="metodo_pago">Método de Pago:</label>
                                    <select id="metodo_pago" name="metodo_pago" class="form-control" onchange="mostrarBotonesPago()">
                                        <option value="webpay">Webpay</option>
                                        <option value="transferencia">Transferencia Bancaria</option>
                                    </select>
                                </div>

                                <div id="botones_pago" class="mt-3">
                                    <button type="submit" id="btn_webpay" class="btn btn-success btn-lg">Pagar con Webpay</button>
                                    <a id="btn_transferencia" href="config\wsp_api.php" class="btn btn-primary btn-lg" style="display:none;">
                                        <img src="images\whatsapp-logo.webp" alt="WhatsApp" style="height: 24px; width: auto;"> Pagar por Transferencia
                                    </a>
                                </div>
                            </form>

                            <div class="result mt-3" id="precioFinal">Pago Final: $<?php echo number_format($total_con_iva, 0, '', '.'); ?> CLP</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <style>
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
        display: inline-block;
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .product-card .add-to-cart-btn:hover {
        background-color: #0056b3;
    }
    </style>

    <script>
    function mostrarBotonesPago() {
        var metodoPago = document.getElementById('metodo_pago').value;
        var btnWebpay = document.getElementById('btn_webpay');
        var btnTransferencia = document.getElementById('btn_transferencia');

        if (metodoPago === 'webpay') {
            btnWebpay.style.display = 'inline-block';
            btnTransferencia.style.display = 'none';
        } else if (metodoPago === 'transferencia') {
            btnWebpay.style.display = 'none';
            btnTransferencia.style.display = 'inline-block';
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        calcularPagoFinal();
        mostrarBotonesPago();
    });
    </script>
</body>
</html>