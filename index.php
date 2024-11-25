<?php

    /*
        Archivo index principal
    */

    // Iniciamos o reanudamos la sesion
    session_start();

    /*
        Verificamos si hay una sesion activa y reedirigimos al index o al contenido
    */
    if (!isset($_SESSION['usuario'])) {

        /*
            Si no hay sesion verificamos si no hay una cookie
        */
        if (isset($_COOKIE['recordar_usuario'])) {

            // Guardamos el nombre del usuario en una sesion
            $_SESSION['usuario'] = $_COOKIE['recordar_usuario'];

            // Reedirigimos al contenido
            header('Location: Views/Inicio_view.php');
            exit();
        
        } else {
            
            // Si no hay sesion ni cookie reedirigimos al inicio de sesion
            header('Location: Views/Iniciar_sesion_view.php');
            exit();
        }

    } else {

        // Si existe una sesion activa, reedirigimos al contenido
        header('Location: Views/Inicio_view.php');
        exit();
    }

?>