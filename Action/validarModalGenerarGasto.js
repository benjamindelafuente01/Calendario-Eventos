/*
    Script created by: Benjamin
    date: 2024/10/17
*/


/*
    Funcion para que en el formulario del gasto se escriba el ID del evento al que se le quiere agregar
    el gasto
*/
function escribirIdEventoEnGasto(id) {
    // Obtenemos el input oculto para
    document.getElementById('id_evento_gasto').value = id;
}

/*
    Funcion para vaciar el modal de generar gasto de evento
*/
function vaciarModalGenerarGasto() {

    // Arreglo con los inputs
    const campos = ['id_evento_gasto', 'nombre_gasto', 'monto_gasto', 'fecha_gasto'];

    // Arreglo con los divs
    const validaciones = ['validarConceptoGasto', 'validarMontoGasto', 'validarFechaGasto'];
    
    // Limpiamos inputs
    campos.forEach(idCampo => {
        // Obtenemos campo con el ID
        const campo = document.getElementById(idCampo);
        // Eliminamos valores
        campo.value = '';
        // Eliminamos todas las clases
        campo.classList.remove('is-invalid', 'is-valid');
    });
    
    // Limpiamos divs de validaciones
    validaciones.forEach(validacionID => {
        // Obtenemos campo con el ID
        const validacion = document.getElementById(validacionID);
        // Limpiamos texto
        validacion.innerHTML = '';
        // Eliminamos clase de validaicón negativa
        validacion.classList.remove('invalid-feedback');
    });

}

/*
    Función para cerrar el modal de agregar gasto a evento
*/
function cerrarModalGastoEvento() {

    // Obtenemos el modal activo
    const modalElement = document.getElementById('modalGenerarGasto');
    // Obtenemos la instancia de Bootstrap
    const modalInstance = bootstrap.Modal.getInstance(modalElement); 

    // Validamos que el modal esté instanciado
    if (modalInstance) {
        // Limpiamos modal
        vaciarModalGenerarGasto();
        // Cerramos el modal de forma segura
        modalInstance.hide();
    } else {
        // console.log("El modal no está inicializado");
    }

}

function validarCamposGenerarGasto() {
    
    // Bandera para verificar
    let formularioValido = true;

    /****************************************************
    *   Función auxiliar para agregar/eliminar clases   *
    ****************************************************/
    function validarCampo (campo, expresion, mensajeError, divValidacion) {

        // Evaluamos expresion
        if (!expresion) {
            campo.classList.add('is-invalid');
            campo.classList.remove('is-valid');
            divValidacion.innerHTML = mensajeError;
            divValidacion.classList.add('invalid-feedback');
            formularioValido = false;
        } else {
            campo.classList.add('is-valid');
            campo.classList.remove('is-invalid');
            divValidacion.innerHTML = '';
            divValidacion.classList.remove('invalid-feedback')
        }
    }

    // Validar nombre del gasto
    const nombreGasto = document.getElementById('nombre_gasto');
    const nombreValido = document.getElementById('validarConceptoGasto');
    validarCampo(
        nombreGasto,
        nombreGasto.value != '' && /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+$/.test(nombreGasto.value.trim()),
        'Por favor, ingresa un concepto válido (solo letras y números)',
        nombreValido
    );

    // Validar costo del gasto
    const costoGasto = document.getElementById('monto_gasto');
    const costoValido = document.getElementById('validarMontoGasto');
    validarCampo(
        costoGasto,
        costoGasto.value != '' && costoGasto.value != '0' && /^\d+(\.\d{1,2})?$/.test(costoGasto.value.trim()),
        'Por favor, ingresa un costo válido (solo números y hasta con dos decimales',
        costoValido
    );

    // Validar la fecha
    const fechaGasto = document.getElementById('fecha_gasto');
    const fechaValida = document.getElementById('validarFechaGasto');
    validarCampo(
        fechaGasto,
        fechaGasto.value.trim() != '',
        'Por favor, seleccione una fecha',
        fechaValida
    );

    // Retornamos el valor
    return formularioValido;
}


function validarFormularioGasto() {

    // Llamamos a la función para verificar
    let resultado = validarCamposGenerarGasto();

    // Verificamos el resultado de la validación y enviamos formulario
    if (resultado) {
        
        /*
            Envíamos el formulario mediante fetch
        */

        // Obtenemos el formulario
        const formulario = document.getElementById('formularioGastoEvento');
       
        // Creamos un objeto 'FormData' con los datos del formulario
        const datosFormulario = new FormData(formulario);

        // Hacer la solicitud fetch para enviar los datos al servidor
        fetch('../Controllers/agregarGastoEvento_controller.php', {
            method: 'POST',
            body: datosFormulario
        })
        .then(response => response.text()) // Leer la respuesta como texto
        .then(data => {
            // console.log('Respuesta del servidor (antes de JSON):', data);
            try {
                // Intentar convertir la respuesta a JSON
                let jsonData = JSON.parse(data);
                
                // Procesar la respuesta del servidor
                if (jsonData.exito) {

                    // Mensaje de exito
                    Swal.fire({
                        title: "¡Gasto añadido!",
                        text: "El gasto se ha creado correctamente",
                        icon: "success",
                        timer: 2000
                    });

                    // Cerrar el modal (en esta función también se limpia)
                    cerrarModalGastoEvento();
                    // Recargamos los eventos
                    traerEventos();

                } else {
                    // Mensaje de error
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Algo salió mal al guardar el gasto: " + jsonData.mensaje,
                        timer: 2000
                    });
                }

            } catch (e) {
                // console.error('Error al procesar JSON:', e);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Error al procesar la respuesta del servidor." 
                });
            }
        })
        .catch(error => {
            // console.error('Error al enviar los datos:', error);
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Error al enviar los datos." 
            });
        });
    
    }
}