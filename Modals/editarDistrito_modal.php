<!-- Modal para editar un Distrito -->
 
<div class="modal fade" id="modalEditarDistrito" tabindex="-1" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <!-- Contenido del modal -->
            <div class="modal-header">
                <h3 class="modal-title">Editar Distrito</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="vaciarModalEditarDistrito();"></button>
            </div>
      
            <!-- Cuerpo del modal -->
            <div class="modal-body">

                <!-- Formulario de datos para crear el Evento -->
                <form id="formularioEditarDistrito" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                    <!-- Input oculto que almacena el ID del distrito -->
                    <input type="hidden" id="id_distrito_editar" name="id_distrito_editar">

                    <!-- Input oculto para almacemar el nombre que se tenia -->
                    <input type="hidden" id="nombre_anterior_distrito" name="nombre_anterior_distrito">

                    <div class="row g-3">
                        <div class="col-md-12 mb-1">
                            <label for="nuevo_nombre_distrito" class="form-label fw-semibold">Nombre del Distrito: </label>
                            <input class="form-control bg-white border-1 border-secondary" type="text" id="nuevo_nombre_distrito" name="nuevo_nombre_distrito" required>
                            <div id="validarNuevoNombreDistrito" class=""></div>
                        </div>
                    </div>

                </form>
        
            </div>

            <!-- Botones u otro contenido adicional en el pie del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="validarFormularioEditarDistrito();">Editar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="vaciarModalEditarDistrito();">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Script para validar formulario -->
<script src="../Action/validarModalEditarDistrito.js"></script>