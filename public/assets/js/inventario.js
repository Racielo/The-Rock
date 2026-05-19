function buscarInventario() {
    const input = document.getElementById("buscarInventario").value.toLowerCase();
    document.querySelectorAll("#tablaInventario tbody tr").forEach(f => {
        f.style.display = f.textContent.toLowerCase().includes(input) ? "" : "none";
    });
}

function abrirModalInventario() {
    document.getElementById("modalInventario").style.display = "flex";
}
function cerrarModalInventario() {
    document.getElementById("modalInventario").style.display = "none";
}

function abrirEditarInventario(id, nombre, cantidad, unidad, stockMin, fechaIngreso, fechaCaducidad, estado) {
    document.getElementById("editNombre").value         = nombre;
    document.getElementById("editCantidad").value       = cantidad;
    document.getElementById("editUnidad").value         = unidad;
    document.getElementById("editStockMin").value       = stockMin;
    document.getElementById("editFechaIngreso").value   = fechaIngreso;
    document.getElementById("editFechaCaducidad").value = fechaCaducidad;
    document.getElementById("editEstado").value         = estado;
    document.getElementById("formEditarInventario").action = "?menu=editarInventario&id=" + id;
    document.getElementById("modalEditarInventario").style.display = "flex";
}
function cerrarEditarInventario() {
    document.getElementById("modalEditarInventario").style.display = "none";
}

window.addEventListener('click', function(e) {
    const m1 = document.getElementById("modalInventario");
    const m2 = document.getElementById("modalEditarInventario");
    if (e.target === m1) m1.style.display = "none";
    if (e.target === m2) m2.style.display = "none";
});