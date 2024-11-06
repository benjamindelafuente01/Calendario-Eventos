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
    }

?>