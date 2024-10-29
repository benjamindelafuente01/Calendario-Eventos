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


        // Metodo para iniciar una transaccion
        public function iniciarTransaccion() {

            // Utilizamos el metodo beginTransaction() de PDO para iniciar una transaccion
            $this->conexion_pdo->beginTransaction();
        }


        // Metodo para confirmar una transaccion
        public function confirmarTransaccion() {

            // Utilizamos el metodo commit() de PDO para confirmar una transaccion
            $this->conexion_pdo->commit();
        }


        // Metodo para revertir una transaccion
        public function revertirTransaccion() {

            // Utilizamos el metodo rollBack() de PDO para revertir una transaccion
            $this->conexion_pdo->rollBack();
        }


        // Metodo para registrar la venta de un nuevo boleto
        public function registrarBoleto($nombre, $distrito, $iglesia, $precioTotal, $precioPagado, $saldoRestante, $finiquitado, $fechaVenta, $usuario, $idEvento) {

            // Consulta sql
            $sql = "INSERT INTO boleto (
                    nombre, distrito, iglesia, precio_total, precio_pagado, saldo_restante, finiquitado, fecha_venta, usuario, id_evento)
                    VALUES (:NOMBRE, :DISTRITO, :IGLESIA, :PRECIO_TOTAL, :PRECIO_PAGADO, :SALDO_RESTANTE, :FINIQUITADO, :FECHA_VENTA, :USUARIO, :ID_EVENTO)"
            ;

            // Preparamos la consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos los valores
            $marcadores = [':NOMBRE' => $nombre, ':DISTRITO' => $distrito, ':IGLESIA' => $iglesia, ':PRECIO_TOTAL' => $precioTotal, ':PRECIO_PAGADO' => $precioPagado,
                ':SALDO_RESTANTE' => $saldoRestante, ':FINIQUITADO' => $finiquitado, ':FECHA_VENTA' => $fechaVenta, ':USUARIO' => $usuario, ':ID_EVENTO' => $idEvento
            ];

            // Ejecutamos la consulta
            $stmt->execute($marcadores);

            // Comprobamos resultado
            $resultado = $stmt->rowCount() > 0 ? true : false;

            // Con el metodo lastInsertId() de PDO, recuperamos el ultimo ID del campo autoincremental generado por la BD
            return $this->conexion_pdo->lastInsertId();
        }


        // Metodo para registrar el primer pago del boleto
        public function registrarPago($monto, $fecha, $usuario, $idBoleto) {

            // Sentencia SQL
            $sql = "INSERT INTO pago (monto_pago, fecha_pago, usuario, id_boleto)
                VALUES (:MONTO_PAGO, :FECHA_PAGO, :USUARIO, :ID_BOLETO)";

            // Preparamos la consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos valores
            $marcadores =[':MONTO_PAGO' => $monto, ':FECHA_PAGO' => $fecha, ':USUARIO' => $usuario, ':ID_BOLETO' => $idBoleto];

            // Ejecutamos consulta
            $stmt->execute($marcadores);
        }
    
    }

?>