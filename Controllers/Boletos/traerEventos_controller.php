<?php

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