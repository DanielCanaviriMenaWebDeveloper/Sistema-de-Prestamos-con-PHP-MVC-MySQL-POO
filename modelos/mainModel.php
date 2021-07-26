<?php 

    /* Detectamos si se esta realizando una petición AJAX */
    if ($peticionAjax) {
        require_once "../config/SERVER.php";
    }else {
        require_once "./config/SERVER.php";
    }

    class mainModel {

        /********** Función para conectar a la Base de Datos **********/
        protected static function conectar() {
            $conexion = new PDO(SGBD, USER, PASS);
            $conexion->exec("SET CHARACTER SET utf8");
            return $conexion;
        }

        /********** Función para ejecutar consultas simples **********/        
        protected static function ejecutar_consulta_simple($consulta) {
            $sql = self::conectar()->prepare($consulta);
            $sql->execute();
            return $sql;
        }

        /********** Función para encriptar cadenas **********/   
        public static function encryption($string) {
            $output = FALSE;
            $key = hash('sha256', SECRET_KEY);
            $iv = substr(hash('sha256', SECRET_IV), 0, 16);
            $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
            $output = base64_encode($output);
            return $output;
        }

        /********** Función para desencriptar cadenas **********/   
        public static function decryption($string) {
            $key = hash('sha256', SECRET_KEY);
            $iv = substr(hash('sha256', SECRET_IV), 0, 16);
            $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
            return $output;
        }

        /********** Función para generar códigos aleatorios **********/
        /* La sintaxis que tomaran los códigos generados sera como el siguiente ejemplo: D12345-1 */
        protected static function generar_codigo_aleatorio($letra, $longitud, $numero) {
            for($i = 1; $i <= $longitud; $i++) {
                $aleatorio = rand(0, 9);
                $letra .=  $aleatorio; /* Concatena los números generados aleatoriamente a la variable $letra. */
            }
            return $letra . "-" . $numero;
        }
    }