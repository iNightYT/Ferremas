const container=document.querySelector('.container');
const LoginLink=document.querySelector('.SignUpLink');
const RegisterLink=document.querySelector('.SignInLink');
RegisterLink.addEventListener('click',()=>{
    container.classList.remove('active');
})
LoginLink.addEventListener('click',()=>{
    container.classList.add('active');
})
document.addEventListener("DOMContentLoaded", function() {
    // Encuentra el formulario de inicio de sesión por su ID
    const loginForm = document.getElementById("loginForm");

    if (loginForm) {
        loginForm.addEventListener("submit", function(event) {
            // Obtiene los valores de usuario y contraseña
            const usuario = document.getElementById("usuario_usuario").value;
            const clave = document.getElementById("usuario_clave").value;

            // Verifica si las credenciales son correctas
            if (usuario === "Administrador" && clave === "Administrador") {
                // Previene el envío del formulario
                 // Simula el inicio de sesión exitoso (puedes hacer una solicitud AJAX aquí)
                 console.log("Inicio de sesión exitoso para el usuario Administrador");

                event.preventDefault();
                // Redirige a la ruta especificada
                window.location.href = "../INVENTARIO-main/index.php";
            }
        });
    }
});