<?php

    /*
        Controlador para agregar un pago parcial. Recibe los datos de un nuevo pago y guardamos, asi como
        actualizamos datos del boleto
    */

    // Iniciamos o reanudamos la sesion
    session_start();

    // Verificamos si hay una sesion activa
    if (!isset($_SESSION['usuario'])) {

        // Reedirigimos al index
        header('Location: ../index.php');
        exit();
    }
    
    // Importamos clase de conexion
    require __DIR__ . '/../Classes/pagos_class.php';

    // Establecemos la zona horaria como CDMX
    date_default_timezone_set('America/Mexico_City');

    // Especificamos que devolveremos un json
    header('Content-type: application/json');

    // Verificamos que la solicitud haya sido mediante POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Instanciamos objeto de la clase para agregar pago
        $realizarPago = new PagoParcial();

        // Accedemos a los valores del formulario y sanitizamos
        $idBoleto = filter_var($_POST['id_boleto'], FILTER_SANITIZE_STRING);
        $montoAbonado = filter_var($_POST['monto_pago_parcial'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $saldoRestante = filter_var($_POST['saldo_restante_pago_parcial'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        // Almacenamos fecha de registro del pago
        $fechaPago = date("Y-m-d H:i:s");

        // Accedemos al usuario de la sesion
        $usuario = $_SESSION['usuario'];

        // Verificamos si se realizo el pago completo
        $finiquitado = $montoAbonado == $saldoRestante ? true : false;

        // Intentamos realizar pago y actualizar boleto
        try {

            // Iniciamos la transaccion
            $realizarPago->iniciarTransaccion();

            // Guardamos pago parcial
            $realizarPago->guardarPagoParcial($montoAbonado, $fechaPago, $usuario, $idBoleto);

            // Actualizamos boleto asociado
            $realizarPago->actualizarBoleto($idBoleto, $montoAbonado, $finiquitado);

            // Guardamos transaccion
            $realizarPago->confirmarTransaccion();

            // Enviamos respuesta de exito
            echo json_encode(['exito' => true, 'mensaje' => 'Pago realizado correctamente']);

        } catch(Exception $e) {

            // Si algo salio mal revertimos cambios
            $realizarPago->revertirTransaccion();

            // Enviamos respuesta de error
            echo json_encode(['exito' => false, 'mensaje' => 'Error al guardar el pago']);
        }
    }

?>