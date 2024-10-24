<?php

    // Importamos clase para consultar opciones
    require __DIR__ . '/../../Classes/boletos_class.php';

    // Especificamos que se va a devolver un json
    header('Content-Type: application/json');

    // Instanciamos un objeto
    $distritos = new Boleto();

    // Consultamos los distritos
    $opcionesDistritos = $distritos->consultarDistritos();

    // Verificamos resultado
    if ($opcionesDistritos != false) {
        
        // Procesamos respuesta
        $resultado = [
            'exito' => true,
            'opciones' => $opcionesDistritos
        ];
        echo json_encode($resultado);

    } else {
        $resultado = [
            'exito' => false,
            'mensaje' => 'Error al cargar los distritos'
        ];
        echo json_encode($resultado);
    }

?>