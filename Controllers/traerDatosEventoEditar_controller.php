<?php

    /*
        Controlador donde se consultan los datos del evento seleccionado. Se recibe el ID y se consultan
        los datos para enviarlos de regreso y que se puedan editar
    */

    // Iniciamos o reanudamos la sesion
    session_start();

    // Verificamos si hay una sesion activa
    if (!isset($_SESSION['usuario'])) {

        // Reedirigimos al index
        header('Location: ../index.php');
        exit();
    }

    // Importamos la clase donde se consulta el evento
    require __DIR__ . '/../Classes/eventos_class.php';
    
    // Especificamos que se devolverá un json
    header('Content-Type: application/json');

    // Instanciamos la clase
    $datosEvento = new Eventos();

    // Verificamos que la petición haya sido mediante POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
        // Consultamos el cuerpo de la petición y convertimos a un arreglo asociativo (por eso true)
        $data = json_decode(file_get_contents('php://input'), true);

        // Verificamos que esté establecido el valor
        if (isset($data['id'])) {
            
            // Almacenamos ID
            $id = $data['id'];

            // Realizamos la consulta
            $eventoEditar = $datosEvento->traerDatosEventoEditar($id);

            // Verificamos el resultado de la consulta
            if ($eventoEditar == false) {
                // Si por algún caso se selecciona un id invalido
                $sinDatos = [];
                // Retornamos un json vacío
                echo json_encode($sinDatos);
            
            } else {
                // Regresamos los datos del evento
                echo json_encode($eventoEditar);
            }
        }

    }
?>