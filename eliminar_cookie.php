<?php

    // Reanudar la sesión que está abierta
    session_start();

    /*
        Script para eliminar cookie
    */
    if (isset($_COOKIE['recordar_usuario'])) {
        // Eliminamos cookie
        setcookie('recordar_usuario', '', time() - 1, '/');
    } else {
        echo 'La cookie no existe';
    }

    // Liberamos las variables de la sesión actual
    session_unset();

    // Finalizamos la sesión
    session_destroy();

    echo ' Cookie y Sesion eliminadas correctamente';

?>