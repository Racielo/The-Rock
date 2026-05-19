function setError(input, mensaje, errorDivId) {
    const errorDiv = document.getElementById(errorDivId);

    input.classList.remove("error");
    void input.offsetWidth;
    input.classList.add("error");

    errorDiv.textContent = mensaje;
}

function clearError(input, errorDivId) {
    const errorDiv = document.getElementById(errorDivId);

    input.classList.remove("error");
    errorDiv.textContent = "";
}

function login() {

    const correo = document.getElementById("correo");
    const password = document.getElementById("password");

    let valido = true;

    clearError(correo, "errorCorreo");
    clearError(password, "errorPassword");

    if (correo.value.trim() === "") {
        setError(correo, "El correo es obligatorio", "errorCorreo");
        valido = false;
    }

    if (password.value.trim() === "") {
        setError(password, "La contraseña es obligatoria", "errorPassword");
        valido = false;
    }

    if (!valido) return;

    fetch("login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `correo=${encodeURIComponent(correo.value)}&password=${encodeURIComponent(password.value)}`
    })
    .then(res => res.json())
    .then(data => {

        if (data.success) {
            window.location.href = "TheRock/?menu=usuarios";
        } else {
            setError(correo, "Datos incorrectos", "errorCorreo");
            setError(password, "Datos incorrectos", "errorPassword");
        }
    })
    .catch(() => {
        setError(correo, "Error del servidor", "errorCorreo");
        setError(password, "Error del servidor", "errorPassword");
    });
}
document.getElementById("formLogin").addEventListener("submit", function (e) {
    e.preventDefault(); // 👈 clave para que NO desaparezca nada

    const correo = document.getElementById("correo");
    const password = document.getElementById("password");

    let valido = true;

    clearError(correo, "errorCorreo");
    clearError(password, "errorPassword");

    if (correo.value.trim() === "") {
        setError(correo, "El correo es obligatorio", "errorCorreo");
        valido = false;
    }

    if (password.value.trim() === "") {
        setError(password, "La contraseña es obligatoria", "errorPassword");
        valido = false;
    }

    if (!valido) return;

    // 👇 aquí ahora SÍ enviamos el POST manualmente
    this.submit();
});