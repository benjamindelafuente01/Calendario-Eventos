<!-- Modal para ralizar un pago parcial de un boleto -->
 
<div class="modal fade" id="modalRealizarPagoParcial" tabindex="-1" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <!-- Contenido del modal -->
            <div class="modal-header">
                <h3 class="modal-title">Agregar Pago</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="vaciarModalPagoParcial();"></button>
            </div>
      
            <!-- Cuerpo del modal -->
            <div class="modal-body">

                <!-- Formulario de datos para crear el Evento -->
                <form id="formularioPagoParcial" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                    <!-- Input oculto que almacena el ID del boleto -->
                    <input type="hidden" id="id_boleto" name="id_boleto">

                    <div class="row g-3">
                        <div class="col-md-6 mb-1">
                            <label for="nombre_pago_parcial" class="form-label fw-semibold">Nombre: </label>
                            <input class="form-control bg-white border-1 border-secondary input-readonly" type="text" id="nombre_pago_parcial" name="nombre_pago_parcial" readonly required>
                            <div id="validarNombrePago" class=""></div>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label for="nombre_evento_pago_parcial" class="form-label fw-semibold">Evento: </label>
                            <input class="form-control bg-white border-1 border-secondary input-readonly" type="text" id="nombre_evento_pago_parcial" name="nombre_evento_pago_parcial" readonly required>
                            <div id="validarEventoPago" class=""></div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 mb-1">
                            <label for="costo_evento_pago_parcial" class="form-label fw-semibold">Costo Total: </label>
                            <input class="form-control bg-white border-1 border-secondary input-readonly" type="number" id="costo_evento_pago_parcial" name="costo_evento_pago_parcial" readonly required>
                            <div id="validarCostoTotalPago" class=""></div>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label for="total_pagado_pago_parcial" class="form-label fw-semibold">Total Pagado: </label>
                            <input class="form-control bg-white border-1 border-secondary input-readonly" type="number" id="total_pagado_pago_parcial" name="total_pagado_pago_parcial" readonly required>
                            <div id="validarTotalPagadoPago" class=""></div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 mb-1">
                            <label for="saldo_restante_pago_parcial" class="form-label fw-semibold">Saldo Restante: </label>
                            <input class="form-control bg-white border-1 border-secondary input-readonly" type="number" id="saldo_restante_pago_parcial" name="saldo_restante_pago_parcial" readonly required>
                            <div id="validarSaldoRestantePago" class=""></div>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label for="monto_pago_parcial" class="form-label fw-semibold">Monto Abonado: </label>
                            <input class="form-control bg-white border-1 border-secondary" type="number" id="monto_pago_parcial" name="monto_pago_parcial" required>
                            <div id="validarMontoPago" class=""></div>
                        </div>
                    </div>

                </form>
        
            </div>

            <!-- Botones u otro contenido adicional en el pie del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="validarFormularioPagoParcial();">Agregar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="vaciarModalPagoParcial();">Cancelar</button>
            </div>
        </div>
    </div>
</div>


<!-- Script para validar el formulario -->
<script src="../Action/validarModalPagoParcial.js"></script>