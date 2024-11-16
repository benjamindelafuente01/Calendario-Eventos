<?php

    // Importamos archivo para la conexion
    require __DIR__ . '/../Connection/conexion.php';

    /*
        Clase para la visualizacion, altas, bajas y actualizaciones de los distritos
    */
    class Distrito extends ConexionBD {

        // Metodo constructor
        public function __construct() {

            // Llamamos al constructor de la clase padre
            parent:: __construct();
        }


        // Metodo para registrar un nuevo distrito
        public function agregarDistrito($nombre_distrito) {

            // Sentencia SQL
            $sql = "INSERT INTO distrito (nombre)
                VALUES (:NOMBRE_DISTRITO)"
            ;

            // Preparamos la consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos valores
            $stmt->bindParam(':NOMBRE_DISTRITO', $nombre_distrito);

            // Ejecutamos consulta
            $stmt->execute();

            // Verificamos resultado
            $resultado = $stmt->rowCount() > 0 ? true : false;

            return $resultado;
        }
    }


?>