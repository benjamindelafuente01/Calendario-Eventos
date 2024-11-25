<?php

    /*
        Controlador para guardar un nuevo distrito
    */

    // Iniciamos o reanudamos la sesion
    session_start();

    // Verificamos si hay una sesion activa
    if (!isset($_SESSION['usuario'])) {

        // Reedirigimos al index
        header('Location: ../index.php');
        exit();
    }

    // Importamos clase con el metodo para guardar gasto
    require __DIR__ . '/../Classes/distritos_class.php';
    
    // Especificamos que devolveremos un json
    header('Content-type: application/json');

    // Verificamos que el método de solicitud haya sido POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Obtenemos los datos y los sanitizamos
        $nombre_distrito = filter_var($_POST['nombre_distrito'], FILTER_SANITIZE_STRING);

        // Instanciamos objeto de la clase
        $distrito = new Distrito();

        // Guardamos gasto
        $guardarDistrito = $distrito->agregarDistrito($nombre_distrito);

        // Verificamos el reusltado
        if ($guardarDistrito) {
            $resultado = [
                'exito' => true,
                'mensaje' => 'Distrito agregado correctamente'
            ];
        } else {
            $resultado = [
                'exito' => false,
                'mensaje' => 'El distrito no se pudo agregar'
            ];
        }

        // Enviamos JSON
        echo json_encode($resultado);
    }
    
?>