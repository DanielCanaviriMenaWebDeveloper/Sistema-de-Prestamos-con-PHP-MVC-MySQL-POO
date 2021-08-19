<?php 

    if ($peticionAjax) {
        require_once "../modelos/usuarioModelo.php";
    }else {
        require_once "./modelos/usuarioModelo.php";
    }

    class usuarioControlador extends usuarioModelo {

         /********** Controlador para Agregar Usuario **********/
        public function agregar_usuario_controlador() {
            
        }
    }