
<!-- Modal para vender un boleto -->

<div class="modal fade" id="modalVenderBoleto" tabindex="-1" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <!-- Contenido del modal -->
            <div class="modal-header">
                <h3 class="modal-title">Vender boleto</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="vaciarModalVenderBoleto();"></button>
            </div>
      
            <!-- Cuerpo del modal -->
            <div class="modal-body">

                <!-- Formulario de datos para crear el Evento -->
                <form id="formularioVenderBoleto" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                    <!-- Input oculto que almacena el precio total del evento -->
                    <input type="hidden" id="precio_total_evento" name="precio_total_evento">

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label for="nombre_boleto" class="form-label fw-semibold">Nombre: </label>
                            <input class="form-control bg-white border-1 border-secondary" type="text" id="nombre_boleto" name="nombre_boleto" placeholder="Nombre a quien se le vende el boleto" required>
                            <div id="validarNombreBoleto" class=""></div>
                        </div>
                        <div class="col-md-6">
                            <label for="delegados_boleto" class="form-label fw-semibold">Delegados: </label>
                            <input class="form-control bg-white border-1 border-secondary" type="number" id="delegados_boleto" name="delegados_boleto" placeholder="Total de delegados" required>
                            <div id="validarDelegadosBoleto" class=""></div>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label for="distrito_boleto" class="form-label fw-semibold">Distrito: </label>
                            <select class="form-select" id="distrito_boleto" name="distrito_boleto">
                                <option selected>Elige el distrito</option>
                            </select>
                            <div id="validarDistritoBoleto" class=""></div>
                        </div>
                        <div class="col-md-6">
                            <label for="evento_boleto" class="form-label fw-semibold">Evento: </label>
                            <select class="form-select" id="evento_boleto" name="evento_boleto">
                                <option selected>Elige el evento</option>
                            </select>
                            <div id="validarEventoBoleto" class=""></div>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tipo pago: </label> <br>
                            <input class="form-check-input" type="radio" id="pago_completo" name="tipo_pago" value="pago_completo">
                            <label for="pago_completo">Pago completo</label> <br>
                            <input class="form-check-input" type="radio" id="pago_parcial" name="tipo_pago" value="pago_parcial">
                            <label for=" pago_parcial">Pago parcial</label> <br>
                            <input class="form-check-input" type="radio" id="pago_personalizado" name="tipo_pago" value="pago_personalizado">
                            <label for=" pago_personalizado">Pago personalizado</label> <br>
                            <div id="validarTipoPagoBoleto" class=""></div>
                        </div>
                        <div class="col-md-6">
                            <label for="monto_pagado_boleto" class="form-label fw-semibold">Monto pagado: </label>
                            <input class="form-control bg-white border-1 border-secondary" type="number" id="monto_pagado_boleto" name="monto_pagado_boleto" placeholder="Costo en pesos mexicanos" required>
                            <div id="validarMontoPagadoBoleto" class=""></div>
                        </div>
                    </div>

                </form>
        
            </div>

            <!-- Botones u otro contenido adicional en el pie del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="validarFormularioVenderBoleto();">Vender</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="vaciarModalVenderBoleto();">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Script para limpiar formulario -->
<script src="../Action/sweetalert2.js"></script>
<script src="../Action/accionesModalVenderBoleto.js"></script>
<script src="../Action/validarModalVenderBoleto.js"></script>