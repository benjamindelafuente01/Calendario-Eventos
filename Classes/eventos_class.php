<?php

    // Archivo que realiza la conexión a Base de datos
    require __DIR__ . '/../Connection/conexion.php';

    /*
        Clase del menú de eventos
    */
    class Eventos extends ConexionBD {

        // Método constructor
        public function __construct() {

            // Llamamos al constructor de la clase padre
            parent:: __construct();
        }


        // Método para traer los eventos
        public function traerEventos() {

            // Sentencia SQL
            $sql = "SELECT id_evento, nombre, fecha_inicio, hora_inicio, color, costo_boleto  
                FROM evento
                WHERE eliminado = false AND evento_finalizado = false
                ORDER BY fecha_inicio ASC"
            ;

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


        // Método para consultar los datos del evento que se quiere editar
        public function traerDatosEventoEditar($id) {

            // Sentencia SQL
            $sql = "SELECT id, title, start, end, color, precio_boleto, hora_inicio 
                FROM eventos 
                WHERE id = :ID"
            ;

            // Preparamos la consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos valores con bindParam
            $stmt->bindParam(':ID', $id);

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


        // Método para actualizar los datos del evento que se editó
        public function editarEvento ($id, $tituloNuevo, $costoNuevo, $fechaInicioNuevo, $fechaFinNuevo, $horaInicioNuevo, $colorNuevo) {

            // Setencia SQL
            $sql = "UPDATE eventos 
                SET title = :NOMBRE, start = :FECHA_INICIO, end = :FECHA_FIN, color = :COLOR, 
                precio_boleto = :COSTO, hora_inicio = :HORA_INICIO
                WHERE id = :ID"
            ;

            // Preparamos consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos valores mediante un arreglo
            $marcadores = [':NOMBRE' => $tituloNuevo, ':FECHA_INICIO' => $fechaInicioNuevo, ':FECHA_FIN' => $fechaFinNuevo,
                ':COLOR' => $colorNuevo, ':COSTO' => $costoNuevo, ':HORA_INICIO' => $horaInicioNuevo, ':ID' => $id];
            
            // Ejecutamos consulta
            $stmt->execute($marcadores);

            // Comprobamos resultado
            $resultado = $stmt->rowCount() > 0 ? true : false;

            return $resultado;
        }


        // Método para eliminar un evento
        public function eliminarEvento($id) {

            // Sentencia SQL
            $sql = "DELETE FROM eventos WHERE id = :ID";

            // Preparamos la consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos parametros con bindParam
            $stmt->bindParam(':ID', $id);

            // Ejecutamos consulta
            $stmt->execute();

            // Verificamos resultado
            $resultado = $stmt->rowCount() > 0 ? true : false;
            
            return $resultado;
        }


    }

?>