/**
 * SELECTORES GLOBALES
 */
const selectores = {
    unirseBtn: document.getElementById("unirseliga"),
    seguirBtn: document.getElementById("seguir"),
    crearEventoBtn: document.getElementById("crear-evento"),
    btnConfirmarEvento: document.getElementById('btn-confirmar-evento'),
    btnConfirmarUnirse: document.getElementById('btn-confirmar-unirse'),
    tabs: document.querySelectorAll('.tab'),
    section: document.getElementById('torneo-section'),
    contadorSeguidores: document.getElementById('contador-seguidores')
};

/**
 * INICIALIZACIÓN DE EVENTOS
 */
document.addEventListener('DOMContentLoaded', () => {
    if (selectores.unirseBtn) selectores.unirseBtn.onclick = abrirModalUnirse;
    if (selectores.seguirBtn) selectores.seguirBtn.onclick = gestionSeguidores;
    if (selectores.crearEventoBtn) selectores.crearEventoBtn.onclick = abrirModalEvento;
    if (selectores.btnConfirmarEvento) selectores.btnConfirmarEvento.onclick = ejecutarCrearEvento;
    if (selectores.btnConfirmarUnirse) selectores.btnConfirmarUnirse.onclick = ejecutarUnirseFantasy;

    selectores.tabs.forEach(tab => {
        tab.onclick = (e) => {
            e.preventDefault();
            selectores.tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            cargarContenido(tab.dataset.url);
        };
    });

    const tabActiva = document.querySelector('.tab.active');
    if (tabActiva) cargarContenido(tabActiva.dataset.url);
});
document.addEventListener("click", (e) => {
    if (e.target.classList.contains("modificardisputa")) {
        modificaResultado(e.target);
    }
});

/**
 * FUNCIONES: SEGUIMIENTO Y TABS
 */
function gestionSeguidores() {
    const idTorneo = this.getAttribute('data-id');
    const estoySiguiendo = this.classList.contains('btn-danger');
    let actual = parseInt(selectores.contadorSeguidores.innerText);

    if (estoySiguiendo) {
        this.textContent = 'Seguir';
        this.classList.replace('btn-danger', 'btn-secondary');
        actual--;
    } else {
        this.textContent = 'Dejar de seguir';
        this.classList.replace('btn-secondary', 'btn-danger');
        actual++;
    }
    selectores.contadorSeguidores.innerText = actual;

    fetch(`/torneo/${idTorneo}/seguir`, { method: 'POST' })
        .catch(err => console.error("Error en follow:", err));
}

function cargarContenido(url) {
    if (!selectores.section) return;

    fetch(url)
        .then(res => res.text())
        .then(html => {
            selectores.section.innerHTML = html;
            vincularEventosDinamicos();
        })
        .catch(err => console.error("Error cargando contenido:", err));
}

function vincularEventosDinamicos() {
    const btnMostrar = document.getElementById("btnmostrarform");
    const formDisputa = document.getElementById("formnuevadisputa");
    const btnGuardar = document.getElementById("btn-guardar-disputa");

    if (btnMostrar && formDisputa) {
        btnMostrar.onclick = () => {
            formDisputa.style.display = (formDisputa.style.display === 'none' || formDisputa.style.display === '') ? 'block' : 'none';
        };
    }

    if (btnGuardar) {
        btnGuardar.onclick = function () {
            const equipo1 = document.getElementById("selectequipo1").value;
            const equipo2 = document.getElementById("selectequipo2").value;
            const torneoId = this.dataset.torneoId;

            if (!equipo1 || !equipo2 || equipo1 === equipo2) {
                alert("Selecciona dos equipos diferentes.");
                return;
            }

            fetch('/disputa/crear', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ equipo1_id: equipo1, equipo2_id: equipo2, torneo_id: torneoId })
            }).then(res => res.ok ? window.location.reload() : res.text().then(text => alert("Error: " + text)));
        };
    }
}

/**
 * FUNCIONES: MODAL CREAR EVENTO
 */
function abrirModalEvento() {
    const modal = document.getElementById('modal-crear-evento');
    if (modal) {
        modal.style.display = 'flex';
        selectores.btnConfirmarEvento.dataset.id = this.dataset.id;
        document.getElementById('input-evento-nombre').focus();
    }
}

window.cerrarModalEvento = () => {
    const modal = document.getElementById('modal-crear-evento');
    if (modal) {
        modal.style.display = 'none';
        document.getElementById('input-evento-nombre').value = '';
        document.getElementById('input-evento-puntos').value = '';
    }
};

function ejecutarCrearEvento() {
    const evento = document.getElementById('input-evento-nombre').value;
    const puntos = document.getElementById('input-evento-puntos').value;
    const torneoId = this.dataset.id;

    if (!evento || !puntos) return;

    fetch('/crear/evento', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ puntos, evento, torneo_id: torneoId })
    }).then(() => {
        cerrarModalEvento();
        window.location.reload();
    });
}

/**
 * FUNCIONES: MODAL UNIRSE FANTASY
 */
function abrirModalUnirse() {
    const modal = document.getElementById('modal-unirse-fantasy');
    if (modal) {
        modal.style.display = 'flex';
        document.getElementById('input-fantasy-clave').focus();
    }
}

window.cerrarModalUnirse = () => {
    const modal = document.getElementById('modal-unirse-fantasy');
    if (modal) {
        modal.style.display = 'none';
        document.getElementById('error-clave').style.display = 'none';
    }
};

function ejecutarUnirseFantasy() {
    const clave = document.getElementById('input-fantasy-clave').value;
    const errorMsg = document.getElementById('error-clave');

    if (!clave) return;

    fetch(`/fantasy/api/liga/unirse`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ clave })
    })
        .then(res => res.json())
        .then(data => {
            if (data.liga) window.location.href = `/`;
            else errorMsg.style.display = 'block';
        })
        .catch(err => console.error("Error:", err));
}

/**
 * FUNCIONES: RESULTADOS (Pendiente de Modal)
 */
function modificaResultado(elemento) {
    const id = elemento.dataset.disputaId;
    const n1 = elemento.dataset.nombreEquipo1;
    const n2 = elemento.dataset.nombreEquipo2;

    const res1 = prompt(`Puntos de ${n1}`);
    if (res1 === null) return;
    const res2 = prompt(`Puntos de ${n2}`);
    if (res2 === null) return;

    const id1 = elemento.dataset.disputaEquipo1;
    const id2 = elemento.dataset.disputaEquipo2;
    let ganador = (parseInt(res1) > parseInt(res2)) ? id1 : (parseInt(res1) < parseInt(res2) ? id2 : null);

    fetch(`/disputa/${id}/modificar`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ resultado: `${res1}-${res2}`, ganador_id: ganador })
    }).then(res => res.ok ? window.location.reload() : res.text().then(text => alert("Error: " + text)));
}