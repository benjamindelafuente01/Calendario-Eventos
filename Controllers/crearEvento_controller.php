<?php

    // Importamos el archivo de la clase que inserta un nuevo evento
    require __DIR__ . '/../Classes/inicio_class.php';

    // Especificamos que se va a devolver un JSON
    header('Content-Type: application/json');

    // Verificamos la solicitud por POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Obtenemos los datos sanitizados
        $nombreEvento = filter_var($_POST['nombre_evento'], FILTER_SANITIZE_STRING);
        $costoEvento = filter_var($_POST['costo_evento'], FILTER_SANITIZE_STRING);
        $inicioEvento = filter_var($_POST['fecha_inicio_evento'], FILTER_SANITIZE_STRING);
        $finEvento = filter_var($_POST['fecha_fin_evento'], FILTER_SANITIZE_STRING);
        $horaInicioEvento = filter_var($_POST['hora_inicio_evento'], FILTER_SANITIZE_STRING);
        $colorEvento = filter_var($_POST['color_evento'], FILTER_SANITIZE_STRING);

        /*
            Enviamos datos del evento a la base de datos
        */

        // Instancia de la clase
        $guardarEvento = new Evento();

        // Insertamos datos
        $guardarEvento->crearNuevoEvento ($nombreEvento, $inicioEvento, $finEvento, $colorEvento, $costoEvento, $horaInicioEvento);

        // Verificamos resultado de la consulta
        if ($guardarEvento) {
            $respuesta = [
                'exito' => true,
                'mensaje' => 'Evento guardado exitosamente'
            ];
        } else {
            $respuesta = [
                'exito' => false,
                'mensaje' => 'Faltan datos'
            ];
        }

        // Enviar la respuesta en formato JSON
        echo json_encode($respuesta);

    }  else {
        echo json_encode([
            'exito' => false,
            'mensaje' => 'Método no permitido'
        ]);
    }

?>