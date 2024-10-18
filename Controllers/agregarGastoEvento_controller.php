<?php

    /*
        Controlador para guardar un nuevo gasto generado
    */

    // Importamos clase con el metodo para guardar gasto
    require __DIR__ . '/../Classes/eventos_class.php';
    
    // Especificamos que devolveremos un json
    header('Content-type: application/json');

    // Verificamos que el método de solicitud haya sido POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Obtenemos los datos y los sanitizamos
        $idEvento = filter_var($_POST['id_evento_gasto'], FILTER_SANITIZE_STRING);
        $concepto = filter_var($_POST['nombre_gasto'], FILTER_SANITIZE_STRING);
        $monto = filter_var($_POST['monto_gasto'], FILTER_SANITIZE_STRING);
        $fecha = filter_var($_POST['fecha_gasto'], FILTER_SANITIZE_STRING);

        // TODO: Agregar usuario
        $usuario = 'Benjamin';

        // Instanciamos objeto de la clase
        $gasto = new Eventos();

        // Guardamos gasto
        $guardarGasto = $gasto->agregarGasto($idEvento, $concepto, $monto, $fecha, $usuario);

        // Verificamos el reusltado
        if ($guardarGasto) {
            $resultado = [
                'exito' => true,
                'mensaje' => 'Gasto agregado correctamente'
            ];
        } else {
            $resultado = [
                'exito' => false,
                'mensaje' => 'El gasto no se pudo agregar'
            ];
        }

        // Enviamos JSON
        echo json_encode($resultado);
    }
    
?>