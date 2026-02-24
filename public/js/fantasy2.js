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
    }).then(response => response.json())
        .then(data => {
            if (data.nuevoPresupuesto !== undefined) {
                let nuevoSaldo = data.nuevoPresupuesto;
                presupuesto.textContent = nuevoSaldo.toLocaleString() + " €";
                presupuesto.dataset.valor = nuevoSaldo;
                window.location.reload();
            }
        });
}

