let unirse=document.getElementById("unirseliga")
unirse.onclick=anadirusuario
function anadirusuario() {
    let clave = prompt("Introduce la clave privada de la liga:");
    if (!clave) return;
    let email=this.dataset.email
    fetch(`/api/liga/unirse`, {
            method: 'POST',
            headers: { 
            'Content-Type': 'application/json' 
        },
        body: JSON.stringify({ clave: clave, email: email })
    }).then(()=>{
       window.location.href = `/`
    })
}