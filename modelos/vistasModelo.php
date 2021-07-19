<?php 

    class vistasModelo {

        /********** Modelo obtener vistas **********/
        protected static function obtener_vistas_modelo($vistas) {
            $listaBlanca = ["home", "company", "client-list", "client-new", "client-search", "client-update", "item-list", "item-new", "item-search", "item-update", "reservation-new", "reservation-list", "reservation-pending", "reservation-reservation", "reservation-search", "reservation-update", "user-list", "user-new", "user-search", "user-update"];
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