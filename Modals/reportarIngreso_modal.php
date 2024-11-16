
<!-- Modal para reportar ingresos -->
 
<div class="modal fade" id="modalReportarIngreso" tabindex="-1" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <!-- Contenido del modal -->
            <div class="modal-header">
                <h3 class="modal-title">Reportar Ingreso</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="vaciarModalReportarIngreso();"></button>
            </div>
      
            <!-- Cuerpo del modal -->
            <div class="modal-body">

                <!-- Formulario de datos para crear el Evento -->
                <form id="formularioIngresoEvento" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                    <!-- Input oculto que almacena el ID -->
                    <input type="hidden" id="id_evento_ingreso" name="id_evento_ingreso">

                    <div class="row g-3">
                        <div class="col-md-6 mb-1">
                            <label for="tipo_ingreso_evento" class="form-label fw-semibold">Evento: </label>
                            <select class="form-select" id="tipo_ingreso_evento" name="tipo_ingreso_evento">
                                <option value="tienda">Tienda</option>
                                <option value="ofrenda">Ofrendas</option>
                            </select>
                            <div id="validarTipoIngreso" class=""></div>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label for="monto_ingreso" class="form-label fw-semibold">Monto del ingreso: </label>
                            <input class="form-control bg-white border-1 border-secondary" type="number" id="monto_ingreso" name="monto_ingreso" required>
                            <div id="validarMontoIngreso" class=""></div>
                        </div>
                        
                    </div>

                </form>
        
            </div>

            <!-- Botones u otro contenido adicional en el pie del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="validarFormularioIngreso();">Agregar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="vaciarModalReportarIngreso();">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Script para validar formulario -->
<script src="../Action/validarModalReportarIngreso.js"></script>