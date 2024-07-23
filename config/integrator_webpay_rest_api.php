<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function get_ws($data, $method, $type, $endpoint) {
    $curl = curl_init();
    if ($type == 'live') {
        $TbkApiKeyId = '597055555532';
        $TbkApiKeySecret = '579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C';
        $url = "https://webpay3g.transbank.cl" . $endpoint; // Live
    } else {
        $TbkApiKeyId = '597055555532';
        $TbkApiKeySecret = '579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C';
        $url = "https://webpay3gint.transbank.cl" . $endpoint; // Testing
    }
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            'Tbk-Api-Key-Id: ' . $TbkApiKeyId,
            'Tbk-Api-Key-Secret: ' . $TbkApiKeySecret,
            'Content-Type: application/json'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response);
}

$baseurl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$action = isset($_GET["action"]) ? $_GET["action"] : 'init';
$message = null;
$post_array = false;

switch ($action) {
    case "init":
        $message .= 'init';
        $buy_order = rand();
        $session_id = rand();
        $amount = isset($_POST['amount']) ? $_POST['amount'] : '0';
        $return_url = $baseurl . "?action=getResult";
        $type = "sandbox"; // Cambia a "live" para producción
        $data = json_encode(array(
            "buy_order" => (string)$buy_order,
            "session_id" => (string)$session_id,
            "amount" => (float)$amount,
            "return_url" => $return_url
        ));
        $method = 'POST';
        $endpoint = '/rswebpaytransaction/api/webpay/v1.0/transactions';
        $response = get_ws($data, $method, $type, $endpoint);
        $message .= "<pre>" . print_r($response, TRUE) . "</pre>";
        if (isset($response->url) && isset($response->token)) {
            $url_tbk = $response->url;
            $token = $response->token;
            $submit = 'Continuar!';
        } else {
            $message .= 'Error en la respuesta de la API';
        }
        break;

        case "getResult":
          $message .= "<pre>" . print_r($_POST, TRUE) . "</pre>";
          if (!isset($_POST["token_ws"]))
              break;
          $token = filter_input(INPUT_POST, 'token_ws');
          $data = '';
          $method = 'PUT';
          $type = 'sandbox'; // Cambia a "live" para producción
          $endpoint = '/rswebpaytransaction/api/webpay/v1.0/transactions/' . $token;
          $response = get_ws($data, $method, $type, $endpoint);
          $message .= "<pre>" . print_r($response, TRUE) . "</pre>";
  
          // Crear un formulario oculto para redirigir mediante POST
        echo '<form id="redirectForm" method="POST" action="/web/commit-pay.php">';
        echo '<input type="hidden" name="token_ws" value="' . htmlspecialchars($token) . '">';
        echo '<input type="hidden" name="response" value="' . htmlspecialchars(json_encode($response)) . '">';
        echo '</form>';
        echo '<script type="text/javascript">document.getElementById("redirectForm").submit();</script>';
        exit();
  
          break;

    case "getStatus":
        if (!isset($_POST["token_ws"]))
            break;
        $token = filter_input(INPUT_POST, 'token_ws');
        $data = '';
        $method = 'GET';
        $type = 'sandbox'; // Cambia a "live" para producción
        $endpoint = '/rswebpaytransaction/api/webpay/v1.0/transactions/' . $token;
        $response = get_ws($data, $method, $type, $endpoint);
        $message .= "<pre>" . print_r($response, TRUE) . "</pre>";
        $url_tbk = $baseurl . "?action=refund";
        $submit = 'Refund!';
        break;

    case "refund":
        if (!isset($_POST["token_ws"]))
            break;
        $token = filter_input(INPUT_POST, 'token_ws');
        $amount = 15000; // Define el monto a reembolsar
        $data = json_encode(array("amount" => (float)$amount));
        $method = 'POST';
        $type = 'sandbox'; // Cambia a "live" para producción
        $endpoint = '/rswebpaytransaction/api/webpay/v1.0/transactions/' . $token . '/refunds';
        $response = get_ws($data, $method, $type, $endpoint);
        $message .= "<pre>" . print_r($response, TRUE) . "</pre>";
        $submit = 'Crear nueva!';
        $url_tbk = $baseurl;
        break;
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Webpay Plus Mall">
    <meta name="author" content="VendoOnline.cl">
    <title>Pagos</title>
    <style>
        .container {
            height: 200px;
            position: relative;
            text-align: center;
        }
        .vertical-center {
            margin-top: 20%;
        }
        .lds-hourglass {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }
        .lds-hourglass:after {
            content: " ";
            display: block;
            border-radius: 50%;
            width: 0;
            height: 0;
            margin: 8px;
            box-sizing: border-box;
            border: 32px solid purple;
            border-color: purple transparent purple transparent;
            animation: lds-hourglass 1.2s infinite;
        }
        @keyframes lds-hourglass {
            0% {
                transform: rotate(0);
                animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
            }
            50% {
                transform: rotate(900deg);
                animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
            }
            100% {
                transform: rotate(1800deg);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="vertical-center">
            <div class="lds-hourglass"></div>
            <img src="WebpayPlus_FB_300px.png">
            <p><?php echo $message; ?></p>
            <?php if (isset($url_tbk) && isset($token)) { ?>
            <form name="brouterForm" id="brouterForm" method="POST" action="<?= $url_tbk ?>" style="display:block;">
                <input type="hidden" name="token_ws" value="<?= $token ?>" />
                <input type="submit" value="<?= $submit ?>" style="border: 1px solid #6b196b; border-radius: 4px; background-color: #6b196b; color: #fff; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 1.14rem; font-weight: 500; margin: auto 0 0; padding: 12px; position: relative; text-align: center; -webkit-transition: .2s ease-in-out; transition: .2s ease-in-out; max-width: 200px;" />
            </form>
            <script>
            var auto_refresh = setInterval(function() {
                submitform();
            }, 15000);

            function submitform() {
                document.brouterForm.submit();
            }
            </script>
            <?php } ?>
        </div>
    </div>
</body>
</html>
