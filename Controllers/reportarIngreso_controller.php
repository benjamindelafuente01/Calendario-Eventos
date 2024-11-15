<?php

    /*
        Controlador que recibe el monto de un ingreso y lo agrega a base de datos
    */

    // Importamos archivo de conexion
    require __DIR__ . '/../Classes/eventos_class.php';

    // Especificamos que devolveremos un json
    header ('Content-type: application/json');

    // Establecemos la zona horaria como CDMX
    date_default_timezone_set('America/Mexico_City');

    // Verificamos que la solicitud haya sido mediante POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // Instanciamos objeto de la clase para agregar ingreso
        $ingreso = new Eventos();
        
        // Obtenemos datos del formulario y sanitizamos
        $tipo_ingreso = filter_var($_POST['tipo_ingreso_evento'], FILTER_SANITIZE_STRING);
        $monto_ingreso = filter_var($_POST['monto_ingreso'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $id_evento = filter_var($_POST['id_evento_ingreso'], FILTER_SANITIZE_STRING);
        
        // Almacenamos fecha de registro de ingreso
        $fecha_ingreso = date('Y-m-d H:i:s');

        // TODO: Agregamos usuario
        $usuario = 'Benjamin';

        // Guardamos ingreso
        $agregarIngreso = $ingreso->agregarIngreso($tipo_ingreso, $monto_ingreso, $fecha_ingreso, $usuario, $id_evento);

        // Verificamos resultado
        if ($agregarIngreso) {
            $resultado = [
                'exito' => true,
                'mensaje' => 'Ingreso agregado correctamente'
            ];
        } else {
            $resultado = [
                'exito' => false,
                'mensaje' => 'Hubo un error al agregar el ingreso'
            ];
        }

        // Devolvemos json
        echo json_encode($resultado);

    }
    
?>