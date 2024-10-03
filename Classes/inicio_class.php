<?php

    // Archivo para la conexion
    require __DIR__ . '/../Connection/conexion.php';

    /*
        Clase para insertar un nuevo Evento
    */
    class Evento extends ConexionBD {

        // Metodo Constructor
        public function __construct() {
            // Llamamos al contrcutor de la clase Padre
            parent:: __construct();
        }

        // Método para insertar un nuevo evento en la base de datos
        public function crearNuevoEvento ($titulo, $fecha_inicio, $fecha_fin, $color, $precio, $hora_inicio) {

            // Creamos estructura de la consulta
            $sql = "INSERT INTO eventos(title, start, end, color, precio_boleto, hora_inicio) 
                    VALUES (:titulo, :fecha_inicio, :fecha_fin, :color, :precio, :hora_inicio)"
            ;
            
            // Preparamos la consulta
            $stmt = $this->conexion_pdo->prepare($sql);
            
            // Asociamos valores
            $marcadores = [
                ':titulo' => $titulo, ':fecha_inicio' => $fecha_inicio, ':fecha_fin' => $fecha_fin,
                ':color' => $color, ':precio' => $precio, ':hora_inicio' => $hora_inicio
            ];
            
            // Ejecutamos la consulta
            $stmt->execute($marcadores);

            // Verificamos resultado
            $resultado = $stmt->rowCount() > 0 ? true : false;

            return $resultado;
        }

        // Método para traer los eventos de la base de datos
        public function traerEventos() {

            // Sentencia SQL
            $sql = "SELECT title, start, end, color, hora_inicio FROM eventos";

            // Preparamos la consulta
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