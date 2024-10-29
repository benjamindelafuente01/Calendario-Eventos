/*
    Script created by: Benjamin
    date: 2024/10/24
*/


/*
    Funcion para vaciar el modal de vender boleto
*/
function vaciarModalVenderBoleto() {

    // Arreglo con los inputs
    const campos = ['nombre_boleto', 'monto_pagado_boleto'];

    // Arreglo con los divs
    const validaciones = ['validarNombreBoleto', 'validarMontoPagadoBoleto'];
    
    // Limpiamos inputs
    campos.forEach(idCampo => {
        // Obtenemos campo con el ID
        const campo = document.getElementById(idCampo);
        // Eliminamos valores
        campo.value = '';
        // Eliminamos todas las clases
        campo.classList.remove('is-invalid');
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
    Función para cerrar el modal de vender boleto
*/
function cerrarModalVenderBoleto() {

    // Obtenemos el modal activo
    const modalElement = document.getElementById('modalVenderBoleto');
    // Obtenemos la instancia de Bootstrap
    const modalInstance = bootstrap.Modal.getInstance(modalElement); 

    // Validamos que el modal esté instanciado
    if (modalInstance) {
        // Limpiamos modal
        vaciarModalVenderBoleto();
        // Cerramos el modal de forma segura
        modalInstance.hide();
    } else {
        // console.log("El modal no está inicializado");
    }

}


/*
    Funcion para evaluar individualmente los valores del formulario (nombre, tipo de pago y monto)
*/
function validarCamposVenderBoleto() {
    
    // Bandera para verificar
    let formularioValido = true;

    /****************************************************************
    *       Validar nombre de a quien se le vende el boleto         *
    ****************************************************************/
    let nombreBoleto = document.getElementById('nombre_boleto');
    let nombreValido = document.getElementById('validarNombreBoleto');

    // Solo se aceptan letras y numeros
    if (nombreBoleto != '' && /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+$/.test(nombreBoleto.value.trim())) {
        // Si es correcta, eliminamos cualquier mensaje de error
        nombreBoleto.classList.remove('is-invalid');
        nombreValido.innerHTML = '';
        nombreValido.classList.remove('invalid-feedback');
    
    } else {
        // Añadimos mensajes de errores
        nombreBoleto.classList.add('is-invalid');
        nombreValido.innerHTML = 'Por favor, ingresa un nombre válido (solo letras y números)';
        nombreValido.classList.add('invalid-feedback');

        // Marcamos el formulario como inválido
        formularioValido = false;
    }
        

    /****************************************************************
    *     Validar que se haya seleccionado un tipo de pago          *
    ****************************************************************/

    // Obtenemos el radio button seleccionado
    let pagoSeleccionado = document.querySelector('input[name="tipo_pago"]:checked');
    // Obtenemos el div para mostrar la validación
    let tipoPagoValido = document.getElementById('validarTipoPagoBoleto');

    /*
        Si no se selecciono ninguna opcion
    */
    if (pagoSeleccionado == null) {
        
        // Si no se seleccionó ningún radio button, mostramos el mensaje de error
        tipoPagoValido.innerHTML = 'Por favor, selecciona un tipo de pago.';
        tipoPagoValido.classList.add('invalid-feedback');
        tipoPagoValido.style.display = 'block';
        
        // Marcamos el formulario como inválido
        formularioValido = false;
 
    } else {

        /*
            Si se selecciono alguna opcion, verificamos el pago parcial
        */
        // Limpiamos cualquier mensaje de error anterior
        tipoPagoValido.innerHTML = '';
        tipoPagoValido.classList.remove('invalid-feedback');
        tipoPagoValido.style.display = 'none';
    

        /****************************************************************
        *  Validar si es un pago parcial no rebase el costo del boleto  *
        ****************************************************************/
        // Obtenemos el input de monto agregado
        let montoBoleto = document.getElementById('monto_pagado_boleto');
        // Obtenemos el div con la validacion
        let montoValido = document.getElementById('validarMontoPagadoBoleto');
        // Obtenemos el monto que se ingreso en el input
        let montoPagoParcial = document.getElementById('monto_pagado_boleto').value;
        // Obtenemos el radiobutton seleccionado
        let tipoPagoSeleccionado = document.querySelector('input[name="tipo_pago"]:checked').value;
        // Obtenemos el select del evento
        let eventoSelect = document.getElementById('evento_boleto');
        // Obtenemos el precio del evento seleccionado
        let precioEvento = parseInt(eventoSelect.options[eventoSelect.selectedIndex].dataset.precioEvento);

        // Si se seleccion un pago parcial
        if (tipoPagoSeleccionado == 'pago_parcial') {

            // Verificamos que no sea cero o una cadena vacía
            if (montoPagoParcial == 0 || montoPagoParcial < 0) {
                montoBoleto.classList.add('is-invalid');
                montoValido.innerHTML = 'Por favor, ingresa un monto mayor que cero.';
                montoValido.classList.add('invalid-feedback')

                formularioValido = false;
                
            // Verificamos que el monto ingresado sea menor al costo del boleto del evento
            } else if (precioEvento <= montoPagoParcial) {
                montoBoleto.classList.add('is-invalid');
                montoValido.innerHTML = 'El pago parcial debe ser menor al costo del boleto.';
                montoValido.classList.add('invalid-feedback')

                formularioValido = false;
            
            } else {
                // Si es correcto, eliminamos cualquier mensaje de error
                montoBoleto.classList.remove('is-invalid');
                montoValido.innerHTML = '';
                montoValido.classList.remove('invalid-feedback');
            }

        }
    }

    // Retornamos el valor
    return formularioValido;
}


/*
    Funcion que envia el formulario a base de datos si todos los campos son correctos
*/
function validarFormularioVenderBoleto() {

    // Llamamos a la función para verificar
    let resultado = validarCamposVenderBoleto();

    // Verificamos el resultado de la validación y enviamos formulario
    if (resultado) {
        
        /*
            Envíamos el formulario mediante fetch
        */

        // Obtenemos el formulario
        const formulario = document.getElementById('formularioVenderBoleto');

        // Creamos un objeto 'FormData' con los datos del formulario
        const datosFormulario = new FormData(formulario);

        // Hacer la solicitud fetch para enviar los datos al servidor
        fetch('../Controllers/registrarVentaBoleto_controller.php', {
            method: 'POST',
            body: datosFormulario
        })
        .then(response => response.text()) // Leer la respuesta como texto
        .then(data => {
            console.log('Respuesta del servidor (antes de JSON):', data);
            try {
                // Intentar convertir la respuesta a JSON
                let jsonData = JSON.parse(data);
                 
                // Procesar la respuesta del servidor
                if (jsonData.exito) {
 
                    // Mensaje de exito
                    Swal.fire({
                        title: "¡Boleto vendido!",
                        text: "El boleto se ha vendido correctamente y el pago se ha registrado",
                        icon: "success",
                        timer: 2000
                    });
 
                    // Cerrar el modal (en esta función también se limpia)
                    cerrarModalVenderBoleto();
                    // Recargamos los eventos
                    traerEventos();
 
                } else {
                    // Mensaje de error
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Algo salió mal al resgistrar el boleto: " + jsonData.mensaje,
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
            console.error('Error al enviar los datos:', error);
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Error al enviar los datos." 
            });
        });
    }
}