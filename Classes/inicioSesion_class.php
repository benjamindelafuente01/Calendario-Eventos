<?php

    // Importamos archivo de conexion
    require __DIR__ . '/../Connection/conexion.php';

    /*
        Clase para verificar el inicio de sesion
    */
    class inicioSesion extends ConexionBD {

        // Metodo constructor
        public function __construct() {

            // Llamamos al constructor de la clase padre
            parent:: __construct();
        }


        // Metodo para buscar el usuario
        public function consultarUsuario ($correo_usuario, $contra) {

            // Sentencia SQL
            $sql = "SELECT * FROM administrador WHERE correo = :CORREO_USUARIO";

            // Preparamos consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos valores
            $stmt->bindParam(':CORREO_USUARIO', $correo_usuario);

            // Ejecutamos consulta
            $stmt->execute();

            // Guardamos resultado
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificamos si el usuario existe y la contraseña es igual a la encriptada
            if ($resultado && password_verify($contra, $resultado['contrasena'])) {
                return $resultado;
            }
            
            return false;
        }


        // Metodo para verificar si el usuario existe
        public function verificarUsuario($correo) {

            // Sentencia SQL
            $sql = "SELECT * FROM administrador WHERE correo = :CORREO";

            // Preparamos consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos valores
            $stmt->bindParam(':CORREO', $correo);

            // Ejecutamos consulta
            $stmt->execute();

            // Guardamos resultado
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificamos resultado
            if ($resultado) {
                return $resultado;
            }

            return false;
        }


        // Metodo para cambiar la contraseña
        public function cambiarContra($correo, $nuevaContra) {

            // Sentencia SQL
            $sql = "UPDATE administrador SET contrasena = :NUEVA_CONTRA WHERE correo = :CORREO_USUARIO";

            // Preparamos la consulta
            $stmt = $this->conexion_pdo->prepare($sql);

            // Asociamos valores
            $stmt->bindParam(':CORREO_USUARIO', $correo);
            $stmt->bindParam(':NUEVA_CONTRA', $nuevaContra);

            // Ejecutamos consulta
            $stmt->execute();

            // Verificamos resultado
            $resultado = $stmt->rowCount() > 0 ? true : false;

            return $resultado;
        }

    }

?>