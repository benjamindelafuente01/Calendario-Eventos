<?php

    /*
        Controlador que recibe el ID del evento que se desea eliminar
    */

    // Iniciamos o reanudamos la sesion
    session_start();

    // Verificamos si hay una sesion activa
    if (!isset($_SESSION['usuario'])) {

        // Reedirigimos al index
        header('Location: ../index.php');
        exit();
    }

    // Importamos clase
    require __DIR__ . '/../Classes/eventos_class.php';

    // Especificamos que la respuesta será un json
    header('Contect-Type: application/json');

    // Instanciamos un objeto de la clase
    $eliminar = new Eventos();

    // Verificamos que la petición haya sido mediante POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Obtenemos el contenido del cuerpo de la solicitud (un json)
        $data = file_get_contents('php://input');

        // Decodificamos el json en un arreglo asociativo
        $datosDecodificados = json_decode($data, true);

        // Guardamos ID
        $id = $datosDecodificados['id'];

        // Eliminamos evento
        $eventoEliminado = $eliminar->eliminarEvento($id);

        // Verificamos resultado
        if ($eventoEliminado) {
            $resultado = [
                'exito' => true,
                'mensaje' => 'Evento eliminado'
            ];
        } else {
            $resultado = [
                'exito' => false,
                'mensaje' => 'Error al eliminar evento'
            ];
        }

        // Enviamos json
        echo json_encode($resultado);
    
    } else {
        echo json_encode([
            'exito' => false,
            'mensaje' => 'Método no permitido'
        ]);
    }

?>