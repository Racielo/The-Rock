/* =========================
   MODAL AGREGAR
========================= */

function abrirModalInventario() {

    document.getElementById("modalAgregarInventario").style.display = "flex";
}

function cerrarModalInventario() {

    document.getElementById("modalAgregarInventario").style.display = "none";
}

/* =========================
   MODAL EDITAR
========================= */

function abrirEditarInventario(
    id,
    nombre,
    categoria,
    unidad,
    stockActual,
    stockMinimo,
    costo,
    fecha,
    estado
) {

    document.getElementById("modalInventario").style.display = "flex";

    document.getElementById("editNombre").value = nombre;

    document.getElementById("editCategoria").value = categoria;

    document.getElementById("editUnidad").value = unidad;

    document.getElementById("editStockActual").value = stockActual;

    document.getElementById("editStockMinimo").value = stockMinimo;

    document.getElementById("editCosto").value = costo;

    document.getElementById("editFecha").value = fecha;

    document.getElementById("editEstado").value = estado;

    document.getElementById("formEditarInventario").action =
        "?menu=editarInventario&id=" + id;
}

function cerrarEditarInventario() {

    document.getElementById("modalInventario").style.display = "none";
}

/* =========================
   BUSCADOR
========================= */

function buscarInventario() {

    let input = document
        .getElementById("buscarInventario")
        .value
        .toLowerCase();

    let filas = document.querySelectorAll("#tablaInventario tbody tr");

    filas.forEach(fila => {

        let texto = fila.textContent.toLowerCase();

        fila.style.display =
            texto.includes(input)
            ? ""
            : "none";
    });
}

/* =========================
   CERRAR MODAL AL DAR CLICK FUERA
========================= */

window.onclick = function(event) {

    let modalAgregar =
        document.getElementById("modalAgregarInventario");

    let modalEditar =
        document.getElementById("modalInventario");

    if (event.target == modalAgregar) {

        modalAgregar.style.display = "none";
    }

    if (event.target == modalEditar) {

        modalEditar.style.display = "none";
    }
}