let usuarios = [
    {id: 1, nombre: "Juan Pérez", correo: "juan@gmail.com", estado: "Activo"},
    {id: 2, nombre: "Ana López", correo: "ana@gmail.com", estado: "Inactivo"}
];

let contador = 3;
let editandoId = null;

function mostrarUsuarios() {
    const tabla = document.getElementById("tablaUsuarios");
    tabla.innerHTML = "";

    usuarios.forEach(user => {
        let fila = `<tr><td>${user.id}</td>`;

        if(editandoId === user.id){
            fila += `
                <td><input id="editNombre${user.id}" value="${user.nombre}"></td>
                <td><input id="editCorreo${user.id}" value="${user.correo}"></td>
                <td>
                    <select id="editEstado${user.id}">
                        <option ${user.estado=="Activo"?"selected":""}>Activo</option>
                        <option ${user.estado=="Inactivo"?"selected":""}>Inactivo</option>
                    </select>
                </td>
                <td>
                    <button onclick="guardarUsuario(${user.id})">Guardar</button>
                </td>
            `;
        } else {
            fila += `
                <td>${user.nombre}</td>
                <td>${user.correo}</td>
                <td class="${user.estado=='Activo'?'activo':'inactivo'}">${user.estado}</td>
                <td>
                    <button onclick="editarUsuario(${user.id})">Editar</button>
                    <button onclick="eliminarUsuario(${user.id})">Eliminar</button>
                </td>
            `;
        }

        fila += "</tr>";
        tabla.innerHTML += fila;
    });
}

function agregarUsuario() {
    const nombre = document.getElementById("nombre").value;
    const correo = document.getElementById("correo").value;
    const estado = document.getElementById("estado").value;

    if(nombre === "" || correo === "") return;

    usuarios.push({id: contador++, nombre, correo, estado});
    mostrarUsuarios();
}

function eliminarUsuario(id) {
    usuarios = usuarios.filter(u => u.id !== id);
    mostrarUsuarios();
}

function editarUsuario(id) {
    editandoId = id;
    mostrarUsuarios();
}

function guardarUsuario(id) {
    const nombre = document.getElementById(`editNombre${id}`).value;
    const correo = document.getElementById(`editCorreo${id}`).value;
    const estado = document.getElementById(`editEstado${id}`).value;

    usuarios = usuarios.map(u => {
        if(u.id === id){
            return {id, nombre, correo, estado};
        }
        return u;
    });

    editandoId = null;
    mostrarUsuarios();
}

mostrarUsuarios();