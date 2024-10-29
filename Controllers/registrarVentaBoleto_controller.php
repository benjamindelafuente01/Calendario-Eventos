<?php

    // Importamos clase
    require __DIR__ . '/../Classes/boletos_class.php';

    // Establecemos la zona horario como CDMX
    date_default_timezone_set('America/Mexico_City');

    // Especificamos que devolveremos un json
    header('Content-type: application/json');

    // Verificamos que la solicitud haya sido mediante POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Instanciamos un objeto de la clase para vender boleto
        $guardarBoleto = new Boleto();

        // Obtenemos los datos y sanitizamos
        $nombre = filter_var($_POST['nombre_boleto'], FILTER_SANITIZE_STRING);
        $distrito = filter_var($_POST['distrito_boleto'], FILTER_SANITIZE_STRING);
        $iglesia = filter_var($_POST['iglesia_boleto'], FILTER_SANITIZE_STRING);
        $precio_total = filter_var($_POST['precio_total_evento'], FILTER_SANITIZE_STRING);
        $precio_pagado = filter_var($_POST['monto_pagado_boleto'], FILTER_SANITIZE_STRING);
        $tipo_pago = filter_var($_POST['tipo_pago'], FILTER_SANITIZE_STRING);
        $id_evento = filter_var($_POST['evento_boleto'], FILTER_SANITIZE_STRING);
        
        // Agregamos la fecha de venta de hoy
        $fecha_venta = date("Y-m-d");
        
        // TODO: Agregar usuario
        $usuario = 'Benjamin';

        // Calculamos si se finiquito o no
        if ($tipo_pago == 'pago_completo') {
            $finiquitado = true;
            $saldo_restante = 0;
        } else if ($tipo_pago == 'pago_parcial') {
            $finiquitado = false;
            $saldo_restante = (float) ($precio_total - $precio_pagado);
        }

        // Realizamos el registro del boleto vendido y del primer pago
        try {
            // Iniciamos la transaccion
            $guardarBoleto->iniciarTransaccion();

            // Damos de alta el boleto y guardamos su id
            $idBoleto = $guardarBoleto->registrarBoleto(
                $nombre,
                $distrito,
                $iglesia,
                $precio_total,
                $precio_pagado,
                $saldo_restante,
                $finiquitado,
                $fecha_venta,
                $usuario,
                $id_evento
            );

            // Almacenamos el primer pago
            $guardarBoleto->registrarPago(
                $precio_pagado, 
                $fecha_venta, 
                $usuario, 
                $idBoleto
            );

            // Confirmamos registros si todo salio bien
            $guardarBoleto->confirmarTransaccion();

            // Enviamos respuesta de exito
            echo json_encode(['exito' => true, 'mensaje' => 'Boleto registrado correctamente']);
        
        } catch (Exception $e) {
            // Revertimos la transaccion
            $guardarBoleto->revertirTransaccion();

            // Enviamos mensaje de error
            // echo json_encode(['exito' => false, 'mensaje' => 'Ocurrió un error al guardar el boleto']);
            echo json_encode(['exito' => false, 'mensaje' => 'Ocurrió un error al guardar la venta del boleto']);
        }

    }

?>