<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de pagos parciales</title>
    <link rel="stylesheet" href="../BootStrap 5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/estilos-pagos-parciales.css">
</head>

<body class="bg-info-subtle d-flex justify-content-center">

    <!---------------------------------------->
    <!--         Menu de navegación         -->
    <!---------------------------------------->
    <div class="mb-5">
        <nav class="navbar fixed-top" style="background-color: #45469A;">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between w-100">

                    <div>
                        <button class="navbar-toggler me-2 bg-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                                <span class="navbar-toggler-icon"></span>
                        </button>
                        <a class="navbar-brand text-white" href="#">Menú</a>
                    </div>

                    <div>
                        <a href="#" class="btn-close-white" data-bs-toggle="modal" data-bs-target="#modalVenderBoleto">
                            <img src="../Iconos/anadir.png" class="" width="50" alt="Add Event">
                        </a>
                    </div>

                </div>
        
                <div class="offcanvas offcanvas-start text-white" tabindex="-1" id="offcanvasNavbar"  style="background-color: #45469A;">
                    <div class="offcanvas-header">
                        <h2 class="offcanvas-title" id="offcanvasNavbarLabel">Menú</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
                    </div>

                    <hr class="mb-3">
            
                    <div class="offcanvas-body text-white">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a href="Inicio_view.php" class="nav-link active text-white fw-semibold" style="font-size: 1.3rem">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a href="eventos_view.php" class="nav-link active text-white fw-semibold" style="font-size: 1.3rem">Eventos</a>
                            </li>
                            <li class="nav-item">
                                <a href="pagos_parciales_view.php" class="nav-link active text-white fw-semibold" style="font-size: 1.3rem">Pagos parciales</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link active text-white fw-semibold" style="font-size: 1.3rem">Salir</a>
                            </li>
                        </ul>
                        <form class="d-flex mt-3" role="search">
                            <input class="form-control me-2" type="search" placeholder="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    
    <!---------------------------------------->
    <!--      Contenedor de la pagina       -->
    <!---------------------------------------->
    <div class="mt-5 mb-5 w-100">

        <!-- Contenedor de formulario y tabla -->
        <div class="container my-5 ">

            <!-- Contenedor del titulo -->
            <div class="text-center text-primary-emphasis fs-1 fw-bold">
                Gestión de Pagos Parciales
            </div>

            <!-- Formulario de búsqueda -->
            <form id="formularioPagosParciales" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="row g-3 mt-3">
                <div class="col-md-6">
                    <label for="buscar_por_usuario" class="form-label fw-semibold">Buscar por Usuario</label>
                    <input type="text" class="form-control bg-white border-1 border-secondary" id="buscar_por_usuario" name="buscar_por_usuario" placeholder="Nombre del usuario">
                </div>
                <div class="col-md-6">
                    <label for="buscar_por_evento" class="form-label fw-semibold">Buscar por Evento</label>
                    <input type="text" class="form-control bg-white border-1 border-secondary" id="buscar_por_evento" name="buscar_por_evento" placeholder="Nombre del evento">
                </div>
                <div class="col-12">
                    <button type="button" id="buscarPagoParcial" name="buscarPagoParcial" class="btn btn-primary" onclick="validarBusquedaPagoParcial();">Buscar</button>
                </div>
            </form>

            <!-- Tabla de resultados -->
            <div class="table-responsive mt-4" id="contenedorTablaPagosPendientes" style="display: none;">
                <table class="table table-striped" id="tablaPagosPendientes">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Evento</th>
                            <th>Costo Evento</th>
                            <th>Total Pagado</th>
                            <th>Saldo Restante</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="resultadosPagosPendientes">
                        <!-- Aqui iran las filas -->
                    </tbody>
                </table>
            </div>

        </div>
    </div>


    <!-- Script -->
    <script src="../BootStrap 5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="../Action/sweetalert2.js"></script>
    <script src="../Action/buscarPago.js"></script>

    <?php
        require ('../Modals/realizarPagoParcial_modal.php');
    ?>

</body>
</html>