<?php

    /*
        Controlador para manejar el cierre de sesion
    */

    // Iniciamos o reanudamos la sesion
    session_start();

    // Liberamos las variables de la sesion actual
    session_unset();

    // Fianlizamos la sesion
    session_destroy();

    // Reedirigimos al inicio de sesion
    header('Location: ../Views/Iniciar_sesion_view.php');

    // Detenemos el script
    exit();

?>