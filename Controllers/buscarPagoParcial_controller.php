<?php

    /*
        Controlador para realizar la busqueda de los boletos pendientes que consulto el usuario
    */

    // Importamos clase
    require __DIR__ . '/../Classes/pagos_class.php';

    // Especificamos que devolveremos un json
    header('Content-type: application/json');

    // Verificamos que se haya solicitado mediante PSOT
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Instanciamos objeto de la clase
        $pago = new PagoParcial();

        // Accedemos a los datos de la peticion y convertimos a arreglo asociativo (por eso el true)
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Guardamos valores individuales
        $tipo_busqueda = $data['tipo'];
        $valor_busqueda = $data['valor'];

        // Arreglo para almacenar respuesta
        $resultado = [];

        // Verificamos el tipo de busqueda
        if ($tipo_busqueda == 'usuario') {

            // Realizamos busqueda por usuario
            $resultado_por_usuarios = $pago->pagoPendienteUsuario($valor_busqueda);

            // Verificamos resultado de usuarios
            if ($resultado_por_usuarios != false) {
                $resultado = [
                    'exito' => true,
                    'mensaje' => $resultado_por_usuarios
                ];

            } else {
                $resultado = [
                    'exito' => false,
                    'mensaje' => 'No se encontraron registros que coincidan con la busqueda'
                ];
            }

        } else if ($tipo_busqueda == 'evento') {

            // Realizamos busqueda por evento
            $resultado_por_eventos = $pago->pagoPendienteEvento($valor_busqueda);

            // Verificamos resultado
            if ($resultado_por_eventos != false) {
                $resultado = [
                    'exito' => true,
                    'mensaje' => $resultado_por_eventos
                ];

            } else {
                $resultado = [
                    'exito' => false,
                    'mensaje' => 'No se encontraron registros que coincidan con la busqueda'
                ];
            }
        }

        // Devolvemos respuesta
        echo json_encode($resultado);
    }

?>