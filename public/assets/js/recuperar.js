function recuperarContrasena() {
    const correoInput = document.getElementById('correo');
    const errorDiv    = document.getElementById('errorCorreo');
    const correo      = correoInput.value.trim();

    correoInput.classList.remove('error');
    errorDiv.textContent = '';

    if (!correo) {
        correoInput.classList.add('error');
        errorDiv.textContent = 'Por favor ingresa tu correo.';
        correoInput.focus();
        return;
    }

    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(correo)) {
        correoInput.classList.add('error');
        errorDiv.textContent = 'Ingresa un correo válido.';
        correoInput.focus();
        return;
    }

    fetch('?menu=enviar-recuperacion', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `correo=${encodeURIComponent(correo)}`
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            mostrarModal('✅', '¡Listo!', data.mensaje);
            correoInput.value = '';
        } else {
            mostrarModal('❌', 'Error', data.mensaje);
        }
    })
    .catch(() => mostrarModal('⚠️', 'Error de red', 'No se pudo conectar con el servidor.'));
}

function mostrarModal(icono, titulo, mensaje) {
    document.getElementById('modalIcon').textContent    = icono;
    document.getElementById('modalTitulo').textContent  = titulo;
    document.getElementById('modalMensaje').textContent = mensaje;
    document.getElementById('modal').style.display = 'flex';
}

function cerrarModal() {
    document.getElementById('modal').style.display = 'none';
}

document.getElementById('modal').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});

document.getElementById('correo').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') recuperarContrasena();
});