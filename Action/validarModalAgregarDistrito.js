/*
    Script created by: Benjamin
    date: 2024/11/15
*/


/*
    Funcion para vaciar el modal de agregar distrito
*/
function vaciarModalAgregarDistrito() {

    // Campos con el valor y validacion
    const nombreDistrito = document.getElementById('nombre_distrito');
    const validacionDistrito = document.getElementById('validarNombreDistrito');
    
    // Eliminamos valores
    nombreDistrito.value = '';
    // Eliminamos todas las clases
    nombreDistrito.classList.remove('is-invalid');

    // Limpiamos texto
    validacionDistrito.innerHTML = '';
    // Eliminamos clase de validaicón negativa
    validacionDistrito.classList.remove('invalid-feedback');

}


/*
    Función para cerrar el modal de agregar distrito
*/
function cerrarModalAgregarDistrito() {

    // Obtenemos el modal activo
    const modalElement = document.getElementById('modalAgregarDistrito');
    // Obtenemos la instancia de Bootstrap
    const modalInstance = bootstrap.Modal.getInstance(modalElement); 

    // Validamos que el modal esté instanciado
    if (modalInstance) {
        // Limpiamos modal
        vaciarModalAgregarDistrito();
        // Cerramos el modal de forma segura
        modalInstance.hide();
    } else {
        // console.log("El modal no está inicializado");
    }

}


/*
    Funcion para validar el campo nombre del distrito
*/
function validarCamposAgregarDistrito() {

    // Bandera para verificar
    let formularioValido = true;

    /****************************************************************
    *                Validar nombre del distrito                    *
    ****************************************************************/
    let nombreDistrito = document.getElementById('nombre_distrito');
    let nombreValido = document.getElementById('validarNombreDistrito');

    // Solo se aceptan letras y numeros
    if (nombreDistrito != '' && /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+$/.test(nombreDistrito.value.trim())) {
        // Si es correcta, eliminamos cualquier mensaje de error
        nombreDistrito.classList.remove('is-invalid');
        nombreValido.innerHTML = '';
        nombreValido.classList.remove('invalid-feedback');
    
    } else {
        // Añadimos mensajes de errores
        nombreDistrito.classList.add('is-invalid');
        nombreValido.innerHTML = 'Por favor, ingresa un nombre válido (solo letras y números)';
        nombreValido.classList.add('invalid-feedback');

        // Marcamos el formulario como inválido
        formularioValido = false;
    }

    return formularioValido;
}


/*
    Funcion que envia el formulario a base de datos si todos los campos son correctos
*/
function validarFormularioAgregarDistrito() {

    // Llamamos a la función para verificar
    let resultado = validarCamposAgregarDistrito();

    // Verificamos el resultado de la validación y enviamos formulario
    if (resultado) {
        
        /*
            Envíamos el formulario mediante fetch
        */

        // Obtenemos el formulario
        const formulario = document.getElementById('formularioAgregarDistrito');

        // Creamos un objeto 'FormData' con los datos del formulario
        const datosFormulario = new FormData(formulario);

        // Hacer la solicitud fetch para enviar los datos al servidor
        fetch('../Controllers/agregarDistrito_controller.php', {
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
                        title: "¡Distrito agregado!",
                        text: "El distrito se ha agregado correctamente",
                        icon: "success",
                        timer: 2000
                    });
 
                    // Cerramos y limpiamos modal
                    cerrarModalAgregarDistrito();
                    // Recargamos los distritos
                    traerDistritos();
 
                } else {
                    // Mensaje de error
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Algo salió mal al agregar el distrito: " + respuestaJson.mensaje,
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