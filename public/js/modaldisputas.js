async function guardarCambios(id, redirectUrl) {
    let data = {
        resultado: document.querySelector('input[name="resultado"]').value,
        ganador_id: document.querySelector('select[name="ganador_id"]').value || null
    };

    try {
        let response = await fetch(`/disputa/${id}/modificar`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        if (response.ok) {
            window.location.href = redirectUrl;
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
// Lógica para abrir modal y cargar datos
let modalEvento = document.getElementById('modalEvento');
modalEvento.addEventListener('show.bs.modal', function (event) {
    let button = event.relatedTarget;
    let id = button.getAttribute('data-jugador-id');
    let nombre = button.getAttribute('data-jugador-nombre');

    modalEvento.querySelector('#input-jugador-id').value = id;
    modalEvento.querySelector('#modal-nombre-jugador').textContent = nombre;

    // Actualizamos el action del form para que use el ID del jugador_evento correcto si es necesario
    // O preparamos el form para enviarlo por Fetch
});

// Manejo del envío de puntos
document.getElementById('form-puntos-jugador').onsubmit = async function (e) {
    e.preventDefault();
    let id = document.getElementById('input-jugador-id').value;
    let eventoId = document.getElementById('select-evento').value;
    let cantidad = document.getElementById('input-cantidad').value;

    if (!eventoId) {
        console.warn('Por favor, selecciona un evento');
        return;
    }

    try {
        // Usamos tu ruta de Symfony actualizada
        let response = await fetch(`/anadircantidad/${id}/${eventoId}/${cantidad}`, {
            method: 'POST'
        });

        if (response.ok) {
            location.reload(); // Recargamos para ver los puntos actualizados
        }
    } catch (error) {
        console.error('Error:', error);
    }
};