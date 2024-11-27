<?php

    /*
        Controlador para escribir la nueva contraseña del usuario
    */

    // Importamos archivo con la clase
    require __DIR__ . '/../Classes/inicioSesion_class.php';


    // Verificamos que el metodo de solicitud haya sido post
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Obtenemos y sanitizamos los datos
        $correo = filter_var($_POST['correo_recuperacion'], FILTER_SANITIZE_EMAIL);
        $contra1 = filter_var($_POST['nueva_contra'], FILTER_SANITIZE_STRING);
        $contra2 = filter_var($_POST['confirmacion_nueva_contra'], FILTER_SANITIZE_STRING);

        // Instanciamos objeto de la clase
        $sesion = new inicioSesion();

        // Verificamos que las dos contraseñas sean iguales
        if ($contra1 != $contra2) {
            header('Location: ../Views/Recuperar_contra_view.php');
            exit();
        }

        // Consultamos el usuario
        $usuario = $sesion->verificarUsuario($correo);

        // Verificamos que el usuario existe
        if (!$usuario) {
            header('Location: ../Views/Recuperar_contra_view.php');
            exit();

        } else {

            // Encriptamos la contraseña
            $contra_encriptada = password_hash($contra1, PASSWORD_ARGON2ID);

            // Cambiamos contraseña
            $cambiarContra = $sesion->cambiarContra($correo, $contra_encriptada);

            // Verificamos si se actualizo correctamente
            if ($cambiarContra) {

                // Iniciamos una nueva sesion
                session_start();
                // Generamos nuevo ID de sesion
                session_regenerate_id(true);
                // Almacenamos el nombre en la sesion
                $_SESSION['usuario'] = $usuario['nombre'];

                // Enviamos al inicio
                header('Location: ../Views/Inicio_view.php');
                exit();
            }
        }
    }

?>