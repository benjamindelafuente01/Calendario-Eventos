
<!-- Modal para reportar gastos -->
 
<div class="modal fade" id="modalGenerarGasto" tabindex="-1" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <!-- Contenido del modal -->
            <div class="modal-header">
                <h3 class="modal-title">Reportar Gasto</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="vaciarModalGenerarGasto();"></button>
            </div>
      
            <!-- Cuerpo del modal -->
            <div class="modal-body">

                <!-- Formulario de datos para crear el Evento -->
                <form id="formularioGastoEvento" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                    <!-- Input oculto que almacena el ID -->
                    <input type="hidden" id="id_evento_gasto" name="id_evento_gasto">

                    <div class="row g-3">
                        <div class="col-md-12 mb-1">
                            <label for="nombre_gasto" class="form-label fw-semibold">Concepto del gasto: </label>
                            <input class="form-control bg-white border-1 border-secondary" type="text" id="nombre_gasto" name="nombre_gasto" required>
                            <div id="validarConceptoGasto" class=""></div>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label for="monto_gasto" class="form-label fw-semibold">Monto del gasto: </label>
                            <input class="form-control bg-white border-1 border-secondary" type="number" id="monto_gasto" name="monto_gasto" required>
                            <div id="validarMontoGasto" class=""></div>
                        </div>
                        
                        <div class="col-md-6 mb-1">
                            <label for="fecha_gasto" class="form-label fw-semibold">Fecha del gasto registrado: </label>
                            <input class="form-control bg-white border-1 border-secondary" type="date" id="fecha_gasto" name="fecha_gasto" required>
                            <div id="validarFechaGasto" class=""></div>
                        </div>
                    </div>

                </form>
        
            </div>

            <!-- Botones u otro contenido adicional en el pie del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="validarFormularioGasto();">Agregar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="vaciarModalGenerarGasto();">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Script para limpiar formulario -->
<script src="../Action/sweetalert2.js"></script>
<script src="../Action/validarModalGenerarGasto.js"></script>