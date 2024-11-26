<?php

    /*
        Controlador que recibe el ID del evento que se desea finalizar
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
    $finalizar = new Eventos();

    // Verificamos que la petición haya sido mediante POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Obtenemos el contenido del cuerpo de la solicitud (un json)
        $data = file_get_contents('php://input');

        // Decodificamos el json en un arreglo asociativo
        $datosDecodificados = json_decode($data, true);

        // Guardamos ID
        $id = $datosDecodificados['id'];

        // Eliminamos evento
        $eventoFinalizado = $finalizar->finalizarEvento($id);

        // Verificamos resultado
        if ($eventoFinalizado) {
            $resultado = [
                'exito' => true,
                'mensaje' => 'Evento finalizado'
            ];
        } else {
            $resultado = [
                'exito' => false,
                'mensaje' => 'Error al finalizar evento'
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