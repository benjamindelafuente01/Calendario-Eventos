<?php

    // Importamos archivo para la conexion
    require __DIR__ . '/../Connection/conexion.php';

    /*
        Clase para la generacion de reportes
    */
    class Reporte extends ConexionBD{

        // Metodo constructor
        public function __construct() {

            // LLamamos al constructor de la clase padre
            parent:: __construct();
        }


        // Metodo para obtener los datos del evento
        public function obtenerDatosEvento($id_evento) {

            // Sentencia SQL
            $sql = "SELECT nombre, fecha_inicio, fecha_fin
                FROM evento
                WHERE id_evento = :ID_EVENTO"
            ;

            // Preparamos consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos valores
            $stmt->bindParam(':ID_EVENTO', $id_evento);

            // Ejecutamos consulta
            $stmt->execute();

            // Guardamos resultado
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificamos resultado
            if (!$resultado) {
                return false;
            } else {
                return $resultado;
            }
        }


        // Metodo para traer la informacion de los gastos por evento
        public function obtenerGastosEvento($id_evento) {

            // Sentencia SQL
            $sql = "SELECT concepto_gasto, fecha_gasto, monto_gasto
                FROM gasto
                WHERE id_evento = :ID_EVENTO"
            ;

            // Preparamos consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos valores
            $stmt->bindParam(':ID_EVENTO', $id_evento);

            // Ejecutamos consulta
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
        
    }

?>