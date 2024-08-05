<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="../BootStrap 5.3.3/css/bootstrap.min.css">
</head>

<body class="bg-info-subtle d-flex justify-content-center vh-100">

    <!-- Contenedor de los elementos -->
    <div class="bg-white rounded-5 shadow" style="width: 50rem;">

        <!---------------------------------------->
        <!--         Contenedor titulo          -->
        <!---------------------------------------->
        <div class="row g-3">
            <div class="col-md-12 text-center text-primary-emphasis fs-1 fw-bold">
                <img src="../Iconos/registro.png" alt="register-icon" height="50rem">
                Registrar usuario</div>
        </div>

        <hr class="mb-3">

        <!---------------------------------------->
        <!--     Contenedor del formulario      -->
        <!---------------------------------------->
        <div class="mx-4">
            <form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                <div class="fw-bold text-primary">Datos Personales</div>

                <!-- Fila Datos Personales -->
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="nombre_registro_usuario" class="form-label fw-semibold">Nombre: </label>
                        <input class="form-control" type="text" id="nombre_registro_usuario" name="nombre_registro_usuario" placeholder="Ingresa tu nombre" required>
                    </div>

                    <div class="col-md-4">
                        <label for="apellido_paterno_registro_usuario" class="form-label fw-semibold">Apellido paterno: </label>
                        <input class="form-control" type="text" id="apellido_paterno_registro_usuario" name="apellido_paterno_registro_usuario" placeholder="Ingresa tu apellido paterno" required>
                    </div>

                    <div class="col-md-4">
                        <label for="apellido_materno_registro_usuario" class="form-label fw-semibold">Apellido materno: </label>
                        <input class="form-control"type="text" id="apellido_materno_registro_usuario" name="apellido_materno_registro_usuario" placeholder="Ingresa tu apellido materno" required>
                    </div>
                </div>

                <div class="fw-bold text-primary mt-4">Datos Cuenta</div>
                
                <!-- Fila 1 Datos Cuenta -->
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="correo_registro_usuario" class="form-label fw-semibold">Correo electrónico: </label>
                        <input type="email" class="form-control" id="correo_registro_usuario" name="correo_registro_usuario" placeholder="Ingresa tu correo electrónico">
                    </div>
                    <div class="col-md-4">
                        <label for="contra_registro_usuario" class="form-label fw-semibold">Contraseña: </label>
                        <input type="password" class="form-control" id="contra_registro_usuario" name="contra_registro_usuario" placeholder="Ingresa tu contraseña">
                    </div>
                    <div class="col-md-4">
                        <label for="confirmar_contra_registro_usuario" class="form-label fw-semibold">Confirmar contraseña: </label>
                        <input type="password" class="form-control" id="confirmar_contra_registro_usuario" name="confirmar_contra_registro_usuario" placeholder="********">
                    </div>
                </div>

                <!-- Fila 2 Datos Cuenta -->
                <div class="row g-3 mt-1">
                    <div class="col-md-5">
                        <label for="pregunta_secreta_registro_usuario" class="form-label fw-semibold">Pregunta secreta: </label>
                        <select class="form-select" id="pregunta_secreta_registro_usuario" name="pregunta_secreta_registro_usuario">
                            <option selected>Elige tu pregunta</option>
                            <option value="equipo-favorito">Equipo favorito de fútbol</option>
                            <option value="apodo-pequeño">Apodo de niño</option>
                            <option value="mascota-favorita">Nombre mascota favorita</option>
                        </select>
                    </div>
                    <div class="col-md-7">
                        <label for="respuesta_secreta_registro_usuario" class="form-label fw-semibold">Respuesta: </label>
                        <input type="text" class="form-control" id="respuesta_secreta_registro_usuario" name="respuesta_secreta_registro_usuario" placeholder="Respuesta">
                    </div>
                </div>

                <div class="fw-bold text-primary mt-4">Datos Iglesia</div>

                <!-- Fila Datos Iglesia -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="distrito_registro_usuario" class="form-label fw-semibold">Distrito: </label>
                        <input type="text" class="form-control" id="distrito_registro_usuario" name="distrito_registro_usuario" placeholder="Tuxpan II" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="iglesia_registro_usuario" class="form-label fw-semibold">Iglesia: </label>
                        <select class="form-select" id="iglesia_registro_usuario" name="iglesia_registro_usuario">
                            <option selected>Elige tu iglesia</option>
                        </select>
                    </div>
                </div>

                <!-- Fila Botones -->
                <div class="row g-3 justify-content-center mt-3">
                    <button type="reset" class="btn btn-danger text-white fw-semibold w-25 mx-2">Eliminar</button>
                    <button type="submit" class="btn btn-primary text-white fw-semibold w-25 mx-2" id ="formulario_registro_usuario" name="formulario_registro_usuario">Registrarse</button>
                </div>
                
            </form>

        </div>

    </div>
    
</body>
</html>