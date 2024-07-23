<?php
session_start(); // Inicia la sesión al principio del script

// Incluye el archivo de conexión
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanea y valida las entradas del usuario
    if (isset($_POST['usuario_usuario']) && isset($_POST['usuario_clave'])) {
        $usuario = trim($_POST['usuario_usuario']);
        $contrasena = trim($_POST['usuario_clave']);
        
        // Verifica que las entradas no estén vacías
        if (empty($usuario) || empty($contrasena)) {
            echo "El usuario y la contraseña son requeridos.";
            exit;
        }

        // Utiliza declaraciones preparadas para evitar inyecciones SQL
        $stmt = $conn->prepare("SELECT usuario_id, usuario_clave FROM usuario WHERE usuario_usuario = ?");
        if ($stmt) {
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($contrasena, $row['usuario_clave'])) {
                    // Inicio de sesión exitoso
                    $_SESSION['loggedin'] = true;
                    $_SESSION['usuario_id'] = $row['usuario_id'];
                    $_SESSION['usuario'] = $usuario; // Puedes almacenar más información si es necesario

                    // Redirige al usuario a la página principal
                    header("Location: ../../index.php");
                    exit;
                } else {
                    echo "Contraseña incorrecta.";
                }
            } else {
                echo "Usuario no encontrado.";
            }

            $stmt->close();
        } else {
            echo "Error en la preparación de la declaración: " . $conn->error;
        }
    } else {
        echo "El usuario y la contraseña son requeridos.";
    }
}

$conn->close();
?>
