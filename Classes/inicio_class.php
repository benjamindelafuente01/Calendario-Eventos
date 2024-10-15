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
        public function crearNuevoEvento ($nombre, $fecha_inicio, $fecha_fin, $color, $precio, $hora_inicio, $hora_fin, $usuario, $fecha_creacion) {

            // Creamos estructura de la consulta
            $sql = "INSERT INTO evento(nombre, fecha_inicio, fecha_fin, hora_inicio, hora_fin, color, costo_boleto, ultimo_usuario, fecha_creacion) 
                    VALUES (:NOMBRE, :FECHA_INICIO, :FECHA_FIN, :HORA_INICIO, :HORA_FIN, :COLOR, :COSTO_BOLETO, :ULTIMO_USUARIO, :FECHA_CREACION)"
            ;
            
            // Preparamos la consulta
            $stmt = $this->conexion_pdo->prepare($sql);
            
            // Asociamos valores
            $marcadores = [
                ':NOMBRE' => $nombre, ':FECHA_INICIO' => $fecha_inicio, ':FECHA_FIN' => $fecha_fin, ':HORA_INICIO' => $hora_inicio, ':HORA_FIN' => $hora_fin,
                ':COLOR' => $color, ':COSTO_BOLETO' => $precio, ':ULTIMO_USUARIO' => $usuario, ':FECHA_CREACION' => $fecha_creacion
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