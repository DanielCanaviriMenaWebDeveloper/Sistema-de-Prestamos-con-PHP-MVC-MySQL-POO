<?php 

    class vistasModelo {

        /********** Modelo obtener vistas **********/
        protected static function obtener_vistas_modelo($vistas) {
            $listaBlanca = [];
            if (in_array($vistas, $listaBlanca)) { // Metodo que verifica si existe un string determinado dentro un array.
                if (is_file("./vistas/contenidos/" . $vistas . "-view.php")) {
                    $contenido = "./vistas/contenidos/" . $vistas . "-view.php";
                } else {
                    $contenido = "404";
                }
            } elseif ($vistas == "login" || $vistas == "index") {
                $contenido = "login";
            } else {
                $contenido = "404";
            }
            return $contenido;
        }
    }