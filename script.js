document.addEventListener("DOMContentLoaded", function() {
    const dropdownToggle = document.getElementById("dropdownToggle");
    const dropdownMenu = document.getElementById("dropdownMenu");

    dropdownToggle.addEventListener("click", function() {
        if (dropdownMenu.style.display === "block") {
            dropdownMenu.style.display = "none";
        } else {
            dropdownMenu.style.display = "block";
        }
    });

    // Cerrar el menú si se hace clic fuera de él
    window.addEventListener("click", function(event) {
        if (!event.target.matches('#dropdownToggle')) {
            if (dropdownMenu.style.display === "block") {
                dropdownMenu.style.display = "none";
            }
        }
    });
});