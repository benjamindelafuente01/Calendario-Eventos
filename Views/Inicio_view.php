<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../BootStrap 5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/estilos-inicio.css">
    <!-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script> -->

</head>

<body class="bg-info-subtle d-flex justify-content-center">

    <!---------------------------------------->
    <!--         Menu de navegación         -->
    <!---------------------------------------->
    <div class="mb-3">
        <nav class="navbar fixed-top" style="background-color: #45469A;">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between w-100">

                    <div>
                        <button class="navbar-toggler me-2 bg-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                                <span class="navbar-toggler-icon"></span>
                        </button>
                        <a class="navbar-brand text-white" href="#">Menú</a>
                    </div>

                    <div class="navbar-brand text-white me-2">
                        Crear Evento
                        <a href="#" class="btn-close-white" data-bs-toggle="modal" data-bs-target="#modalAgregarEvento">
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
                                <a href="distritos_view.php" class="nav-link active text-white fw-semibold" style="font-size: 1.3rem">Distritos</a>
                            </li>
                            <li class="nav-item">
                                <a href="historial_view.php" class="nav-link active text-white fw-semibold" style="font-size: 1.3rem">Historial eventos</a>
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
    <!--   Contenedor titulo y calendario   -->
    <!---------------------------------------->
    <div class="container mt-5 pt-5"> 
        
        <!-- Fila que contiene titulo y calendario -->
        <div class="row justify-content-center">
            
            <!-- Cntenedor Titulo -->
            <div class="col-12 text-center text-primary-emphasis fs-1 fw-bold">
                <img src="../Iconos/calendario.png" alt="calendar-icon" height="50rem">
                Próximos eventos
            </div>

            <!-- Contenedor Calendario -->
            <div class="col-12 mt-4">
                <div class="calendario bg-white m-3 p-5 rounded-5 text-secondary shadow vh-100" id="calendar"></div>
            </div>
        </div>
    </div>

    <script src="../BootStrap 5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="../fullcalendar-6.1.15/dist/index.global.min.js"></script>
    <script src="../Action/cargarCalendario.js"></script>

    <?php
        require ('../Modals/agregarEvento_modal.php');
    ?>
    
</body>
</html>