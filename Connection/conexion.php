<?php

    // Importamos archivo de configuración
    require 'config.php';

    /*
        Clase que crea una conexión a la base de datos
    */
    class ConexionBD {

        // Atributos
        protected $conexion_pdo;

        // Método Constructor
        public function __construct() {
            try {
    
                // Realizamos la conexion
                $this->conexion_pdo = new PDO (DATA_SOURCE_NAME, USER, PASSWORD);
    
                // Configuramos PDO para que lance excepciones
                $this->conexion_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                die ('Error de conexión: ' . $e.getMessage());
            }
        }
    }

?>