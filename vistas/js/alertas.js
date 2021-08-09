const formularios_ajax = document.querySelectorAll(".FormularioAjax");

function enviar_formulario_ajax(e) {
    e.preventDefault(); // Previene que se envie la información del formulario a la URL que apunta el atributo action
}

formularios_ajax.forEach(formularios => {
    formularios.addEventListener("submit", enviar_formulario_ajax);
});

function alertas_ajax(alerta) { // Recibe un arreglo de datos (JSON) como parametro
    
}