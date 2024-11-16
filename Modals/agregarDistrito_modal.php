<!-- Modal para agregar un Distrito -->
 
<div class="modal fade" id="modalAgregarDistrito" tabindex="-1" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <!-- Contenido del modal -->
            <div class="modal-header">
                <h3 class="modal-title">Agregar Distrito</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="vaciarModalAgregarDistrito();"></button>
            </div>
      
            <!-- Cuerpo del modal -->
            <div class="modal-body">

                <!-- Formulario de datos para crear el Evento -->
                <form id="formularioAgregarDistrito" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                    <div class="row g-3">
                        <div class="col-md-12 mb-1">
                            <label for="nombre_distrito" class="form-label fw-semibold">Nombre del Distrito: </label>
                            <input class="form-control bg-white border-1 border-secondary" type="text" id="nombre_distrito" name="nombre_distrito" required>
                            <div id="validarNombreDistrito" class=""></div>
                        </div>
                    </div>

                </form>
        
            </div>

            <!-- Botones u otro contenido adicional en el pie del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="validarFormularioAgregarDistrito();">Agregar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="vaciarModalAgregarDistrito();">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Script para validar formulario -->
<script src="../Action/validarModalAgregarDistrito.js"></script>