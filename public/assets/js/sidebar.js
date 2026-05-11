function abrirPanel() {
    document.getElementById("sidebar").classList.add("activo");
}

function cerrarPanel() {
    document.getElementById("sidebar").classList.remove("activo");
}
function abrirModal(){
    document.getElementById("modalUsuario")
            .style.display = "flex";
}

function cerrarModal(){
    document.getElementById("modalUsuario")
            .style.display = "none";
}

function abrirEditar(id, nombre, correo, estado){

    document.getElementById("modalEditar")
            .style.display = "flex";

    document.getElementById("editNombre")
            .value = nombre;

    document.getElementById("editCorreo")
            .value = correo;

    document.getElementById("editEstado")
            .value = estado;

    document.getElementById("formEditar")
            .action = "?menu=editar&id=" + id;
}

function cerrarEditar(){

    document.getElementById("modalEditar")
            .style.display = "none";
}
function buscarUsuarios(){

    let input = document.getElementById("buscarUsuario")
                        .value
                        .toLowerCase();

    let tabla = document.getElementById("tablaUsuarios");

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
