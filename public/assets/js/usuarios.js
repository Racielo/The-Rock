/* =========================
   MODAL AGREGAR
========================= */

function abrirModal() {
    document.getElementById("modalUsuario").style.display = "flex";
}

function cerrarModal() {
    document.getElementById("modalUsuario").style.display = "none";
}

/* =========================
   MODAL EDITAR
========================= */

function abrirEditar(id, nombre, correo, estado) {

    document.getElementById("modalEditar").style.display = "flex";

    document.getElementById("editNombre").value = nombre;
    document.getElementById("editCorreo").value = correo;
    document.getElementById("editEstado").value = estado;

    document.getElementById("formEditar").action = "?menu=usuario&accion=editar&id=" + id;
}

function cerrarEditar() {
    document.getElementById("modalEditar").style.display = "none";
}

/* =========================
   BUSCADOR
========================= */

function buscarUsuarios() {

    let input = document.getElementById("buscarUsuario")
        .value
        .toLowerCase();

    let filas = document.getElementById("tablaUsuarios")
        .getElementsByTagName("tr");

    for (let i = 1; i < filas.length; i++) {

        let texto = filas[i].textContent.toLowerCase();

        filas[i].style.display = texto.includes(input) ? "" : "none";
    }
}

/* =========================
   REGISTRAR USUARIO (MVC + fetch opcional)
========================= */

function registrar() {

    const nombre = document.getElementById("nombre").value.trim();
    const correo = document.getElementById("correo").value.trim();
    const password = document.getElementById("password").value;
    const confirmar = document.getElementById("confirmar").value;

    if (!nombre || !correo || !password || !confirmar) {
        alert("Llena todos los campos");
        return;
    }

    if (password !== confirmar) {
        alert("Las contraseñas no coinciden");
        return;
    }

    fetch("?menu=registro", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `nombre=${nombre}&correo=${correo}&pass=${password}`
    })
    .then(res => {
        window.location.href = "?menu=login";
    })
    .catch(() => {
        alert("Error en el servidor");
    });
}