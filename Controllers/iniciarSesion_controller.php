<?php

    /*
        Controlador para manejar la lógica del inicio de sesion
    */

    // Importamos archivo con la clase
    require __DIR__ . '/../Classes/inicioSesion_class.php';

    // Verificamos que el metodo de solicitud haya sido POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Obtenemos los datos y sanitizamos
        $correo_usuario = filter_var($_POST['correo_inicio_sesion'], FILTER_SANITIZE_STRING);
        $contra_usuario = filter_var($_POST['contra_inicio_sesion'], FILTER_SANITIZE_STRING);

        // Instanciamos objeto de la clase
        $verificarusuario = new inicioSesion();

        // Llamamos a la funcion de verificar usuario
        $usuarioValido = $verificarusuario->consultarUsuario($correo_usuario, $contra_usuario);

        // Verificamos usuario
        if ($usuarioValido) {

            // Verificamos si se marcó la casilla de recordar usuario
            if (isset($_POST['recordar_inicio_sesion'])) {
                // Creamos cookie
                setcookie('recordar_usuario', $usuarioValido['nombre'], time() + 86400, '/');
            }

            // Creamos una nueva sesion
            session_start();
            // Almacenamos el valor del nombre de usuario
            $_SESSION['usuario'] = $usuarioValido['nombre'];
            // Reedirigimos al inicio del sistema
            header('Location: ../Views/Inicio_view.php');
            exit();

        } else  {
            header ('Location: ../Views/Iniciar_sesion_view.php');
            exit();
        }
    }

?>