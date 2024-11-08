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

