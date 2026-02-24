document.querySelectorAll('.fichar').forEach(boton => {
    boton.onclick = function () {
        let budgetElem = document.getElementById("budget");
        let idPropio = budgetElem.dataset.idPropio;
        let idRival = budgetElem.dataset.idRival;
        if (idPropio && idRival && idPropio !== idRival) {
            ficharRival.call(this, idPropio, idRival);
        } else {
            fichar.call(this);
        }
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

function fichar() {
    let presupuesto = document.getElementById("budget");
    let presupuestoActual = Number(presupuesto.dataset.valor);
    let idEquipo = presupuesto.dataset.id;
    let idJugador = this.dataset.id;
    let valor = Number(this.dataset.valor);
    let nuevoSaldo = presupuestoActual - valor;
    fetch(`/equipo-fantasy/${idEquipo}/fichar`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idJugador: idJugador })
    }).then(response => {
        if (response.ok) {
            presupuesto.textContent = nuevoSaldo.toLocaleString() + " €";
            presupuesto.dataset.valor = nuevoSaldo;
            this.disabled = true;
            this.textContent = "Fichado";
        } else {
            response.json().then(data => {
                if (data.error === "La plantilla está completa") {
                    mostrarModalLimite();
                } else {
                    alert(data.error || "Error al fichar");
                }
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
                    throw new Error("QUIET_ERROR"); // Error silencioso para el catch
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
