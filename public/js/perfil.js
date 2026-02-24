/**
 * GESTIÓN DEL MODAL DE FOTO DE PERFIL
 */
function abrirModalBorrarFoto() {
    let modal = document.getElementById('modal-eliminar-foto');
    if (modal) {
        modal.style.display = 'flex';
    }
}

// Cerrar el modal
window.cerrarModalBorrarFoto = function() {
    let modal = document.getElementById('modal-eliminar-foto');
    if (modal) {
        modal.style.display = 'none';
    }
};

let btnConfirmar = document.getElementById('btn-confirmar-borrado');
if (btnConfirmar) {
    btnConfirmar.onclick = function() {
        let formulario = document.getElementById('formDeleteFoto');
        if (formulario) {
            formulario.submit();
        }
    };
}

window.addEventListener('click', function(e) {
    let modal = document.getElementById('modal-eliminar-foto');
    if (e.target === modal) {
        cerrarModalBorrarFoto();
    }
});