<?php

    // Importamos clase para consultar opciones
    require __DIR__ . '/../../Classes/boletos_class.php';

    // Especificamos que se va a devolver un json
    header('Content-Type: application/json');

    // Instanciamos un objeto
    $iglesias = new Boleto();

    // Consultamos las iglesias
    $opcionesIglesias = $iglesias->consultarIglesias();

    // Verificamos resultado
    if ($opcionesIglesias != false) {
        
        // Procesamos respuesta
        $resultado = [
            'exito' => true,
            'opciones' => $opcionesIglesias
        ];
        echo json_encode($resultado);

    } else {
        $resultado = [
            'exito' => false,
            'mensaje' => 'Error al cargar las iglesias'
        ];
        echo json_encode($resultado);
    }

?>