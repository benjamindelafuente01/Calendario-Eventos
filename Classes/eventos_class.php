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

            // Sentencia SQL (Consultamos la vista que contiene todos los datos)
            $sql = "SELECT * FROM vista_eventos_gastos_boletos ORDER BY fecha_inicio ASC";

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
            $sql = "SELECT id_evento, nombre, fecha_inicio, fecha_fin, hora_inicio, costo_boleto, color
                FROM evento
                WHERE id_evento = :ID"
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
        public function editarEvento ($id, $tituloNuevo, $costoNuevo, $fechaInicioNuevo, $fechaFinNuevo, $horaInicioNuevo, $colorNuevo, $usuario, $fecha_actualizacion) {

            // Setencia SQL
            $sql = "UPDATE evento
                SET nombre = :NOMBRE, fecha_inicio = :FECHA_INICIO, fecha_fin = :FECHA_FIN, color = :COLOR, 
                costo_boleto = :COSTO, hora_inicio = :HORA_INICIO, ultimo_usuario = :USUARIO, 
                fecha_actualizacion = :FECHA_ACTUALIZACION
                WHERE id_evento = :ID"
            ;

            // Preparamos consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos valores mediante un arreglo
            $marcadores = [':NOMBRE' => $tituloNuevo, ':FECHA_INICIO' => $fechaInicioNuevo, ':FECHA_FIN' => $fechaFinNuevo,
                ':COLOR' => $colorNuevo, ':COSTO' => $costoNuevo, ':HORA_INICIO' => $horaInicioNuevo, ':ID' => $id,
                ':USUARIO' => $usuario,'FECHA_ACTUALIZACION' => $fecha_actualizacion
            ];
            
            // Ejecutamos consulta
            $stmt->execute($marcadores);

            // Comprobamos resultado
            $resultado = $stmt->rowCount() > 0 ? true : false;

            return $resultado;
        }


        // Método para eliminar un evento
        public function eliminarEvento($id) {

            // Sentencia SQL
            $sql = "UPDATE evento SET eliminado = true WHERE id_evento = :ID";

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

        // Método para finalizar un evento
        public function finalizarEvento($id) {

            // Sentencia SQL
            $sql = "UPDATE evento SET evento_finalizado = true WHERE id_evento = :ID";

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

        
        // Método para agregar un gasto de un evento
        public function agregarGasto($idEvento, $concepto, $monto, $fecha, $usuario) {
        
            // Estructura de la consulta
            $sql = "INSERT INTO gasto (concepto_gasto, fecha_gasto, monto_gasto, usuario, id_evento)
                VALUES (:CONCEPTO, :FECHA, :MONTO, :USUARIO, :ID_EVENTO)"
            ;

            // Preparamos la consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos valores
            $marcadores = [':CONCEPTO' => $concepto, ':FECHA' => $fecha, ':MONTO' => $monto, ':USUARIO' => $usuario,
                ':ID_EVENTO' => $idEvento
            ];

            // Ejecutamos consulta
            $stmt->execute($marcadores);

            // Verificamos resultado
            $resultado = $stmt->rowCount() > 0 ? true : false;
            
            return $resultado;
        }


        // Metodo para agregar un ingreso
        public function agregarIngreso($tipo_ingreso, $monto_ingreso, $fecha_ingreso, $usuario, $id_evento) {

            // Sentencia SQL
            $sql = "INSERT INTO ingreso(tipo_ingreso, monto_ingreso, fecha_ingreso, usuario, id_evento)
                VALUES(:TIPO_INGRESO, :MONTO_INGRESO, :FECHA_INGRESO, :USUARIO, :ID_EVENTO)"
            ;

            // Preparamos la consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos valores
            $marcadores = [':TIPO_INGRESO' => $tipo_ingreso, ':MONTO_INGRESO' => $monto_ingreso, ':FECHA_INGRESO' => $fecha_ingreso,
                ':USUARIO' => $usuario, ':ID_EVENTO' => $id_evento    
            ];

            // Ejecutamos consulta
            $stmt->execute($marcadores);

            // Verificamos resultado
            $resultado = $stmt->rowCount() > 0 ? true : false;

            return $resultado;
        }
    }

?>