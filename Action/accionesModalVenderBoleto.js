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

            // Guardamos los datos de cada select en un dataset
            select.dataset[`${opcion}Data`] = JSON.stringify(data.opciones);

            // Escribimos las respectivas opciones
            data.opciones.forEach(elemento => {
                // Creamos una nueva opcion
                let opcionSelect = document.createElement('option');
                    
                // Accedemos al valor del id según el tipo de opción
                let idElemento;
                if (opcion === 'iglesia') {
                    idElemento = elemento.id_iglesia;
                } else if (opcion === 'distrito') {
                    idElemento = elemento.id_distrito;
                } else if (opcion === 'evento') {
                    idElemento = elemento.id_evento;
                }

                // Almacenamos id
                opcionSelect.value = idElemento;
                // Escribimos valor
                opcionSelect.text = elemento.nombre

                // Si la opcion es iglesia guardamos el id del distrito
                if (opcion == 'iglesia') {
                    // Asociamos el id del distrito como un data attribute
                    opcionSelect.dataset.distritoId = elemento.id_distrito;
                }

                // TODO: Si la opción es evento, guardar el costo de cada boleto

                // Agregamos opcion al select
                select.appendChild(opcionSelect);
            });

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
        // Mostramos error en la consola para depuración
        console.error('Error al cargar las opciones:', error);
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

    // Del select de iglseias, accedemos a las opciones, de ahi a la que se haya elegido y accedemos
    // su dataset para conocer el id del distrito
    let distritoId = iglesiaSelect.options[iglesiaSelect.selectedIndex].dataset.distritoId;

    // Seleccionamos automáticamente el distrito correspondiente
    if (distritoId) {

        // Recorremos todas las opciones del select de distritos
        for (let i = 0; i < distritoSelect.options.length; i++) {

            // Comparamos el id de todas las opciones del select de distrito y comparamos con el id distrito de la opcion elegida
            if (distritoSelect.options[i].value === distritoId.toString()) {

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
function actualizarDistritoPorIglesia() {


}