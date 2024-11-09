/*
    Script created by: Benjamin
    date: 2024/11/06
*/


/*
    Funcion para acceder a los valores del boton que se presiono y escribir los datos en el modal de pago parcial
*/
function llenarModalPagoParcial(boton) {

    // Obtenemos valores del boton
    const id_boleto = boton.getAttribute('data-idBoleto');
    const nombre_boleto = boton.getAttribute('data-nombre');
    const nombre_evento = boton.getAttribute('data-evento');
    const costo_total = boton.getAttribute('data-costoTotal');
    const total_pagado = boton.getAttribute('data-totalPagado');
    const saldo_restante = boton.getAttribute('data-saldoRestante');

    // Obtenemos elementos del modal
    const campoIdBoleto = document.getElementById('id_boleto');
    const campoNombreBoleto = document.getElementById('nombre_pago_parcial');
    const campoNombreEvento = document.getElementById('nombre_evento_pago_parcial');
    const campoCostoTotal = document.getElementById('costo_evento_pago_parcial');
    const campoTotalPagado = document.getElementById('total_pagado_pago_parcial');
    const campoSaldoRestante = document.getElementById('saldo_restante_pago_parcial');

    // Agregamos los valores
    campoIdBoleto.value = id_boleto;
    campoNombreBoleto.value = nombre_boleto;
    campoNombreEvento.value = nombre_evento;
    campoCostoTotal.value = costo_total;
    campoTotalPagado.value = total_pagado;
    campoSaldoRestante.value = saldo_restante;

}


/*
    Funcion para vaciar el modal de pago parcial
*/
function vaciarModalPagoParcial() {

    // Arreglo con los inputs
    const campos = ['id_boleto', 'nombre_pago_parcial', 'nombre_evento_pago_parcial', 'costo_evento_pago_parcial',
        'total_pagado_pago_parcial', 'saldo_restante_pago_parcial', 'monto_pago_parcial'
    ];

    // Con un ciclo recorremos el arreglo y limpiamos campos del modal
    campos.forEach(idCampo => {
        // Accedemos al campo mediante el ID
        const campo = document.getElementById(idCampo);
        // Limpiamos valor
        campo.value = '';
        // Eliminamos clase de error (para el campo de monto abonado)
        campo.classList.remove('is-invalid');
    });

    // Accedemos al div de validacion de monto abonado y limpiamos
    const validacionMontoPago = document.getElementById('validarMontoPago');
    validacionMontoPago.innerHTML = '';
    validacionMontoPago.classList.remove('invalid-feedback');
}


/*
    Funcion para cerrar el modal y vaciar campos
*/
function cerrarModalPagoParcial() {

    // Obtenemos el modal de pago parcial
    const modalPagoParcial = document.getElementById('modalRealizarPagoParcial');
    // Obtenemos la instancia de bootstrap del modal
    const instanciaModal = bootstrap.Modal.getInstance(modalPagoParcial);
    
    // Validamos que el modal este instanciado
    if (instanciaModal) {
        // Limpiamos modal
        vaciarModalPagoParcial();
        // Cerramos de forma segura
        instanciaModal.hide();
    } else {
        // console.log("El modal no está inicializado");
    }
}


/*
    Funcion para validar el monto abonado en el pago parcial
*/
function limpiarTablaPagoParcial() {

    // Limpiamos inputs del buscador
    document.getElementById('buscar_por_usuario').value = '';
    document.getElementById('buscar_por_evento').value = '';

    // Limpiamos cuerpo de la tabla
    document.getElementById('resultadosPagosPendientes').innerHTML = '';

    // Ocultamos encabezado de la tabla
    document.getElementById('contenedorTablaPagosPendientes').style.display = 'none';
}

/*
    Funcion para validar el monto abonado en el pago parcial
*/
function validarCamposPagoParcial() {
    
    // Bandera para verificar
    let formularioValido = true;

    // Obtenemos los valores de saldo restante, monto abonado y div de validacion
    const saldoRestante = parseFloat (document.getElementById('saldo_restante_pago_parcial').value);
    const montoAbonado = document.getElementById('monto_pago_parcial');
    const validacionMontoAbonado = document.getElementById('validarMontoPago');

    // Verificamos que el monto abonado sea un numero entero con 2 decimales
    if  (!/^\d+(\.\d{1,2})?$/.test(montoAbonado.value.trim())) {

        // Clase de error en el input
        montoAbonado.classList.add('is-invalid');
        // Agregamos mensaje de error en el div de validacion
        validacionMontoAbonado.innerHTML = 'Por favor, introduce una cantidad válida';
        validacionMontoAbonado.classList.add('invalid-feedback')

        formularioValido = false;

    // Verificamos que sea mayor que cero y menor qye saldo restante y no sea una cadena cero
    } else if (parseFloat(montoAbonado.value.trim()) <= 0 || parseFloat(montoAbonado.value.trim()) > saldoRestante) {

        // Clase de error en el input
        montoAbonado.classList.add('is-invalid');
        // Agregamos mensaje de error en el div de validacion
        validacionMontoAbonado.innerHTML = 'Por favor, introduce una cantidad mayor que 0 y menor que saldo restante';
        validacionMontoAbonado.classList.add('invalid-feedback')

        formularioValido = false;
    }

    return formularioValido;
}


/*
    Funcion que se llama cuando se quiere enviar el formulario de pago parcial
*/
function validarFormularioPagoParcial() {

    // Verificamos resultado
    let formulario = validarCamposPagoParcial();

    if (formulario) {

        // Obtenemos el formulario
        const formularioPagoParcial = document.getElementById('formularioPagoParcial');
       
        // Creamos un objeto 'FormData' con los datos del formulario
        const datosFormulario = new FormData(formularioPagoParcial);

        // Enviamos peticion fetch para guardar pago
        fetch ('../Controllers/agregarPagoParcial_controller.php', {
            method: 'POST',
            body: datosFormulario
        })

        .then (response => response.text())   // Leer la respuesta como texto
        .then (data => {
            // console.log('Respuesta del servidor (antes de JSON):', data);

            try {
                // Intentamos convertir respuesta a json
                let respuestaJson = JSON.parse(data);

                // Verificamos la respuesta del servidor
                if (respuestaJson.exito) {
                    
                    // Mensaje de exito
                    Swal.fire({
                        title: "Pago añadido!",
                        text: "El pago se ha agregado correctamente",
                        icon: "success",
                        timer: 2000
                    });

                    // Limpiamos buscador y tabla
                    limpiarTablaPagoParcial();

                    // Cerramos modal
                    cerrarModalPagoParcial();

                } else {
                    // Mensaje de error
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Algo salió mal al guardar el pago: " + respuestaJson.mensaje,
                    });
                }

            } catch(e) {
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