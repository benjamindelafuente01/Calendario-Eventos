/*
    Script created by: Benjamin
    date: 2024/11/19
*/

/*
    Funcion para colocar el nombre y id del distrito que se desea editar
*/
function llenarModalEditarDistrito(botonEditarDistrito) {

    // Obtenemos los valores del boton
    const idDistrito = botonEditarDistrito.getAttribute('data-idDistrito');
    const nombreDistrito = botonEditarDistrito.getAttribute('data-nombreDistrito');

    // Obtenemos campos
    const campoId = document.getElementById('id_distrito_editar');
    const campoNombre = document.getElementById('nuevo_nombre_distrito');
    const campoNombreAnterior = document.getElementById('nombre_anterior_distrito');

    // Llenamos valores
    campoId.value = idDistrito;
    campoNombre.value = nombreDistrito;
    campoNombreAnterior.value = nombreDistrito;

}


/*
    Funcion para vaciar el modal de editar distrito
*/
function vaciarModalEditarDistrito() {

    // Campos con el valor y validacion
    const idDistrito = document.getElementById('id_distrito_editar')
    const nombreDistrito = document.getElementById('nuevo_nombre_distrito');
    const nombreAnterior = document.getElementById('nombre_anterior_distrito');
    const validacionDistrito = document.getElementById('validarNuevoNombreDistrito');
    
    // Eliminamos valores
    idDistrito.value = '';
    nombreDistrito.value = '';
    nombreAnterior.value = '';
    // Eliminamos todas las clases
    nombreDistrito.classList.remove('is-invalid');

    // Limpiamos texto
    validacionDistrito.innerHTML = '';
    // Eliminamos clase de validaicón negativa
    validacionDistrito.classList.remove('invalid-feedback');

}


/*
    Función para cerrar el modal de editar distrito
*/
function cerrarModalEditarDistrito() {

    // Obtenemos el modal activo
    const modalEditarDistrito = document.getElementById('modalEditarDistrito');
    // Obtenemos la instancia de Bootstrap
    const instanciaModal = bootstrap.Modal.getInstance(modalEditarDistrito); 

    // Validamos que el modal esté instanciado
    if (instanciaModal) {
        // Limpiamos modal
        vaciarModalEditarDistrito();
        // Cerramos el modal de forma segura
        instanciaModal.hide();
    } else {
        // console.log("El modal no está inicializado");
    }

}


/*
    Funcion para validar el campo del nuevo nombre del distrito
*/
function validarCamposEditarDistrito() {

    // Bandera para verificar
    let formularioValido = true;

    /****************************************************************
    *              Validar nuevo nombre del distrito                *
    ****************************************************************/
    let nuevoNombreDistrito = document.getElementById('nuevo_nombre_distrito');
    let nuevoNombreValido = document.getElementById('validarNuevoNombreDistrito');
    let nombreAnteriorDistrito = document.getElementById('nombre_anterior_distrito').value;

    
    // Verificamos que se haya cambiado el nombre
    if (nuevoNombreDistrito.value.trim() == nombreAnteriorDistrito){
        // Añadimos mensajes de errores
        nuevoNombreDistrito.classList.add('is-invalid');
        nuevoNombreValido.innerHTML = 'Por favor, ingresa un nombre diferente';
        nuevoNombreValido.classList.add('invalid-feedback');

        // Marcamos el formulario como inválido
        formularioValido = false;
    
        // Solo se aceptan letras y numeros
    } else if (nuevoNombreDistrito != '' && /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+$/.test(nuevoNombreDistrito.value.trim())) {
        // Si es correcta, eliminamos cualquier mensaje de error
        nuevoNombreDistrito.classList.remove('is-invalid');
        nuevoNombreValido.innerHTML = '';
        nuevoNombreValido.classList.remove('invalid-feedback');

    } else {
        // Añadimos mensajes de errores
        nuevoNombreDistrito.classList.add('is-invalid');
        nuevoNombreValido.innerHTML = 'Por favor, ingresa un nombre válido (solo letras y números)';
        nuevoNombreValido.classList.add('invalid-feedback');

        // Marcamos el formulario como inválido
        formularioValido = false;
    }

    return formularioValido;
}


/*
    Funcion que envia el formulario a base de datos si todos los campos son correctos
*/
function validarFormularioEditarDistrito() {

    // Llamamos a la función para verificar
    let resultado = validarCamposEditarDistrito();

    // Verificamos el resultado de la validación y enviamos formulario
    if (resultado) {
        
        /*
            Envíamos el formulario mediante fetch
        */

        // Obtenemos el formulario
        const formulario = document.getElementById('formularioEditarDistrito');

        // Creamos un objeto 'FormData' con los datos del formulario
        const datosFormulario = new FormData(formulario);

        // Hacer la solicitud fetch para enviar los datos al servidor
        fetch('../Controllers/editarDistrito_controller.php', {
            method: 'POST',
            body: datosFormulario
        })
        .then(response => response.text()) // Leer la respuesta como texto
        .then(data => {
            // console.log('Respuesta del servidor (antes de JSON):', data);

            try {
                // Intentar convertir la respuesta a JSON
                let respuestaJson = JSON.parse(data);
                 
                // Procesar la respuesta del servidor
                if (respuestaJson.exito) {
 
                    // Mensaje de exito
                    Swal.fire({
                        title: "¡Distrito actualizado!",
                        text: "El distrito se ha actualizado correctamente",
                        icon: "success",
                        timer: 2000
                    });
 
                    // Cerramos y limpiamos modal
                    cerrarModalEditarDistrito();
                    // Recargamos los distritos
                    traerDistritos();
 
                } else {
                    // Mensaje de error
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Algo salió mal al actualizar el distrito: " + respuestaJson.mensaje,
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