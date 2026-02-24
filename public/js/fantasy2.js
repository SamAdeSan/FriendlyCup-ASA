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
                alert(error.message);
            }
        });
}

function vender(idEquipo) {
    let idJugador = this.dataset.id;
    if (!confirm(`¿Estás seguro de que quieres vender a ${this.dataset.nombre}?`)) return;

    fetch(`/fantasy/api/equipo/${idEquipo}/vender`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idJugador: idJugador })
    }).then(response => {
        if (response.ok) {
            window.location.reload();
        } else {
            response.json().then(data => {
                alert(data.error || "Error al vender");
            });
        }
    });
}

function ficharRival(idPropio, idRival) {
    let presupuesto = document.getElementById("budget");
    let presupuestoActual = Number(presupuesto.dataset.valor);
    let idJugador = this.dataset.id;
    let valorMercado = Number(this.dataset.valor);
    let costeSignificativo = valorMercado * 2;

    if (presupuestoActual < costeSignificativo) {
        alert("No tienes suficiente presupuesto (El coste es 2x: " + costeSignificativo.toLocaleString() + " €)");
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
                alert(error.message);
            }
        });
}
