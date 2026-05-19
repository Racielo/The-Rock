function abrirModalProducto(){

    document.getElementById("modalAgregarProducto")
            .style.display = "flex";
}

function cerrarModalProducto(){

    document.getElementById("modalAgregarProducto")
            .style.display = "none";
}

function abrirEditarProducto(
    id,
    nombre,
    descripcion,
    precio,
    categoria,
    fecha,
    vida,
    imagen,
    estado
){

    document.getElementById("modalProducto")
            .style.display = "flex";

    document.getElementById("editNombre")
            .value = nombre;

    document.getElementById("editDescripcion")
            .value = descripcion;

    document.getElementById("editPrecio")
            .value = precio;

    document.getElementById("editCategoria")
            .value = categoria;

    document.getElementById("editFecha")
            .value = fecha;

    document.getElementById("editVida")
            .value = vida;

    document.getElementById("editImagen")
            .value = imagen;

    document.getElementById("editEstado")
            .value = estado;

    document.getElementById("formEditarProducto")
            .action = "?menu=editarProducto&id=" + id;
}

function cerrarEditarProducto(){

    document.getElementById("modalProducto")
            .style.display = "none";
}