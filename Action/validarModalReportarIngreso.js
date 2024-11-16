/*
    Script created by: Benjamin
    date: 2024/10/13
*/


/*
    Funcion para escribir el id del evento en el modal de reportar ingresi
*/
function escribirIdEventoEnIngreso(id) {
    // Obtenemos el input oculto del modal de ingresos para escribir el id del evento
    document.getElementById('id_evento_ingreso').value = id;
}


/*
    Funcion para vaciar el modal de generar gasto de evento
*/
function vaciarModalReportarIngreso() {

    // Arreglo con los inputs
    const campos = ['id_evento_ingreso', 'monto_ingreso'];

    // Arreglo con los divs
    const validaciones = ['validarMontoIngreso'];
    
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
function cerrarModalIngresoEvento() {

    // Obtenemos el modal activo
    const modalElement = document.getElementById('modalReportarIngreso');
    // Obtenemos la instancia de Bootstrap
    const modalInstance = bootstrap.Modal.getInstance(modalElement); 

    // Validamos que el modal esté instanciado
    if (modalInstance) {
        // Limpiamos modal
        vaciarModalReportarIngreso();
        // Cerramos el modal de forma segura
        modalInstance.hide();
    } else {
        // console.log("El modal no está inicializado");
    }

}


/*
    Funcion para validar el monto por el ingreso
*/
function validarCamposReportarIngreso() {
    
    // Bandera para verificar
    let formularioValido = true;

    // Obtenemos los campos de ingreso
    const campoIngreso = document.getElementById('monto_ingreso');
    const validacionIngreso = document.getElementById('validarMontoIngreso');

    // Validamos campo de ingresos
    if (campoIngreso.value == '' && !/^\d+(\.\d{1,2})?$/.test(campoIngreso.value.trim())) {
        campoIngreso.classList.add('is-invalid');
        validacionIngreso.classList.add('invalid-feedback');
        validacionIngreso.innerHTML = 'Por favor, ingresa un monto valido';

        formularioValido = false;
    
    } else {
        campoIngreso.classList.remove('is-invalid');
        validacionIngreso.classList.remove('invalid-feedback');
        validacionIngreso.innerHTML = '';
    }

    return formularioValido;
}


/*
    Funcion que se llama cuando se envia el formulario para validar el campo de ingresos
*/
function validarFormularioIngreso()  {

    // Llamamos a la funcion para validar
    let resultado = validarCamposReportarIngreso();

    if (resultado) {

        /*
            Enviamos formulario mediante fetch
        */

        // Obtenemos el formulario
        const formularioIngresos = document.getElementById('formularioIngresoEvento');

        // Creamos un objeto 'FormData' con los datos del formulario
        const datosFormulario = new FormData(formularioIngresos);

        // Hacemos la solicitud fetch para enviar los datos al servidor
        fetch('../Controllers/reportarIngreso_controller.php', {
            method: 'POST',
            body: datosFormulario
        })
        .then(response => response.text())  // Leer la repsuesta como texto
        .then(data => {
            // console.log('Respuesta del servidor (antes de JSON):', data);

            try {
                // Intentamos convertir la repsuesta a json
                let respuestaJson = JSON.parse(data);

                // Verificamos respuesta
                if (respuestaJson.exito) {

                    // Mensaje de exito
                    Swal.fire({
                        title: "¡Ingreso añadido!",
                        text: "El ingreso se ha registrado correctamente",
                        icon: "success",
                        timer: 2000
                    });

                    // Cerramos y limpiamos modal
                    cerrarModalIngresoEvento();
                    // Recargamos los eventos
                    traerEventos();

                } else {
                    // Mensaje de error
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Algo salió mal al registrar el ingreso: " + respuestaJson.mensaje,
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