let botonesFichar=document.querySelectorAll('.fichar');
botonesFichar.forEach(boton => boton.click(fichar));
function fichar() {
    let presupuesto = document.getElementById("budget");
    let presupuestoActual = Number(presupuesto.dataset.valor);
    let idEquipo = presupuesto.dataset.id;
    let idJugador = this.dataset.id;
    let nombre = this.dataset.nombre;
    let valor = Number(this.dataset.valor);
    let puntos = this.dataset.puntos;
    let nuevoSaldo = presupuestoActual - valor;
    fetch(`/equipo-fantasy/${idEquipo}/fichar`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idJugador: idJugador })
    }).then(() => {
        presupuestoActual = nuevoSaldo;
        presupuesto.textContent = nuevoSaldo;
        presupuesto.dataset.valor = nuevoSaldo;
    });
}