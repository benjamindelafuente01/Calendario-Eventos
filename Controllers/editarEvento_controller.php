<?php

    // Importamos modelo
    require __DIR__ . '/../Classes/eventos_class.php';

    // Especificamos que devolveremos un json
    header('Content-Type: application/json');

    // Verificamos que se haya enviado mediante POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Obtenemos los datos y los sanitizamos
        $id = filter_var($_POST['id_evento_editar'], FILTER_SANITIZE_STRING);
        $nuevoNombre = filter_var($_POST['nombre_evento_editar'], FILTER_SANITIZE_STRING);
        $nuevoCosto = filter_var($_POST['costo_evento_editar'], FILTER_SANITIZE_STRING);
        $nuevoFechaInicio = filter_var($_POST['fecha_inicio_evento_editar'], FILTER_SANITIZE_STRING);
        $nuevoFechaFin = filter_var($_POST['fecha_fin_evento_editar'], FILTER_SANITIZE_STRING);
        $nuevoHoraInicio = filter_var($_POST['hora_inicio_evento_editar'], FILTER_SANITIZE_STRING);
        $nuevoColor = filter_var($_POST['color_evento_editar'], FILTER_SANITIZE_STRING);

        /*
            Enviamos datos actualizados
        */
        
        // instancia de la clase
        $evento = new Eventos();

        // Insertamos datos
        $eventoEditado = $evento->editarEvento($id, $nuevoNombre, $nuevoCosto, $nuevoFechaInicio, $nuevoFechaFin, $nuevoHoraInicio, $nuevoColor);

        // Verificamos si se actualizó correctamente
        if ($eventoEditado) {
            $resultado = [
                'exito' => true,
                'mensaje' => 'Evento actualizado'
            ];
        } else {    
            $resultado = [
                'exito' => false,
                'mensaje' => 'Error al actualizar evento'
            ];
        }

        // Enviamos JSON
        echo json_encode($resultado);
    
    } else {
        echo json_encode([
            'exito' => false,
            'mensaje' => 'Método no permitido'
        ]);
    }

?>