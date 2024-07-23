<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FERREMAS</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">
        <div class="curved-shape"></div>
        <div class="curved-shape2"></div>
        <div class="form-box Login">
            <h2 class="animation" style="--D:0; --S:21;">Inicio de sesion</h2>
            <form id="loginForm" action=".\config\iniciar_sesion.php" method="post">
                <div class="input-box animation" style="--D:1; --S:22">
                    <input type="text" id="usuario_usuario" name="usuario_usuario" required>
                    <label for="usuario_usuario">Usuario</label>
                    <i class='bx bx-user'></i>
                </div>
                <div class="input-box animation" style="--D:2; --S:23">
                    <input type="password" id="usuario_clave" name="usuario_clave" required>
                    <label for="usuario_clave">Contraseña</label>
                    <i class='bx bx-lock-alt'></i>
                </div>
                <div class="input-box animation" style="--D:3; --S:24">
                    <button class="btn" type="submit">Entrar</button>
                </div>
                <div class="regi-link animation" style="--D:4; --S:25">
                    <p>No tienes una cuenta? <a href="#" class="SignUpLink">Registrarse</a></p>
                </div>
            </form>
        </div>
        <div class="info-content Login">
            <h2 class="animation" style="--D:0; --S:20">Ferramas</h2>
            <p class="animation" style="--D:1; --S:21">Inicia sesion para acceder al web de ferremas para comprar nuestros productos.</p>
        </div>
        <div class="form-box Register">
            <h2 class="animation" style="--li:17; --S:0">Registrarse</h2>
            <form action=".\config\registro.php" method="post">
                <div class="input-box animation" style="--li:18; --S:1">
                    <input type="email" id="usuario_email" name="usuario_email" required>
                    <label for="usuario_email">Email</label>
                    <i class='bx bx-envelope'></i>
                </div>
                <div class="input-box animation" style="--li:19; --S:2">
                    <input type="text" id="usuario_rut" name="usuario_rut" required>
                    <label for="usuario_rut">Rut</label>
                    <i class='bx bxs-id-card'></i>
                </div>
                <div class="input-box animation" style="--li:20; --S:3">
                    <input type="text" id="usuario_usuario" name="usuario_nombre" required>
                    <label for="usuario_usuario">Nombre</label>
                    <i class='bx bx-user'></i>
                </div>
                <div class="input-box animation" style="--li:20; --S:3">
                    <input type="text" id="usuario_usuario" name="usuario_apellido" required>
                    <label for="usuario_usuario">Apellido</label>
                    <i class='bx bx-user'></i>
                </div>
                <div class="input-box animation" style="--li:20; --S:3">
                    <input type="text" id="usuario_usuario" name="usuario_usuario" required>
                    <label for="usuario_usuario">Usuario</label>
                    <i class='bx bx-user'></i>
                </div>
                <div class="input-box animation" style="--li:21; --S:4">
                    <input type="password" id="usuario_clave" name="usuario_clave" required>
                    <label for="">Contraseña</label>
                    <i class='bx bx-lock-alt'></i>
                </div>
                <div class="input-box animation" style="--li:22; --S:5">
                    <input type="password" id="usuario_clave_confirmacion" name="usuario_clave_confirmacion" required>
                    <label for="usuario_clave_confirmacion">Confirmar contraseña</label>
                    <i class='bx bx-lock-alt'></i>
                </div>
                <div class="input-box animation" style="--li:23; --S:6">
                    <button class="btn" type="submit">Registar</button>
                </div>
                <div class="regi-link animation" style="--li:24; --S:7">
                    <p>Si ya tienes una cuenta <a href="#" class="SignInLink">Iniciar sesion</a></p>
                </div>
            </form>
        </div>
        <div class="info-content Register">
            <h2 class="animation" style="--li:17; --S:0">Ferramas</h2>
            <p class="animation" style="--li:18; --S:1">Completa el formulario para completar el registro.</p>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>