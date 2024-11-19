<?php
    /*
        Controlador para traer los distritos existentes
    */

    // Importamos clase de distritos
    require __DIR__ . '/../Classes/distritos_class.php';

    // Especificamos que devolveremos un json
    header('Content-type: application/json');

    // Verificamos que el metodo de solicitud haya sido POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Instanciamos objeto de la clase
        $distrito = new Distrito();

        // Almacenamos los distritos
        $arregloDistritos = $distrito->consultarDistritos();

        // Verificamos el reusltado
        if ($arregloDistritos) {
            $resultado = [
                'exito' => true,
                'mensaje' => $arregloDistritos
            ];
        } else {
            $resultado = [
                'exito' => false,
                'mensaje' => 'Error al consultar los distritos'
            ];
        }

        // Devolvemos json
        echo json_encode($resultado);
    }

?>