document.querySelectorAll('.fichar').forEach(boton => {
    boton.onclick = function () {
        let budgetElem = document.getElementById("budget");
        let idPropio = budgetElem.dataset.idPropio || budgetElem.dataset.id;
        let idRival = budgetElem.dataset.idRival;
        if (idPropio && idRival && idPropio !== idRival) {
            ficharRival.call(this, idPropio, idRival);
        } else {
            fichar.call(this, idPropio);
        }
    };
});

document.querySelectorAll('.vender').forEach(boton => {
    boton.onclick = function () {
        let budgetElem = document.getElementById("budget");
        let idEquipo = budgetElem.dataset.id;
        vender.call(this, idEquipo);
    };
});

function mostrarModalLimite() {
    const modal = document.getElementById('modal-limite-jugadores');
    if (modal) modal.style.display = 'flex';
}

window.cerrarModalLimite = () => {
    const modal = document.getElementById('modal-limite-jugadores');
    if (modal) modal.style.display = 'none';
};

function fichar(idEquipo) {
    let presupuesto = document.getElementById("budget");
    let idJugador = this.dataset.id;

    fetch(`/fantasy/api/equipo/${idEquipo}/fichar-mercado`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idJugador: idJugador })
    }).then(response => {
        if (response.ok) {
            return response.json();
        } else {
            return response.json().then(data => {
                if (data.error === "La plantilla está completa") {
                    mostrarModalLimite();
                    throw new Error("QUIET_ERROR");
                }
                throw new Error(data.error || "Error al fichar");
            });
        }
    })
        .then(data => {
            if (data && data.nuevoPresupuesto !== undefined) {
                presupuesto.textContent = data.nuevoPresupuesto.toLocaleString() + " €";
                presupuesto.dataset.valor = data.nuevoPresupuesto;
                window.location.reload();
            }
        })
        .catch(error => {
            if (error.message !== "QUIET_ERROR") {
                console.error("Error:", error.message);
            }
        });
}

function vender(idEquipo) {
    let idJugador = this.dataset.id;
    fetch(`/fantasy/api/equipo/${idEquipo}/vender`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idJugador: idJugador })
    }).then(response => {
        if (response.ok) {
            window.location.reload();
        } else {
            response.json().then(data => {
                console.error("Error al vender:", data.error || "Error desconocido");
            }).catch(() => {
                console.error("Error al vender: Error de red o servidor.");
            });
        }
    }).catch(error => {
        console.error("Error en la petición de venta:", error);
    });
}

function ficharRival(idPropio, idRival) {
    let presupuesto = document.getElementById("budget");
    let presupuestoActual = Number(presupuesto.dataset.valor);
    let idJugador = this.dataset.id;
    let valorMercado = Number(this.dataset.valor);
    let costeSignificativo = valorMercado * 2;

    if (presupuestoActual < costeSignificativo) {
        console.warn("Presupuesto insuficiente para fichar rival:", costeSignificativo);
        return;
    }

    fetch(`/fantasy/api/equipo/${idPropio}/ficharrival/${idRival}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idJugador: idJugador })
    }).then(response => {
        if (response.ok) {
            return response.json();
        } else {
            return response.json().then(data => {
                if (data.error === "La plantilla está completa") {
                    mostrarModalLimite();
                    throw new Error("QUIET_ERROR");
                }
                throw new Error(data.error || "Error al fichar");
            });
        }
    })
        .then(data => {
            if (data && data.nuevoPresupuesto !== undefined) {
                let nuevoSaldo = data.nuevoPresupuesto;
                presupuesto.textContent = nuevoSaldo.toLocaleString() + " €";
                presupuesto.dataset.valor = nuevoSaldo;
                window.location.reload();
            }
        })
        .catch(error => {
            if (error.message !== "QUIET_ERROR") {
                console.error("Error al fichar rival:", error.message);
            }
        });
}

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

document.addEventListener('DOMContentLoaded', () => {
    let btnAnadirUsuario = document.getElementById("btnAnadirUsuario");
    if (btnAnadirUsuario) {
        btnAnadirUsuario.onclick = abrirModalClave;
    }
});
