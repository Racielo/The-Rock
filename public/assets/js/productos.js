function buscarProductos() {
    const input = document.getElementById("buscarProducto").value.toLowerCase();
    document.querySelectorAll("#tablaProductos tbody tr").forEach(f => {
        f.style.display = f.textContent.toLowerCase().includes(input) ? "" : "none";
    });
}

function abrirModalProducto() {
    document.getElementById("modalAgregarProducto").style.display = "flex";
}
function cerrarModalProducto() {
    document.getElementById("modalAgregarProducto").style.display = "none";
}

function abrirEditarProducto(id, nombre, descripcion, precio, categoria, dias, estado) {
    document.getElementById("editNombre").value      = nombre;
    document.getElementById("editDescripcion").value = descripcion;
    document.getElementById("editPrecio").value      = precio;
    document.getElementById("editCategoria").value   = categoria;
    document.getElementById("editDias").value        = dias;
    document.getElementById("editEstado").value      = estado;
    document.getElementById("formEditarProducto").action = "?menu=editarProducto&id=" + id;
    document.getElementById("modalEditarProducto").style.display = "flex";
}
function cerrarEditarProducto() {
    document.getElementById("modalEditarProducto").style.display = "none";
}

window.addEventListener('click', function(e) {
    const m1 = document.getElementById("modalAgregarProducto");
    const m2 = document.getElementById("modalEditarProducto");
    if (e.target === m1) m1.style.display = "none";
    if (e.target === m2) m2.style.display = "none";
});