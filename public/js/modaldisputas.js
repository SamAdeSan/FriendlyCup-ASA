async function guardarCambios(id) {
    const data = {
        resultado: document.querySelector('input[name="resultado"]').value,
        ganador_id: document.querySelector('select[name="ganador_id"]').value || null
    };

    const response = await fetch(`/disputa/${id}/modificar`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });

    if (response.ok) {
        window.location.href = "{{ path('torneo', {'id': disputa.torneo.id}) }}";
    }
}// Lógica para abrir modal y cargar datos
const modalEvento = document.getElementById('modalEvento');
modalEvento.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-jugador-id');
    const nombre = button.getAttribute('data-jugador-nombre');
    
    modalEvento.querySelector('#input-jugador-id').value = id;
    modalEvento.querySelector('#modal-nombre-jugador').textContent = nombre;
    
    // Actualizamos el action del form para que use el ID del jugador_evento correcto si es necesario
    // O preparamos el form para enviarlo por Fetch
});

// Manejo del envío de puntos
document.getElementById('form-puntos-jugador').addEventListener('submit', async function(e) {
    e.preventDefault();
    const id = document.getElementById('input-jugador-id').value;
    const eventoId = document.getElementById('select-evento').value;
    const cantidad = document.getElementById('input-cantidad').value;
    
    if (!eventoId) {
        alert('Por favor, selecciona un evento');
        return;
    }

    // Usamos tu ruta de Symfony actualizada
    const response = await fetch(`/anadircantidad/${id}/${eventoId}/${cantidad}`, {
        method: 'POST'
    });

    if (response.ok) {
        location.reload(); // Recargamos para ver los puntos actualizados
    }
});