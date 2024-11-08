/*
    Script created by: Benjamin
    date: 2024/10/30
*/

/*
    Validamos que solo sea haya introducido un campo (usuario o evento) en la busqueda de pagos pendientes
*/
function validarBusquedaPagoParcial() {

    // Obtenemos los valores de usuario y evento
    const buscarUsuario = document.getElementById('buscar_por_usuario').value.trim();
    const buscarEvento = document.getElementById('buscar_por_evento').value.trim();

    // Si se escribieron los dos campos
    if (buscarUsuario && buscarEvento) {
        Swal.fire({
            title: "Escribe solamente en un campo",
            text: "Por favor, realiza la búsqueda por usuario o por evento",
            icon: "warning"
        });
    } else if (buscarUsuario) {
        realizarBusquedaPagoParcial('usuario', buscarUsuario);
    } else if (buscarEvento) {
        realizarBusquedaPagoParcial('evento', buscarEvento);
    // No se escribio en ningun campo
    } else if (!buscarUsuario && !buscarEvento) {
        Swal.fire({
            title: "Ingresa un usuario o un evento",
            text: "Para realizar la búsqueda, escribe un nombre de usuario o un nombre de evento",
            icon: "warning"
        })
    }

}


/*
    Realizar la petición para traer los usuarios o el evento que coincida
*/
function realizarBusquedaPagoParcial(tipoBusqueda, valorBusqueda) {

    // Realizamos petición mediante fetch
    fetch('../Controllers/buscarPagoParcial_controller.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ tipo: tipoBusqueda, valor: valorBusqueda })
    })

    // Leemos la repsuesta como texto
    .then(response => response.text())

    // Convertiremosla respuesta a json
    .then(data => {
        // console.log('Respuesta del servidor (antes de JSON):', data);
        // Intentamos leer la respuesta como JSON
        try {
            let respuesta = JSON.parse(data);

            // Procesamos la respuesta del servidor
            if (respuesta.exito) {

                // Escribimos resultados en una tabla
                crearTablaPagosPendientes(respuesta.mensaje);

            } else {
                // No se encontraron registros con ese nombre
                Swal.fire({
                    icon: "warning",
                    title: "Oops...",
                    text: "Por favor verifique los datos ingresados: " + respuesta.mensaje
                });
            }

        } catch(e) {
            console.error('Error al procesar JSON:', e);
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Error al procesar la respuesta del servidor."
            });
        }
    })

    // Error al enviar los datos
    .catch(error => {
        console.error('Error al enviar los datos:', error);
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Error al enviar los datos." 
        });
    });
}


/*
    Función para crear de forma dinamica la tabla con los resultados de pagos pendientes de la busqueda
*/
function crearTablaPagosPendientes(pagos) {

    // Obtenemos el contenedor de la tabla
    const contenedorTabla = document.getElementById('contenedorTablaPagosPendientes');
    // Obtenemos la tabla
    const tabla = document.getElementById('tablaPagosPendientes');
    // Obtenemos el cuerpo de la tabla
    const cuerpoTabla = document.getElementById('resultadosPagosPendientes');

    // Limpiamos cuerpo de la tabla
    cuerpoTabla.innerHTML = '';

    // Mostramos tabla
    contenedorTabla.style.display = 'block';

    // Recorremos los resultados para ir agregando los datos
    pagos.forEach(elemento => {
        
        // Creamos una nueva fila
        const fila = document.createElement('tr');

        // Almacenamos valores clave
        fila.setAttribute('idBoleto', elemento.id_boleto)

        // Agregamos elementos a la fila
        fila.innerHTML = `
            <td>${elemento.nombre}</td>
            <td>${elemento.nombre_evento}</td>
            <td>${elemento.precio_total}</td>
            <td>${elemento.precio_pagado}</td>
            <td>${elemento.saldo_restante}</td>
            <td><button class="btn btn-success btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#modalRealizarPagoParcial"
                data-idBoleto = "${elemento.id_boleto}"
                data-nombre = "${elemento.nombre}"
                data-evento = "${elemento.nombre_evento}"
                data-costoTotal = "${elemento.precio_total}"
                data-totalPagado = "${elemento.precio_pagado}"
                data-saldoRestante = "${elemento.saldo_restante}"
                onclick="llenarModalPagoParcial(this);">
                Agregar Pago
            </button></td>
        `;

        // Agregamos fila a la tabla
        cuerpoTabla.appendChild(fila);
    });

}