<?php

    // Importamos archivo de conexión
    require __DIR__ . '/../Connection/conexion.php';

    /*
        Clase para lo relacionado con los boletos
    */
    class Boleto extends ConexionBD {

        // Metodo constructor
        public function __construct() {
            
            // Llamamos al constructor de la clase padre
            parent:: __construct();
        }


        // Método para traer los distritos
        public function consultarDistritos() {

            // Consulta sql
            $sql = "SELECT id_distrito, nombre FROM distrito";

            // Preparamos consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Ejecutamos consulta
            $stmt->execute();

            // Guardamos resultados
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Verificamos resultado
            if (!$resultado) {
                return false;
            } else {
                return $resultado;
            }
        }


        // Método para traer las iglesias
        public function consultarIglesias() {

            // Consulta sql
            $sql = "SELECT id_iglesia, nombre, id_distrito FROM iglesia";

            // Preparamos consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Ejecutamos consulta
            $stmt->execute();

            // Guardamos resultados
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Verificamos resultado
            if (!$resultado) {
                return false;
            } else {
                return $resultado;
            }
        }


        // Método para traer los eventos
        public function consultarEventos() {

            // Consulta sql
            $sql = "SELECT id_evento, nombre, costo_boleto FROM evento";

            // Preparamos consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Ejecutamos consulta
            $stmt->execute();

            // Guardamos resultados
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