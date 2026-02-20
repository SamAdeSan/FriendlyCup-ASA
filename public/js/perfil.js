/**
 * GESTIÓN DEL MODAL DE FOTO DE PERFIL
 */
function abrirModalBorrarFoto() {
    const modal = document.getElementById('modal-eliminar-foto');
    if (modal) {
        modal.style.display = 'flex';
    }
}

// Cerrar el modal
window.cerrarModalBorrarFoto = function() {
    const modal = document.getElementById('modal-eliminar-foto');
    if (modal) {
        modal.style.display = 'none';
    }
};

const btnConfirmar = document.getElementById('btn-confirmar-borrado');
if (btnConfirmar) {
    btnConfirmar.onclick = function() {
        const formulario = document.getElementById('formDeleteFoto');
        if (formulario) {
            formulario.submit();
        }
    };
}

window.addEventListener('click', function(e) {
    const modal = document.getElementById('modal-eliminar-foto');
    if (e.target === modal) {
        cerrarModalBorrarFoto();
    }
});