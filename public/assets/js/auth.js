function login() {

    const correo = document.getElementById("correo").value;
    const password = document.getElementById("password").value;

    if(correo === "admin@gmail.com" && password === "123456"){

        alert("Bienvenido 👨‍🍳");

        window.location.href = "/The-Rock/?controller=usuario&action=index";

    } else {
        alert("Correo o contraseña incorrectos");
    }
}

function registrar() {
    alert("Registro simulado");
}

function cerrarModal() {
    document.getElementById("modal").style.display = "none";
}