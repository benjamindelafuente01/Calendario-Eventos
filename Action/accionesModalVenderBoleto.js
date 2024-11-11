/*
    Script created by: Benjamin
    date: 2024/10/23
*/


/*
    Escribir las opciones de distrito, iglesias y eventos en los respectivos select
*/
document.getElementById('modalVenderBoleto').addEventListener('shown.bs.modal', function () {

    // Traemos los datos
    cargarOpcionesSelectBoleto('iglesia', 'iglesia_boleto', '../Controllers/Boletos/traerIglesias_controller.php');
    cargarOpcionesSelectBoleto('distrito', 'distrito_boleto', '../Controllers/Boletos/traerDistritos_controller.php');
    cargarOpcionesSelectBoleto('evento', 'evento_boleto', '../Controllers/Boletos/traerEventos_controller.php');
})


/*
    Evento para cuando se seleccione una iglesia se eliga el distrito
*/
document.getElementById('iglesia_boleto').addEventListener('change', function () {
    actualizarDistritoPorIglesia();
});


/*
    Evento para cuando se seleccione un evento colocar el precio
*/
document.getElementById('evento_boleto').addEventListener('change', function () {
    actualizarPagoPorEvento();
});


/*
    Evento para cuando se seleccione un tipo de pago manipular el monto
*/
document.querySelectorAll('input[name="tipo_pago"').forEach((radio) => {
    radio.addEventListener('change', function () {
        ajustarMontoPorTipoPago();
    });
});


/*
    Función para escribir en los select las opciones existentes de distrito, iglesias y eventos
*/
function cargarOpcionesSelectBoleto(opcion, idSelect, ruta) {
    // Solicitamos datos
    fetch(ruta)

    // Convertimos a json la respuesta
    .then(response => response.json())

    .then(data => {

        if(data.exito) {

            // Obtenemos el select
            let select = document.getElementById(idSelect);
            // Limpiamos select
            select.innerHTML = '';

            // console.log(data.opciones);

            // Escribimos las respectivas opciones
            data.opciones.forEach(elemento => {
                // Creamos una nueva opcion
                let opcionSelect = document.createElement('option');
                    
                // Según el tipo de opción, almacenamos diferentes valores
                if (opcion === 'iglesia') {
                    // Almacenamos nombre de la iglesia
                    opcionSelect.value = elemento.nombre;
                    // Escribimos valor
                    opcionSelect.text = elemento.nombre
                    // Asociamos el id del distrito al que pertenece la iglesia como un data attribute
                    opcionSelect.dataset.distritoDeIglesia = elemento.id_distrito;
                } else if (opcion === 'distrito') {
                    // Almacenamos nombre del distrito
                    opcionSelect.value = elemento.nombre;
                    // Escribimos valor
                    opcionSelect.text = elemento.nombre
                    // Asociamos el id del distrito como un data attribute
                    opcionSelect.dataset.idDistrito = elemento.id_distrito;
                } else if (opcion === 'evento') {
                    // Almacenamos id
                    opcionSelect.value = elemento.id_evento;
                    // Escribimos valor
                    opcionSelect.text = elemento.nombre
                    // Asociamos el precio del evento como un data attribute
                    opcionSelect.dataset.precioEvento = elemento.costo_boleto;
                }

                // Agregamos opcion al select
                select.appendChild(opcionSelect);
            });

            // Si la opción es evento, actualizamos el placeholder del campo de monto
            if (opcion == 'evento') {
                actualizarPagoPorEvento();
            }

        } else {
            // Mensaje de error
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Algo salió mal: " + (data.mensaje || 'Error desconocido'),
                timer: 2000
            });
        }
    })

    .catch(error => {
        // console.error('Error al cargar las opciones:', error);
        // Mostramos mensaje de error al cargar opciones
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Error al cargar las opciones" + error.message
        });
    });
}


/*
    Function para actualizar el distrito cuando se eliga una iglesia
*/
function actualizarDistritoPorIglesia() {

    let iglesiaSelect = document.getElementById('iglesia_boleto');
    let distritoSelect = document.getElementById('distrito_boleto');

    // Del select de iglesias, accedemos a las opciones, de ahi a la que se haya elegido y accedemos
    // su dataset para conocer el id del distrito
    let distritoId = iglesiaSelect.options[iglesiaSelect.selectedIndex].dataset.distritoDeIglesia;

    // Seleccionamos automáticamente el distrito correspondiente
    if (distritoId) {

        // Recorremos todas las opciones del select de distritos
        for (let i = 0; i < distritoSelect.options.length; i++) {

            // Comparamos el id de todas las opciones del select de distrito y comparamos con el id distrito de la opcion elegida
            if (distritoSelect.options[i].dataset.idDistrito == distritoId) {

                // Seleccionar el distrito correspondiente
                distritoSelect.selectedIndex = i;

                break;
            }
        }
    }
}


/*
    Function para escribir el precio cuando se eliga un evento
*/
function actualizarPagoPorEvento() {

    // Obtenemos el select de la evento
    let eventoSelect = document.getElementById('evento_boleto');
    // Obtenemos el input del monto
    let montoInput = document.getElementById('monto_pagado_boleto');
    // Obtenemos el div con la validacion
    let montoValido = document.getElementById('validarMontoPagadoBoleto');
    // Obtenemos el precio del evento seleccionado
    let precioEvento = eventoSelect.options[eventoSelect.selectedIndex].dataset.precioEvento;
    // Obtetenemos los botones del tipo de pago
    let botonesTipoPago = document.getElementsByName('tipo_pago');
    // Obtenemos el input oculto del precio total del evento
    let precioTotalEvento = document.getElementById('precio_total_evento');

    // Limpiamos input del monto ingresado
    montoInput.value = '';
    // Establecemos precio como placeholder
    montoInput.placeholder = precioEvento;
    // En caso de estar desactivado, activamos
    montoInput.readOnly = false;
    // Eliminamos cualquier clase de error del input
    montoInput.classList.remove('is-invalid');
    // Eliminamos cualquier mensaje de error del div de validacion
    montoValido.innerHTML = '';
    // Eliminamos cualquier clase de error del div de validacion
    montoValido.classList.remove('invalid-feedback');
    // Guardamos en un input oculto el precio total del evento
    precioTotalEvento.value = precioEvento;


    // Limpiamos opciones de tipo de pago
    botonesTipoPago.forEach(function(radio) {
        radio.checked = false;
    })
}


/*
    Funcion para que dependiendo de la opcion del tipo de pago, se modifique el monto
*/
function ajustarMontoPorTipoPago() {

    // Obtenemos el radiobutton seleccionado
    let tipoPagoSeleccionado = document.querySelector('input[name="tipo_pago"]:checked').value;
    // Obtenemos el input del monto pagado
    let montoInput = document.getElementById('monto_pagado_boleto');
    // Obtenemos el div con la validacion
    let montoValido = document.getElementById('validarMontoPagadoBoleto');
    // Obtenemos el select del evento
    let eventoSelect = document.getElementById('evento_boleto');
    // Obtenemos el precio del evento seleccionado
    let precioEvento = parseInt(eventoSelect.options[eventoSelect.selectedIndex].dataset.precioEvento);

    // Verificamos la opcion seleccionada
    if (tipoPagoSeleccionado == 'pago_completo') {
        // Establecemos el precio del boleto
        montoInput.value = precioEvento;
        // Ponemos en solo lectura
        montoInput.readOnly = true;
        // Eliminamos clase de error del input
        montoInput.classList.remove('is-invalid');
        // Eliminamos mensaje de error del div de validacion
        montoValido.innerHTML = '';
        // Eliminamos clase de error del div de validacion
        montoValido.classList.remove('invalid-feedback');
        
    } else if (tipoPagoSeleccionado == 'pago_parcial') {
        // Limpiamos el input
        montoInput.value = '';
        // Desactivamos modo lectura
        montoInput.readOnly = false;
    }

}