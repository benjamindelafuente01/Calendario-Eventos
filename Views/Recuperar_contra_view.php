<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="../BootStrap 5.3.3/css/bootstrap.min.css">
</head>


<body class="bg-info-subtle d-flex justify-content-center vh-100">

    <!-- Contenedor de los elementos -->
    <div class="bg-white rounded-5 shadow" style="width: 35rem;">

        <!---------------------------------------->
        <!--         Contenedor titulo          -->
        <!---------------------------------------->
        <div class="row g-3 mt-1">
            <div class="col-md-12 text-center text-primary-emphasis fs-1 fw-bold">
                <img src="../Iconos/contrasena.png" alt="register-icon" height="50rem">
                Recuperar contraseña
            </div>
        </div>

        <hr class="mb-3">

        <!---------------------------------------->
        <!--     Contenedor del formulario      -->
        <!---------------------------------------->
        <div class="mx-4 fs-1px">
            <form  action="../Controllers/recuperarContra_controller.php" method="POST">

                <!-- Fila Correo y Respuesta secreta -->
                <div class="row g-3 mt-4">
                    <div class="col-md-12">
                        <label for="correo_recuperacion" class="form-label fw-semibold">Correo electrónico: </label>
                        <input class="form-control bg-light" type="email" id="correo_recuperacion" name="correo_recuperacion" placeholder="" required>
                    </div>
                    
                    <!-- <div class="col-md-6">
                        <label for="respuesta_recuperacion" class="form-label fw-semibold">Respuesta de pregunta secreta: </label>
                        <input class="form-control bg-light" type="text" id="respuesta_recuperacion" name="respuesta_recuperacion" placeholder="" required>
                    </div> -->

                </div>

                <!-- Fila Nueva contraseña y confirmación -->
                <div class="row g-3 mt-3">
                <div class="col-md-6">
                        <label for="nueva_contra" class="form-label fw-semibold">Ingrese una nueva contraseña: </label>
                        <input class="form-control bg-light" type="password" id="nueva_contra" name="nueva_contra" placeholder="" required>
                    </div>

                    <div class="col-md-6">
                        <label for="confirmacion_nueva_contra" class="form-label fw-semibold">Confirmar nueva contraseña: </label>
                        <input class="form-control bg-light" type="password" id="confirmacion_nueva_contra" name="confirmacion_nueva_contra" placeholder="" required>
                    </div>
                </div>

                <!-- Fila de botones -->
                <div class="row g-3 justify-content-center mt-5">
                    <a href="Iniciar_sesion_view.php"  class="btn btn-secondary text-white fw-semibold w-25 mx-2">Volver</a>
                    <button type="submit" class="btn btn-primary text-white fw-semibold w-25 mx-2" id ="formulario_recuperar_cuenta" name="formulario_recuperar_cuenta">Actualizar</button>
                </div>

            </form>

        </div>

    </div>

</body>
</html>