<?php
    date_default_timezone_set('America/Mexico_City');
?>

<div class="modal fade" id="modalAgregarEvento" tabindex="-1" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <!-- Contenido del modal -->
            <div class="modal-header">
                <h3 class="modal-title">Crear un nuevo Evento</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="vaciarModalNuevoEvento();"></button>
            </div>
      
            <!-- Cuerpo del modal -->
            <div class="modal-body">

                <!-- Formulario de datos para crear el Evento -->
                <form id="formularioCrearEvento" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label for="nombre_evento" class="form-label fw-semibold">Nombre evento: </label>
                            <input class="form-control bg-white border-1 border-secondary" type="text" id="nombre_evento" name="nombre_evento" placeholder="Asigna un nombre al evento" required>
                            <div id="validarNombreEvento" class=""></div>
                        </div>
                        <div class="col-md-6">
                            <label for="costo_evento" class="form-label fw-semibold">Costo del boleto: </label>
                            <input class="form-control bg-white border-1 border-secondary" type="number" id="costo_evento" name="costo_evento" placeholder="Costo en pesos mexicanos" required>
                            <div id="validarCostoEvento" class=""></div>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label for="fecha_inicio_evento" class="form-label fw-semibold">Fecha de inicio: </label>
                            <input class="form-control bg-white border-1 border-secondary" type="date" id="fecha_inicio_evento" name="fecha_inicio_evento" min="<?php $hoy=date("Y-m-d"); echo $hoy;?>" required>
                            <div id="validarFechaInicio" class=""></div>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_fin_evento" class="form-label fw-semibold">Fecha de fin: </label>
                            <input class="form-control bg-white border-1 border-secondary" type="date" id="fecha_fin_evento" name="fecha_fin_evento" disabled required>
                            <div id="validarFechaFin" class=""></div>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label for="hora_inicio_evento" class="form-label fw-semibold">Hora de inicio: </label>
                            <input class="form-control bg-white border-1 border-secondary" type="time" id="hora_inicio_evento" name="hora_inicio_evento" required>
                            <div id="validarHoraInicio" class=""></div>
                        </div>
                        <div class="col-md-6">
                            <label for="color_evento" class="form-label fw-semibold">Color evento: </label>
                            <input class="form-control form-control-color bg-white border-1 border-secondary" type="color" id="color_evento" name="color_evento" value="#3788D8" title="Elige un color" required>
                            <div id="validarColorEvento" class=""></div>
                        </div>
                    </div>

                </form>
        
            </div>

            <!-- Botones u otro contenido adicional en el pie del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="validarCampos();">Agregar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="vaciarModalNuevoEvento();">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Script para limpiar formulario -->
<script src="../Action/validarModalCrearEvento.js"></script>