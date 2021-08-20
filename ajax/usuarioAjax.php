<?php

    /* Este archivo se va encargar de recibir los datos enviados desde los formularios. */

    $peticionAjax = true;

    require_once "../config/APP.php";

    if (isset($_POST['usuario_dni_reg'])) {
        
        /********** Instancia al Controlador **********/
        require_once "../controladores/usuarioControlador.php";
        $ins_usuario = new usuarioControlador();
        
        if (isset($_POST['usuario_dni_reg']) && isset($_POST['usuario_nombre_reg'])) {

        }


    }else {
        session_start(['name' => 'SPM']);
        session_unset();
        session_destroy();
        header("Location: " . SERVERURL . "login/");
        exit();
    }