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


        // Metodo para consultar los distritos
        public function consultarDistritos() {

            // Sentencia SQL
            $sql = "SELECT id_distrito, nombre FROM distrito";

            // Preparamos la consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Ejecutamos la consulta
            $stmt->execute();

            // Guardamos resultado
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Verificamos resultado
            if (!$resultado) {
                return false;
            } else {
                return $resultado;
            }
        }


        // Metodo para actualizar el nombre de un distrito
        public function actualizarDistrito($id_distrito, $nombre_distrito) {

            // Sentencia SQL
            $sql = "UPDATE distrito
                SET nombre = :NOMBRE_DISTRITO
                WHERE id_distrito = :ID_DISTRITO"
            ;

            // Preparamos consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos valores
            $stmt->bindParam(':ID_DISTRITO', $id_distrito);
            $stmt->bindParam(':NOMBRE_DISTRITO', $nombre_distrito);

            // Ejecutamos consulta
            $stmt->execute();

            // Verificamos resultado
            $resultado = $stmt->rowCount() > 0 ? true : false;

            return $resultado;
        }


        // Metodo para eliminar un distrito
        public function eliminarDistrito($id_distrito) {

            // Sentencia SQL
            $sql = "DELETE FROM distrito WHERE id_distrito = :ID_DISTRITO";

            // Preparamos consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos valores
            $stmt->bindParam(':ID_DISTRITO', $id_distrito);

            // Ejecutamos consulta
            $stmt->execute();

            // Verificamos resultado
            $resultado = $stmt->rowCount() > 0 ? true : false;

            return $resultado;
        }

    }

?>