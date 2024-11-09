<?php

    // Importamos archivo para la conexion
    require __DIR__ . '/../Connection/conexion.php';

    /*
        Clase para la gestion de pagos parciales
    */
    class PagoParcial extends ConexionBD {

        // Metodo constructor
        public function __construct() {

            // Llamamos al constructor de la clase padre
            parent:: __construct();
        }


        // Metodo para consultar los boletos pendientes en busqueda por usuario
        public function pagoPendienteUsuario ($usuario) {

            // Consulta SQL
            $sql = "SELECT b.id_boleto, b.nombre, b.precio_total, b.precio_pagado, b.saldo_restante, e.nombre AS nombre_evento
                FROM boleto b
                INNER JOIN evento e ON b.id_evento = e.id_evento
                WHERE b.nombre LIKE :NOMBRE AND b.finiquitado = false
                ORDER BY e.nombre ASC"
            ;

            // Preparamos la consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Agregamos caracter comodin de la busqueda
            $usuario = "%{$usuario}%";

            // Asociamos valores
            $stmt->bindParam(':NOMBRE', $usuario);

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


        // Metodo para consultar los boletos pendientes en busqueda por evento
        public function pagoPendienteEvento ($evento) {

            // Consulta SQL
            $sql = "SELECT b.id_boleto, b.nombre, b.precio_total, b.precio_pagado, b.saldo_restante, e.nombre AS nombre_evento
                FROM boleto b
                INNER JOIN evento e ON b.id_evento = e.id_evento
                WHERE e.nombre LIKE :NOMBRE_EVENTO AND b.finiquitado = false
                ORDER BY e.nombre ASC"
            ;

            // Preparamos consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Agregamos caracter comodin de la busqueda
            $evento = "%{$evento}%";

            // Asociamos valores
            $stmt->bindParam(':NOMBRE_EVENTO', $evento);

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


        // Metodo para iniciar una transaccion
        public function iniciarTransaccion() {

            // Utilizamos beginTransaction() de PDO para iniciar una transaccion
            $this->conexion_pdo->beginTransaction();
        }


        // Metodo para confirmar una transaccion
        public function confirmarTransaccion() {

            // Utilizamos commit() de PDO para confirmar una transaccion
            $this->conexion_pdo->commit();
        }


        // Metodo para revertir una transaccion
        public function revertirTransaccion() {

            // Utilizamos rollBack() de PDO para revertir una transaccion
            $this->conexion_pdo->rollBack();
        }


        // Metodo guardar un nuevo pago
        public function guardarPagoParcial($monto, $fecha, $usuario, $idBoleto) {

            // Consulta SQL
            $sql = "INSERT INTO pago (monto_pago, fecha_pago, usuario, id_boleto)
                VALUES (:MONTO_PAGO, :FECHA_PAGO, :USUARIO, :ID_BOLETO)"
            ;

            // Preparamos la consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos valores
            $marcadores = [':MONTO_PAGO' => $monto, ':FECHA_PAGO' => $fecha, ':USUARIO' => $usuario, ':ID_BOLETO' => $idBoleto];

            // Ejecutamos consulta
            $stmt->execute($marcadores);
        }


        // Metodo para actualizar un boleto cuando se registra un nuevo pago
        public function actualizarBoleto($idBoleto, $montoAbonado, $finiquitado) {

            // Consulta SQL
            $sql = "UPDATE boleto
                SET precio_pagado = precio_pagado + :MONTO_ABONADO, 
                saldo_restante = saldo_restante - :MONTO_ABONADO, 
                finiquitado = :FINIQUITADO
                WHERE id_boleto = :ID_BOLETO"
            ;

            // Preparamos la consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos valores
            $marcadores = [':MONTO_ABONADO' => $montoAbonado, ':FINIQUITADO' => $finiquitado, ':ID_BOLETO' => $idBoleto];

            // Ejecutamos consulta
            $stmt->execute($marcadores);
        }

    }

?>