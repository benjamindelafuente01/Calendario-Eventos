<?php

    /*
        Controlador para solicitar los todos los eventos y mostrarlos en el menu de eventos
    */

    // Importamos arhivo con clase que hace la petición de los eventos
    require __DIR__ . '/../Classes/eventos_class.php';

    // Especificamos que se va a devolver un JSON
    header('Content-Type: application/json');

    // Instanciamos la clase
    $eventosBD = new Eventos();

    // Consultamos los eventos
    $eventos = $eventosBD->traerEventos();

    // Validamos la respuesta
    if ($eventos == false) {
        // Si no hay eventos devolvemos un arreglos vacío
        $sinEventos = [];
        // Devolvemos arreglo vacío en formato JSON
        echo json_encode($sinEventos);
    
    } else {
        // Devolvemos los eventos en formato JSON
        echo json_encode($eventos);
    }

?>