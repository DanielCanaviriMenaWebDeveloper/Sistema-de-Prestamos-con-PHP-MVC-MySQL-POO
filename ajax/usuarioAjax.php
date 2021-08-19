<?php

    /* Este archivo se va encargar de recibir los datos enviados desde los formularios. */

    $peticionAjax = true;

    require_once "../config/APP.php";

    if (false) {
        /********** Instancia al Controlador **********/
        require_once "../controladores/usuarioControlador.php";
        $ins_usuario = new usuarioControlador();
        


    }else {
        session_start(['name' => 'SPM']);
        session_unset();
        session_destroy();
        header("Location: " . SERVERURL . "login/");
        exit();
    }