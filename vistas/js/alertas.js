const formularios_ajax = document.querySelectorAll(".FormularioAjax");

function enviar_formulario_ajax(e) {
    e.preventDefault(); // Previene que se envie la información del formulario a la URL que apunta el atributo action
}

formularios_ajax.forEach(formularios => {
    formularios.addEventListener("submit", enviar_formulario_ajax);
});

function alertas_ajax(alerta) { // Recibe un arreglo de datos (JSON) como parametro
    if (alerta.Alerta === "simple") {
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            type: alerta.Tipo,
            confirmButtonText: 'Aceptar'
        });
    } else if (alerta.Alerta === "recargar") {
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            type: alerta.Tipo,
            confirmButtonText: 'Aceptar'
        }).then( (result) => {
            if(result.value) {
                location.reload(); // Recarga la pagina
            }
        });
    } else if (alerta.Alerta === "limpiar") {
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            type: alerta.Tipo,
            confirmButtonText: 'Aceptar'
        }).then( (result) => {
            if(result.value) {
                document.querySelector(".FormularioAjax").reset(); // Resetea los campos del formulario
            }
        });
    } else if (alerta.Alerta === "redireccionar") {
        window.location.href = alerta.URL;  // Redirecciona al Usuario a la URL recibida.
    }
}