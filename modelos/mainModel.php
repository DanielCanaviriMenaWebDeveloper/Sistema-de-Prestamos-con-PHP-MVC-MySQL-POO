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
        // La sintaxis que tomaran los códigos generados sera como el siguiente ejemplo: D12345-1 
        protected static function generar_codigo_aleatorio($letra, $longitud, $numero) {
            for($i = 1; $i <= $longitud; $i++) {
                $aleatorio = rand(0, 9);
                $letra .=  $aleatorio; // Concatena los números generados aleatoriamente a la variable $letra. 
            }
            return $letra . "-" . $numero;
        }

        /********** Función para limpiar cadenas **********/
        protected static function limpiar_cadena($cadena) {
            $cadena = trim($cadena); // Elimina espacios antes o despues de la cadena. 
            $cadena = stripslashes($cadena); // Elimina las barras invertidas dentro la cadena : "\" 
            $cadena = str_ireplace("<script>", "", $cadena); // Remplaza en la cadena la subcadena "<script>" por "", en otras palabra elimina la subcadena.
            $cadena = str_ireplace("</script>", "", $cadena);
            $cadena = str_ireplace("<script src=>", "", $cadena);
            $cadena = str_ireplace("<script type=>", "", $cadena);
            $cadena = str_ireplace("SELECT * FROM", "", $cadena);
            $cadena = str_ireplace("DELETE FROM", "", $cadena);
            $cadena = str_ireplace("INSERT INTO", "", $cadena);
            $cadena = str_ireplace("DROP TABLE", "", $cadena);
            $cadena = str_ireplace("DROP DATABASE", "", $cadena);
            $cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
            $cadena = str_ireplace("SHOW TABLES", "", $cadena);
            $cadena = str_ireplace("SHOW DATABASES", "", $cadena);
            $cadena = str_ireplace("<?php", "", $cadena);
            $cadena = str_ireplace("?>", "", $cadena);
            $cadena = str_ireplace("--", "", $cadena);
            $cadena = str_ireplace(">", "", $cadena);
            $cadena = str_ireplace("<", "", $cadena);
            $cadena = str_ireplace("[", "", $cadena);
            $cadena = str_ireplace("]", "", $cadena);
            $cadena = str_ireplace("^", "", $cadena);
            $cadena = str_ireplace("==", "", $cadena);
            $cadena = str_ireplace(";", "", $cadena);
            $cadena = str_ireplace("::", "", $cadena);
            $cadena = stripslashes($cadena);
            $cadena = trim($cadena);
            return $cadena;
        }

        /********** Función verificar datos **********/
        protected static function verificar_datos($filtro, $cadena) {
            // https://www.php.net/manual/es/function.preg-match.php
            if (preg_match("/^" . $filtro . "$/", $cadena)) {
                return false; // La cadena no tiene ningun error, cumple con la expresión regular
            }else {
                return true; // No coincide la cadena con el filtro 
            }
        }

        /********** Función verificar fechas **********/
        protected static function verificar_fecha($fecha) {
            $valores = explode("-", $fecha); // Divide un string en varios strings, lo devuelve en un array de strings.
            // https://www.php.net/manual/es/function.checkdate.php
            if (count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0] )) {
                return false; // No tiene errores la fecha, si coincide con el formato solicitado
            }else {
                return true; // Si tiene errores la fecha, no coincide con el formato solicitado
            }
        }

        /********** Función paginador de tablas **********/
        protected static function paginador_tablas($pagina, $Npaginas, $url, $botones) {
            $tabla = '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';

            if ($pagina == 1) {
                $tabla .= ' <li class="page-item     disabled"><a class="page-link"><i class="fas fa-angle-double-left"></i></a></li>';
            }else {
                $tabla .= '
                    <li class="page-item"><a class="page-link" href=" ' . $url . '1/ "><i class="fas fa-angle-double-left"></i></a></li>
                    <li class="page-item"><a class="page-link" href=" ' . $url . ($pagina - 1) . '/ ">Anterior</a></li>
                ';
            }

            $ci = 0; // Contador de iteraciones.
            for ($i = $pagina; $i <= $Npaginas; $i++) {
                if ($ci >= $botones) {
                    break;
                }
                if ($pagina == $i) {
                    $tabla .= '<li class="page-item"><a class="page-link active" href=" ' . $url . $i . '/">' . $i . '</a></li>';
                }else {
                    $tabla .= '<li class="page-item"><a class="page-link" href=" ' . $url . $i . '/">' . $i . '</a></li>';
                }
            }

            if ($pagina == $Npaginas) {
                $tabla .= ' <li class="page-item disabled"><a class="page-link"><i class="fas fa-angle-double-right"></i></a></li>';
            } else {
                $tabla .= '
                    <li class="page-item"><a class="page-link" href=" ' . $url . ($pagina + 1) . '/ ">Siguiente</a></li>
                    <li class="page-item"><a class="page-link" href=" ' . $url . $Npaginas . '/ "><i class="fas fa-angle-double-right"></i></a></li>
                ';
            }

            $tabla .= '</ul></nav>';
            return $tabla;
        }


    }