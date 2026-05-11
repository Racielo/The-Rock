        /* =========================
           BUSCADOR PRODUCTOS
        ========================= */

        function buscarProductos(){

            let input = document.getElementById("buscarProducto")
                                .value
                                .toLowerCase();

            let tabla = document.getElementById("tablaProductos");

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

        function abrirModalProducto(){

            document.getElementById("modalAgregarProducto")
                    .style.display = "flex";
        }

        function cerrarModalProducto(){

            document.getElementById("modalAgregarProducto")
                    .style.display = "none";
        }

        /* =========================
           MODAL EDITAR
        ========================= */

        function abrirEditarProducto(
            id,
            ingrediente,
            cantidad,
            maximo,
            unidad,
            fecha
        ){

            document.getElementById("modalProducto")
                    .style.display = "flex";

            document.getElementById("editIngrediente")
                    .value = ingrediente;

            document.getElementById("editCantidad")
                    .value = cantidad;

            document.getElementById("editMaximo")
                    .value = maximo;

            document.getElementById("editUnidad")
                    .value = unidad;

            document.getElementById("editFecha")
                    .value = fecha;

            document.getElementById("formEditarProducto")
                    .action = "?menu=editarProducto&id=" + id;
        }

        function cerrarEditarProducto(){

            document.getElementById("modalProducto")
                    .style.display = "none";
        }