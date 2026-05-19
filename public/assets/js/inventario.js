/* =========================
   BUSCADOR INVENTARIO
========================= */

function buscarInventario(){

    let input = document.getElementById("buscarInventario")
                        .value
                        .toLowerCase();

    let tabla = document.getElementById("tablaInventario");

    let filas = tabla.getElementsByTagName("tr");

    for(let i = 1; i < filas.length; i++){

        let textoFila = filas[i]
                        .textContent
                        .toLowerCase();

        if(textoFila.includes(input)){

            filas[i].style.display = "";

        }else{

            filas[i].style.display = "none";
        }
    }
}

/* =========================
   MODAL AGREGAR
========================= */

function abrirModalInventario(){

    document.getElementById("modalInventario")
            .style.display = "flex";
}

function cerrarModalInventario(){

    document.getElementById("modalInventario")
            .style.display = "none";
}

/* =========================
   MODAL EDITAR
========================= */

function abrirEditarInventario(
    id,
    nombre,
    cantidad,
    unidad,
    minimo,
    ingreso,
    caducidad,
    estado
){

    document.getElementById("modalEditarInventario")
            .style.display = "flex";

    document.getElementById("editNombre")
            .value = nombre;

    document.getElementById("editCantidad")
            .value = cantidad;

    document.getElementById("editUnidad")
            .value = unidad;

    document.getElementById("editMinimo")
            .value = minimo;

    document.getElementById("editIngreso")
            .value = ingreso;

    document.getElementById("editCaducidad")
            .value = caducidad;

    document.getElementById("editEstado")
            .value = estado;

    document.getElementById("formEditarInventario")
            .action = "?menu=editarInventario&id=" + id;
}

function cerrarEditarInventario(){

    document.getElementById("modalEditarInventario")
            .style.display = "none";
}