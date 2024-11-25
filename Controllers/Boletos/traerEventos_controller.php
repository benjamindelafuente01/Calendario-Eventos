<?php

    // Iniciamos o reanudamos la sesion
    session_start();

    // Verificamos si hay una sesion activa
    if (!isset($_SESSION['usuario'])) {

        // Reedirigimos al index
        header('Location: ../../index.php');
        exit();
    }

    // Importamos clase para consultar opciones
    require __DIR__ . '/../../Classes/boletos_class.php';

    // Especificamos que se va a devolver un json
    header('Content-Type: application/json');

    // Instanciamos un objeto
    $eventos = new Boleto();

    // Consultamos los eventos
    $opcionesEventos = $eventos->consultarEventos();

    // Verificamos resultado
    if ($opcionesEventos != false) {
        
        // Procesamos respuesta
        $resultado = [
            'exito' => true,
            'opciones' => $opcionesEventos
        ];
        echo json_encode($resultado);

    } else {
        $resultado = [
            'exito' => false,
            'mensaje' => 'Error al cargar los eventos'
        ];
        echo json_encode($resultado);
    }

?>