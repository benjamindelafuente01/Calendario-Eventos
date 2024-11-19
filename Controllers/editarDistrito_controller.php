<?php

    /*
        Controlador para actualizar el nombre de un distrito
    */

    // Importamos clase con el metodo para guardar gasto
    require __DIR__ . '/../Classes/distritos_class.php';
    
    // Especificamos que devolveremos un json
    header('Content-type: application/json');

    // Verificamos que el método de solicitud haya sido POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Obtenemos los datos y los sanitizamos
        $id_distrito = filter_var($_POST['id_distrito_editar'], FILTER_SANITIZE_STRING);
        $nombre_distrito = filter_var($_POST['nuevo_nombre_distrito'], FILTER_SANITIZE_STRING);

        // Instanciamos objeto de la clase
        $distrito = new Distrito();

        // Guardamos gasto
        $actualizarDistrito = $distrito->actualizarDistrito($id_distrito, $nombre_distrito);

        // Verificamos el reusltado
        if ($actualizarDistrito) {
            $resultado = [
                'exito' => true,
                'mensaje' => 'Distrito actualizado correctamente'
            ];
        } else {
            $resultado = [
                'exito' => false,
                'mensaje' => 'El distrito no se pudo actualizar'
            ];
        }

        // Enviamos JSON
        echo json_encode($resultado);
    }
    
?>