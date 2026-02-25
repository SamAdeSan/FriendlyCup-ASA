/**
 * SELECTORES DE FANTASY
 */
let presupuesto = document.getElementById("budget");
let maximo = Number(presupuesto.dataset.minimo);
let presupuestoActual = Number(presupuesto.dataset.valor);
let idEquipo = presupuesto.dataset.id;

let tablas = document.querySelectorAll('.torneo-content .stats-table tbody');
let tablaJugadores = tablas[0];
let tablaMercado = tablas[1];

let adminBtn = document.getElementById("btnAnadirUsuario");

/**
 * INICIALIZACIÓN
 */
document.addEventListener('DOMContentLoaded', () => {
    if (adminBtn) adminBtn.onclick = abrirModalClave;
    asignarEventosBotones();
});

function asignarEventosBotones() {
    let botonesVender = tablaJugadores.querySelectorAll('.vender');
    botonesVender.forEach(boton => boton.onclick = vender);

    let botonesSubir = tablaMercado.querySelectorAll('.btn-subir');
    botonesSubir.forEach(boton => boton.onclick = comprar);
}

/**
 * LÓGICA DE COMPRA
 */
function comprar() {
    let numJugadoresActuales = tablaJugadores.querySelectorAll('tr').length;

    if (numJugadoresActuales >= maximo) {
        abrirModalAviso('modal-limite-jugadores');
        return;
    }

    let fila = this.closest('tr');
    let idJugador = this.dataset.id;
    let nombre = this.dataset.nombre;
    let valor = Number(this.dataset.valor);
    let puntos = this.dataset.puntos;

    if (presupuestoActual < valor) {
        alert("No tienes suficiente saldo para fichar a " + nombre);
        return;
    }

    let nuevoSaldo = presupuestoActual - valor;

    fetch(`/fantasy/api/equipo/${idEquipo}/presupuesto`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ presupuesto: nuevoSaldo, idJugador: idJugador })
    }).then(() => {
        actualizarInterfazPresupuesto(nuevoSaldo);
        fila.remove();

        let nuevaFila = tablaJugadores.insertRow();
        nuevaFila.innerHTML = `
            <td>${nombre}</td>
            <td>${puntos}</td>
            <td>${valor} €</td>
            <td>
                <button class="vender"
                    data-id="${idJugador}"
                    data-nombre="${nombre}"
                    data-valor="${valor}"
                    data-puntos="${puntos}">
                    Vender
                </button>
            </td>`;
        nuevaFila.querySelector('.vender').onclick = vender;
    });
}

/**
 * LÓGICA DE VENTA
 */
function vender() {
    let fila = this.closest('tr');
    let idJugador = this.dataset.id;
    let nombre = this.dataset.nombre;
    let valor = Number(this.dataset.valor);
    let puntos = this.dataset.puntos;
    let nuevoSaldo = presupuestoActual + valor;

    fetch(`/fantasy/api/equipo/${idEquipo}/vender`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idJugador: idJugador })
    }).then(() => {
        actualizarInterfazPresupuesto(nuevoSaldo);
        fila.remove();

        let nuevaFila = tablaMercado.insertRow();
        nuevaFila.innerHTML = `
            <td>${nombre}</td>
            <td>${puntos}</td>
            <td>${valor} €</td>
            <td>
                <button class="btn-subir"
                    data-id="${idJugador}"
                    data-nombre="${nombre}"
                    data-valor="${valor}"
                    data-puntos="${puntos}">
                    Subir
                </button>
            </td>`;
        nuevaFila.querySelector('.btn-subir').onclick = comprar;
    });
}

/**
 * FUNCIONES AUXILIARES INTERFAZ
 */
function actualizarInterfazPresupuesto(nuevoValor) {
    presupuestoActual = nuevoValor;
    presupuesto.textContent = nuevoValor;
    presupuesto.dataset.valor = nuevoValor;
}

function abrirModalAviso(idModal) {
    let modal = document.getElementById(idModal);
    if (modal) modal.style.display = 'flex';
}

window.cerrarModalLimite = function () {
    document.getElementById('modal-limite-jugadores').style.display = 'none';
};

/**
 * LÓGICA DEL MODAL CLAVE DE INVITACIÓN
 */
function abrirModalClave() {
    let clave = this.dataset.clave;
    let modal = document.getElementById('modal-ver-clave');
    let spanClave = document.getElementById('texto-clave-liga');

    if (modal && spanClave) {
        spanClave.innerText = clave;
        modal.style.display = 'flex';
    }
}

window.cerrarModalClave = function () {
    let modal = document.getElementById('modal-ver-clave');
    if (modal) {
        modal.style.display = 'none';
    }
};

let btnAnadirUsuario = document.getElementById("btnAnadirUsuario");
if (btnAnadirUsuario) {
    btnAnadirUsuario.onclick = abrirModalClave;
}