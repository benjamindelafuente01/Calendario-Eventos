/*
    Script created by: Benjamin
    date: 2024/10/04
*/

/*
    Función para traer los datos del evento a editar y escribirlos en en modal
*/
function datosEventoAEditar(id) {

    /****************************************************************************
    *    Petición fetch para traer los datos del evento que se quiere editar    *
    ****************************************************************************/
    fetch('../Controllers/traerDatosEventoEditar_controller.php', {
        // Valores de la peticion
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
    })

    // Convertimos los datos a un objeto JavaScript
    .then(response => response.json())

    //
    .then(data => {
        // Función para escribir los datos en el modal
        escribirDatosEventoEditar(data);
    })

    .catch(error => {
        // Mensaje de error
        Swal.fire({
            title: "Ha ocurrido un error",
            text: "Ocurrió un error al traer los datos del evento a editar",
            icon: "error",
            timer: 2000
        });
    });
    // console.log('Se seleccionado el evento con el ID: ' + id);
}


/*
    Función para escribir los datos del evento a editar en el modal
*/
function escribirDatosEventoEditar(evento) {

    // Obtenemos los elementos y les asignamos los valores anteriores
    document.getElementById('id_evento_editar').value = evento.id_evento;
    document.getElementById('nombre_evento_editar').value = evento.nombre;
    document.getElementById('costo_evento_editar').value = evento.costo_boleto;
    document.getElementById('fecha_inicio_evento_editar').value = evento.fecha_inicio;
    document.getElementById('fecha_fin_evento_editar').value = evento.fecha_fin;
    document.getElementById('hora_inicio_evento_editar').value = evento.hora_inicio.substring(0, 5);
    document.getElementById('color_evento_editar').value = evento.color

}


/*
    Función para limpiar el modal de crear nuevo Evento
*/
function vaciarModalEditarEvento() {

    // Arreglo con los campos a limpiar
    const campos = [
        'nombre_evento_editar', 'costo_evento_editar', 'fecha_inicio_evento_editar', 'fecha_fin_evento_editar',
        'hora_inicio_evento_editar', 'color_evento_editar'
    ];

    // Arreglo con los div a limpiar
    const validaciones = [
        'validarNombreEvento', 'validarCostoEvento', 'validarFechaInicio', 'validarFechaFin', 'validarHoraInicio', 'validarColorEvento'
    ];

    // Limpiamos los valores de los campos del formulario
    campos.forEach(idCampo => {

        // Obtenemos campo con el ID
        const campo = document.getElementById(idCampo);
        // Eliminamos todas las clases
        campo.classList.remove('is-invalid', 'is-valid');
    });

    // Limpiamos los divs
    validaciones.forEach(validacionId => {

        // Obtenemos div con el ID 
        const validacion = document.getElementById(validacionId);
        // Limpiamos texto
        validacion.innerHTML = '';
        // Eliminamos clase de validaicón negativa
        validacion.classList.remove('invalid-feedback');
    });

    // Limpiamos campos especificos
    document.getElementById('id_evento_editar').value = '';
    document.getElementById('fecha_inicio_evento_editar').max = '';
}


/*
    Función para cerrar el modal del evento
*/
function cerrarModalEditarEvento() {

    // Obtenemos el modal activo
    const modalElement = document.getElementById('modalEditarEvento');
    // Obtenemos la instancia de Bootstrap
    const modalInstance = bootstrap.Modal.getInstance(modalElement); 

    // Validamos que el modal esté instanciado
    if (modalInstance) {
        // Limpiamos modal
        vaciarModalEditarEvento();
        // Cerramos el modal de forma segura
        modalInstance.hide();
    } else {
        // console.log("El modal no está inicializado");
    }

}

/*
    Validación de los valores introducidos
*/
function validarCamposEventoEditar() {

    // Llamamos a la función para verificar
    let resultado = validarFormulario();

    // Verificamos el resultado de la validación y enviamos formulario
    if (resultado) {
        
        /*
            Envíamos mediante fetch
        */

        // Obtenemos el formulario
        const formulario = document.getElementById('formularioEditarEvento');
       
        // Creamos un objeto 'FormData' con los datos del formulario
        const datosFormulario = new FormData(formulario);

        // Hacer la solicitud fetch para enviar los datos al servidor
        fetch('../Controllers/editarEvento_controller.php', {
            method: 'POST',
            body: datosFormulario, // Datos del formulario
        })
        .then(response => response.text()) // Leer la respuesta como texto
        .then(data => {
            // console.log('Respuesta del servidor (antes de JSON):', data);

            try {
                // Intentar convertir la respuesta a JSON
                let jsonData = JSON.parse(data);
                
                // Procesar la respuesta del servidor
                if (jsonData.exito) {

                    // Mensaje de exito
                    Swal.fire({
                        title: "¡Evento guardado!",
                        text: "El evento se ha creado con éxito",
                        icon: "success",
                        timer: 2000
                    });

                    // Cerrar el modal (en esta función también se limpia)
                    cerrarModalEditarEvento();

                    // Recargamos los eventos
                    traerEventos();

                } else {
                    // Mensaje de error
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Algo salió mal al crear el evento" + (jsonData.mensaje || 'Error desconocido'),
                        timer: 2000
                    });

                }
            } catch (e) {
                // Mensaje de error
                Swal.fire({
                    title: "Oops...",
                    text: "Error al procesar la respuesta del servidor",
                    icon: "error",
                    timer: 2000
                });
            }
        })
        .catch(error => {
            // Mensaje de error
            Swal.fire({
                title: "Oops...",
                text: "Error al enviar los datos al servidor",
                icon: "error",
                timer: 2000
            });
        });

    }
}


/*
    Función para evaluar individualmente cada uno de los campos del formulario
*/
function validarFormulario() {

    // Bandera para verificar
    let formularioValido = true;

    /****************************************************
    *   Función auxiliar para agregar/eliminar clases   *
    ****************************************************/
    function validarCampo (campo, expresion, mensajeError, divValidacion) {

        // Evaluamos expresion
        if (!expresion) {
            campo.classList.add('is-invalid');
            campo.classList.remove('is-valid');
            divValidacion.innerHTML = mensajeError;
            divValidacion.classList.add('invalid-feedback');
            formularioValido = false;
        } else {
            campo.classList.add('is-valid');
            campo.classList.remove('is-invalid');
            divValidacion.innerHTML = '';
            divValidacion.classList.remove('invalid-feedback')
        }
    }

    // Validar nombre del evento
    const nombreEvento = document.getElementById('nombre_evento_editar');
    const nombreValido = document.getElementById('validarNombreEvento');
    validarCampo(
        nombreEvento,
        nombreEvento.value != '' && /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+$/.test(nombreEvento.value.trim()),
        'Por favor, ingresa un nombre válido (solo letras y números)',
        nombreValido
    );

    // Validar precio del evento
    const costoEvento = document.getElementById('costo_evento_editar');
    const costoValido = document.getElementById('validarCostoEvento');
    validarCampo(
        costoEvento,
        costoEvento.value != '' && costoEvento.value != '0' && /^\d+(\.\d{1,2})?$/.test(costoEvento.value.trim()),
        'Por favor, ingresa un precio válido (solo números y hasta con dos decimales',
        costoValido
    );

    // Validar la fecha de inicio
    const fechaInicio = document.getElementById('fecha_inicio_evento_editar');
    const fechaInicioValida = document.getElementById('validarFechaInicio');
    /* Convertir el valor de fecha de inicio a un objeto Date
    Desglosar manualmente el valor de fecha en año, mes y día
    Restamos 1 al mes, ya que en JavaScript los meses comienzan en 0 (enero es 0, diciembre es 11).*/ 
    const partesFechaInicio = fechaInicio.value.split('-');
    const fechaInicioValor = new Date(partesFechaInicio[0], partesFechaInicio[1] - 1, partesFechaInicio[2]);
    // Fecha de hoy (solo la parte de la fecha sin horas)
    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0); // Reiniciar horas para que solo compare la fecha
    validarCampo(
        fechaInicio,
        fechaInicio.value != '' && fechaInicioValor.getTime() >= hoy.getTime(),  // getTime(): Comparar los valores en milisegundos desde el 1 de enero de 1970
        'Por favor, seleccione una fecha de inicio válida',
        fechaInicioValida
    )

    /*
    TODO: Si la fecha es menor a la actual, eliminar los valores en fecha de inicio y de fin
    */

    // Validad la fecha de fin
    const fechaFin = document.getElementById('fecha_fin_evento_editar');
    const fechaFinValida = document.getElementById('validarFechaFin');
    validarCampo(
        fechaFin,
        fechaFin.value != '' && fechaFin.value >= fechaInicio.value,
        'La fecha de fin debe ser igual o mayor que la fecha de inicio',
        fechaFinValida
    );

    // Validar la hora incial del evento
    const horaInicio = document.getElementById('hora_inicio_evento_editar');
    const horaValida = document.getElementById('validarHoraInicio');
    validarCampo(
        horaInicio,
        horaInicio.value != '' && /^([01]\d|2[0-3]):[0-5]\d$/.test(horaInicio.value.trim()),
        'Por favor, ingrese una hora válida',
        horaValida
    );

    // Validar el color escogido
    const colorEvento = document.getElementById('color_evento_editar');
    const colorValido = document.getElementById('validarColorEvento');
    validarCampo(
        colorEvento,
        colorEvento.value.trim() != '',
        'Por favor, seleccione un color de la paleta de colores',
        colorValido
    );

    // Retornamos el valor
    return formularioValido;
}


/*
    Eventos para asegurar que la fecha de fin sea mayor a la fecha de inicio
*/

// Obtenemos los elementos de las fechas
const fecha_inicio = document.getElementById('fecha_inicio_evento_editar');
const fecha_fin = document.getElementById('fecha_fin_evento_editar');

// Evento para cuando cambie la fecha de inicio
fecha_inicio.addEventListener('change', function() {

    // Obtenemos la fecha de inicio seleccionada
    const fecha_inicio_seleccionada = fecha_inicio.value;

    // Verificamos el valor
    if (fecha_inicio_seleccionada) {
        // Establecemos como fecha minima de fin la fecha de inicio seleccionada
        fecha_fin.min = fecha_inicio_seleccionada;
    } else {
        // Limpiamos valor de fecha de fin
        fecha_fin.value = '';
    }
})

// Evento para cuando cambie la fecha de fin
fecha_fin.addEventListener('change', function() {

    // Obtenemos la fecha de fin seleccionada
    const fecha_fin_seleccionada = fecha_fin.value;

    // Verificamos el valor
    if (fecha_fin_seleccionada) {
        // Establecemos como fecha maxima de inicio la fecha de fin seleccionada
        fecha_inicio.max = fecha_fin_seleccionada;
    } else {
        // Si no hay fecha de fin seleccionada, eliminar la restricción en la fecha de inicio
        fecha_inicio.max = '';
    }
})
