<?php

    /*
        Controlador para eliminar un distrito
    */

    // Importamos clase para eliminar distrito
    require __DIR__ . '/../Classes/distritos_class.php';

    // Especificamos que devolveremos un json
    header('Content-type: application/json');

    // Verificamos que el metodo de solicitud haya sido POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Instanciamos objeto
        $eliminar = new Distrito();

        // Obtenemos el cuerpo de la solicitud (se habia enviado un json son el id)
        $contenido = file_get_contents('php://input');

        // Convertimos json a un arreglo asociativo
        $datosDecodificados = json_decode($contenido, true);

        // Accedemos al id del evento
        $id_evento = $datosDecodificados['idDistrito'];

        // Eliminamos distrito
        $eliminarDistrito = $eliminar->eliminarDistrito($id_evento);

        // Verificamos resultado
        if ($eliminarDistrito) {
            $resultado = [
                'exito' => true,
                'mensaje' => 'Distrito eliminado'
            ];
        } else {
            $resultado = [
                'exito' => false,
                'mensaje' => 'Error al eliminar distrito'
            ];
        }

        // Enviamos json
        echo json_encode($resultado);
    }


?>