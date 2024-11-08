/*
    Script created by: Benjamin
    date: 2024/11/06
*/


/*

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