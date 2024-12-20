<?php

    // Iniciamos o reanudamos la sesion
    session_start();

    // Verificamos si hay una sesion activa
    if (!isset($_SESSION['usuario'])) {

        // Reedirigimos al index
        header('Location: ../index.php');
        exit();
    }

    // Importamos modelo
    require __DIR__ . '/../Classes/eventos_class.php';

    // Especificamos que devolveremos un json
    header('Content-Type: application/json');

    // Establecemos la zona horario como CDMX
    date_default_timezone_set('America/Mexico_City');

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

        // Valor de hoy (fecha en que se actualizo)
        $fecha_actualizacion = date("Y-m-d H:i:s");
        // Accedemos al usuario de la sesion
        $usuario = $_SESSION['usuario'];

        /*
            Enviamos datos actualizados
        */
        
        // instancia de la clase
        $evento = new Eventos();

        // Insertamos datos
        $eventoEditado = $evento->editarEvento($id, $nuevoNombre, $nuevoCosto, $nuevoFechaInicio, $nuevoFechaFin, $nuevoHoraInicio, $nuevoColor, $usuario, $fecha_actualizacion);

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