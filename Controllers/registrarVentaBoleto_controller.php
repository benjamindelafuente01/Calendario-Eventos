<?php

    // Iniciamos o reanudamos la sesion
    session_start();

    // Verificamos si hay una sesion activa
    if (!isset($_SESSION['usuario'])) {

        // Reedirigimos al index
        header('Location: ../index.php');
        exit();
    }

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
        $delegados = filter_var($_POST['delegados_boleto'], FILTER_SANITIZE_STRING);
        $precio_evento = filter_var($_POST['precio_total_evento'], FILTER_SANITIZE_STRING);
        $precio_pagado = filter_var($_POST['monto_pagado_boleto'], FILTER_SANITIZE_STRING);
        $tipo_pago = filter_var($_POST['tipo_pago'], FILTER_SANITIZE_STRING);
        $id_evento = filter_var($_POST['evento_boleto'], FILTER_SANITIZE_STRING);

        // Agregamos la fecha de venta de hoy
        $fecha_venta = date("Y-m-d H:i:s");
        
        // Accedemos al usuario de la sesion
        $usuario = $_SESSION['usuario'];

        // Calculamos campos de acuerdo al tipo de pago
        if ($tipo_pago == 'pago_completo') {
            $precio_total = $precio_evento * $delegados;
            $finiquitado = true;
            $saldo_restante = 0;
        } else if ($tipo_pago == 'pago_parcial') {
            $precio_total = $precio_evento * $delegados;
            $finiquitado = false;
            $saldo_restante = (float) ($precio_total - $precio_pagado);
        } else if ($tipo_pago == 'pago_personalizado') {
            $precio_total = $precio_pagado;
            $finiquitado = true;
            $saldo_restante = 0;
        }

        // Realizamos el registro del boleto vendido y del primer pago
        try {
            // Iniciamos la transaccion
            $guardarBoleto->iniciarTransaccion();

            // Damos de alta el boleto y guardamos su id
            $idBoleto = $guardarBoleto->registrarBoleto(
                $nombre,
                $distrito,
                $delegados,
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