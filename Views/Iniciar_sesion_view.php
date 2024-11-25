<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="../BootStrap 5.3.3/css/bootstrap.min.css">
    <style>
        .logo-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>

<body class="bg-info-subtle d-flex justify-content-center vh-100 position-relative">


    <!-- Contenedor de los elementos -->
    <div class="bg-white p-5 rounded-5 text-secondary shadow" style="width: 25rem;">
        <!-- Imagen -->
        <div class="d-flex justify-content-center">
            <img src="../Iconos/usuario.png" alt="login-icon" height="150rem">
        </div>
        <div class="text-center fs-1 fw-bold">Iniciar sesión</div>

        <!-- Inicia formulario del login -->
        <form action="../Controllers/iniciarSesion_controller.php" method="POST">

            <!-- Contenedor de correo -->
            <div class="input-group mt-4">
                <!-- Contenedor de imagen de correo -->
                <div class="input-group-text bg-primary">
                    <img src="../Iconos/username-icon.svg" alt="email-icon" height="20rem">
                </div>
                <!-- Input de correo -->
                <input type="email" class="form-control bg-light" style="font-size: 0.9rem" id="correo_inicio_sesion" name="correo_inicio_sesion" placeholder="Correo" required>
            </div>

            <!-- Contenedor de Contraseña -->
            <div class="input-group mt-2">
                <!-- Contenedor de imagen de contraseña -->
                <div  class="input-group-text bg-primary">
                    <img src="../Iconos/password-icon.svg" alt="password-icon" height="20rem">
                </div>
                <!-- Input de Contraseña -->
                <input type="password" class="form-control bg-light" style="font-size: 0.9rem" id="contra_inicio_sesion" name="contra_inicio_sesion" placeholder="Contraseña" required>
            </div>

            <!-- Contenedor de recordar/olvide contraseña -->
            <div  class="d-flex justify-content-around mt-1">
                <!-- Contenedor Recordar contraseña -->
                <div class="d-flex align-items-center gap-1">
                    <input class="form-check-input" type="checkbox" id="recordar_inicio_sesion" name="recordar_inicio_sesion">
                    <div class="pt-2" style="font-size: 0.9rem">Recuérdame</div>
                </div>
                <!-- Contenedor de Olvide la contraseña  -->
                <div class="pt-2">
                <a href="Recuperar_contra_view.php" class="link-underline link-underline-opacity-0 link-underline-opacity-100-hover text-primary fw-semibold" style="font-size: 0.9rem">Olvidé mi contraseña</a>
                </div>
            </div>

            <!-- Contenedor iniciar sesión -->
            <div>
                <input type="submit" class="btn btn-primary text-white fw-semibold  w-100 mt-4" id="boton_iniciar_sesion" name="boton_iniciar_sesion" value="Iniciar Sesión">
            </div>
        </form>

        <!-- Contenedor registrarse -->
        <div class="d-flex gap-1 justify-content-center mt-1">
            <div>¿No tienes una cuenta?</div>
            <a href="Registrar_cuenta_view.php" class="link-underline link-underline-opacity-0 link-underline-opacity-100-hover text-primary fw-semibold">Regístrate</a>
        </div>

        <!-- Contenedor de 'o' -->
        <div class="p-2">
            <div class="border-bottom text-center" style="height: 0.9rem">
                <span class="bg-white px-3">ó</span>
            </div>
        </div>

        <!-- Contenedor iniciar con google -->
        <div class="btn d-flex gap-2 justify-content-center border shadow-sm mt-3">
            <img src="../Iconos/google-icon.svg" alt="google-icon" title="No disponible por el momento" height="25rem">
            <div class="fw-semibold text-secondary">Continuar con Google</div>
        </div>

    </div>

    <!-- Contenedor del logo de empresa -->
    <div class="logo-container">
        <img src="../Iconos/iglesia-icon.png" alt="church-logo" height="100rem">
    </div>


    <script src="../BootStrap 5.3.3/js/bootstrap.bundle.min.js"></script>

</body>

</html>