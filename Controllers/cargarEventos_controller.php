<?php

    /*
        Controlador donde se consultan los eventos de la base de datos y a través de la función
        'convertirEventos()' se verifica que contenga eventos y se crea un arreglo que  en el 
        formato que la vista puede recibir.
    */

    // Importamos el archivo de la clase que inserta un nuevo evento
    require __DIR__ . '/../Classes/inicio_class.php';

    // Especificamos que se va a devolver un JSON
    header('Content-Type: application/json');

    // Instanciamos la clase
    $traerEventos = new Evento();

    // Consultamos los eventos
    $eventosBD = $traerEventos->traerEventos();

    // Llamamos a la función para convertir arreglo de Base de datos a un arreglo que acepte FullCalendar
    $eventosCalendario = convertirEventos($eventosBD);

    // Convertir el nuevo arreglo a JSON (con echo devolvemos cada que se llame el script)
    echo json_encode($eventosCalendario);


    /*
        Función para convertir el array de los eventos en un JSON valido
        Recibe el arreglo de base de datos y lo convierte aun arreglo listo para convertir a JSON
    */
    function convertirEventos ($eventos) {

        // Verificamos si es diferente de false
        if ($eventos == false) {
            // Regresamos un arreglo vacio
            $eventosVacio = [];
            return $eventosVacio;

        } else {

            // Array que contendrá los eventos
            $eventosJson = array();
            // Arrreglo auxiliar
            $arregloAuxiliar = [];

            // Recorremos arreglo para agregar eventos de forma individual con arreglo auxiliar
            foreach($eventos as $evento) {
                $arregloAuxiliar = array (
                    'title' => $evento['nombre'],
                    'start' => $evento['fecha_inicio'] .  'T' . $evento['hora_inicio'],
                    'end' => $evento['fecha_fin'] . 'T' . $evento['hora_fin'],
                    'color' => $evento['color']
                );
                // Agregamos arreglo auxilixar al arreglo principal
                array_push($eventosJson, $arregloAuxiliar);
            }

            return $eventosJson;
        }
    }

?>