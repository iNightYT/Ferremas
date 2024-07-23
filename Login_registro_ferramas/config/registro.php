<?php
// Incluye el archivo de conexión
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanea y valida las entradas del usuario
    $errors = [];

    // Sanitizar y validar el RUT
    $rut = trim($_POST['usuario_rut']);
    if (empty($rut) || !preg_match('/^\d{1,2}\.\d{3}\.\d{3}-[\dkK]$/', $rut)) {
        $errors[] = "El RUT debe seguir el formato xx.xxx.xxx-x o xx.xxx.xxx-K.";
    }
    $nombre = trim($_POST['usuario_nombre']);
    if (empty($nombre) || strlen($nombre) < 4) {
        $errors[] = "El nombre debe tener al menos 4 caracteres.";
    }
    $apellido = trim($_POST['usuario_apellido']);
    if (empty($apellido) || strlen($apellido) < 4) {
        $errors[] = "El apellido debe tener al menos 4 caracteres.";
    }
    // Sanitizar y validar el usuario
    $usuario = trim($_POST['usuario_usuario']);
    if (empty($usuario) || strlen($usuario) < 4) {
        $errors[] = "El usuario debe tener al menos 4 caracteres.";
    }

    // Sanitizar y validar la contraseña
    $contrasena = trim($_POST['usuario_clave']);
    $contrasena_confirmacion = trim($_POST['usuario_clave_confirmacion']);
    if (empty($contrasena) || strlen($contrasena) < 8) {
        $errors[] = "La contraseña debe tener al menos 8 caracteres.";
    }
    if ($contrasena !== $contrasena_confirmacion) {
        $errors[] = "Las contraseñas no coinciden.";
    }

    // Sanitizar y validar el email
    $email = filter_input(INPUT_POST, 'usuario_email', FILTER_SANITIZE_EMAIL);
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El email no es válido.";
    }

    // Verificar si hay errores antes de continuar
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
    } else {
        // Verifica si el usuario ya existe en la base de datos
        $stmt = $conn->prepare("SELECT usuario_id FROM usuario WHERE usuario_usuario = ?");
        if ($stmt) {
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                echo "<script>alert('El nombre de usuario ya está en uso.');</script>";
                exit;
            }
            $stmt->close();
        } else {
            echo "Error en la preparación de la declaración: " . $conn->error;
            exit;
        }

        // Verifica si el RUT ya está en uso
        $stmt = $conn->prepare("SELECT usuario_id FROM usuario WHERE usuario_rut = ?");
        if ($stmt) {
            $stmt->bind_param("s", $rut);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                echo "<script>alert('El RUT ya está registrado.');</script>";
                exit;
            }
            $stmt->close();
        } else {
            echo "Error en la preparación de la declaración: " . $conn->error;
            exit;
        }

        // Hash de la contraseña
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

        // Inserta el nuevo usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO usuario (usuario_rut, usuario_nombre, usuario_apellido, usuario_usuario, usuario_clave, usuario_email) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            // Aquí debes usar "ssssss" para indicar seis variables
            $stmt->bind_param("ssssss", $rut, $nombre, $apellido, $usuario, $hashed_password, $email);
            if ($stmt->execute()) {
                echo "<script>alert('Registro exitoso.');</script>";
                // Aquí puedes redirigir al usuario a otra página, por ejemplo:
                // header("Location:  ../login.php");
            } else {
                echo "Error en la ejecución de la declaración: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error en la preparación de la declaración: " . $conn->error;
        }
    }
}

$conn->close();
?>
