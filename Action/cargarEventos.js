/*
    Script created by: Benjamin
    date: 2024/09/20
*/

document.addEventListener('DOMContentLoaded', function() {

    // Llamamos a función que consulta los eventos a la base de datos
    traerEventos();
})


/*
    Función para hacer una petición a la base de datos de los eventos
*/
function traerEventos() {

    /*********************************************
    *   Petición fetch para traer los eventos    *
    *********************************************/
   fetch('../Controllers/eventos_controller.php')
        // Puedes agregar opciones de configuracion
        // method: 'POST', //  Define el tipo de método HTTP (GET, POST, etc.). Si no se especifica, se asume GET.
        // headers: {
        //     'Content-Type': 'application/json', // Indica el tipo de datos enviados, Configura los encabezados HTTP. 
        //                                         // Por ejemplo, Content-Type para especificar el tipo de contenido.
        // },
        // body: JSON.stringify({ nombre: 'John', edad: 30 })  // Contiene los datos que se enviarán al servidor (solo para métodos como POST, PUT).
        //                                                     // Usualmente, los datos se envían como cadenas en formato JSON, FormData, o URLSearchParams

   .then(response => response.json())

   .then(data => {
        // console.log(data);
        mostrarEventos(data);
   })

   .catch(error => {
        // Mensaje de error
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Ocurrió un error al traer los eventos",
            timer: 2000
        });
   });

}


/*
    Función para motsrar todos los eventos
*/
function mostrarEventos(data) {
    
    // Obtenemos el contenedor de los eventos
    const contenedorEventos = document.getElementById('contenedor-eventos');

    // Limpiamos contenedor (para dibujar de nuevo en caso de que se edite el color)
    contenedorEventos.innerHTML = "";

    // Verificamos si existe eventos
    if (data.length == 0) {
        contenedorEventos.innerHTML = "No se han registrado eventos. Agregue uno para visualizarlos";
        contenedorEventos.classList.add('mensaje-eventos-vacio', 'mt-4');
    }

    // Obtenemos los datos de cada evento
    data.forEach(evento => {
        
        // ID del evento
        let idEvento = evento.id_evento.toString();
        // Nombre del evento
        let nombreEvento = evento.nombre.toString();
        // Fecha de inicio
        let fechaInicio = evento.fecha_inicio;
        // Color del evento
        let colorEvento = evento.color.toString();
        // Boletos vendidos
        let boletosVendidos = parseInt (evento.total_boletos_vendidos);
        // Ingresos
        let ingresosEvento = parseFloat (evento.total_boletos_pagados) + parseFloat(evento.total_ingresos);
        // Gastos
        let gastosEvento = parseFloat (evento.total_gastos);
        // Calculamos el dinero recaudado
        let totalEvento =  ingresosEvento - gastosEvento;

        // Llamamos a la función para dibujar eventos de forma individual
        let contenedorEvento = dibujarEvento(idEvento, nombreEvento, fechaInicio, colorEvento, boletosVendidos, ingresosEvento, gastosEvento, totalEvento);

        // Agregamos evento al contenedor
        contenedorEventos.appendChild(contenedorEvento);
    });

}


/*
    Función para dibujar los eventos de forma individual
*/
function dibujarEvento(id, nombre, fechaInicio, color, boletosVendidos, ingresos, gastos, total) {

    // Variables para cada elemento del evento
    let contenedorEvento;
    let contenedorFechaInicio;
    let contenedorAsistentes;
    let contenedorIngresos;
    let contenedorGastos;
    let contenedorTotal;
    let contenedorGeneral;
    let dropdown;
    

    // Contenedor general donde se guardaran todos los elementos
    contenedorGeneral = document.createElement('div');
    contenedorGeneral.id = `evento-${id}`;
    contenedorGeneral.style.backgroundColor = color;
    contenedorGeneral.classList.add('contenedor-eventos-individual');

    // Creamos div con titulo del evento
    contenedorEvento = document.createElement('div');
    contenedorEvento.textContent = nombre;
    contenedorEvento.classList.add('titulo-evento');

    // Creamos dropdown
    dropdown = crearDropdown(id);

    // Contenedor de fecha de inicio
    contenedorFechaInicio = document.createElement('div');
    contenedorFechaInicio.textContent = 'Inicio: ' + fechaInicio;
    contenedorFechaInicio.classList.add('contenido-evento');

    // Contenedor de los asistentes
    contenedorAsistentes = document.createElement('div');
    contenedorAsistentes.textContent = 'Asistentes: ' + boletosVendidos;
    contenedorAsistentes.classList.add('contenido-evento');

    // Contenedor de los ingresos
    contenedorIngresos = document.createElement('div');
    contenedorIngresos.textContent = 'Ingresos: ' + ingresos;
    contenedorIngresos.classList.add('contenido-evento');

    // Contenedor de los gastos
    contenedorGastos = document.createElement('div');
    contenedorGastos.textContent = 'Gastos: ' + gastos;
    contenedorGastos.classList.add('contenido-evento');

    // Contenedor con el dinero generado
    contenedorTotal = document.createElement('div');
    contenedorTotal.textContent = 'Total: $' + total;
    contenedorTotal.classList.add('contenido-evento');

    // Agregamos elementos al contenedor general
    // contenedorGeneral.appendChild(imagenEditar);
    contenedorGeneral.appendChild(dropdown);
    contenedorGeneral.appendChild(contenedorEvento);
    contenedorGeneral.appendChild(contenedorFechaInicio);
    contenedorGeneral.appendChild(contenedorAsistentes);
    contenedorGeneral.appendChild(contenedorIngresos);
    contenedorGeneral.appendChild(contenedorGastos);
    contenedorGeneral.appendChild(contenedorTotal);

    return contenedorGeneral;
}


/*
    Función para crear el dropdown (opciones desplegables)
*/
function crearDropdown(id) {

    // Ruta de la imagen de editar
    const rutaImagenOpciones = '../Iconos/opciones.png';
    const rutaImagenEditar = '../Iconos/editar-evento.png';
    const rutaImagenIngreso = '../Iconos/ingreso-evento.png';
    const rutaImagenGasto = '../Iconos/gasto-evento.png';
    const rutaImagenEliminar = '../Iconos/borrar-evento.png';
    const rutaImagenReporte = '../Iconos/reporte-evento.png';
    const rutaImagenFinalizar = '../Iconos/finalizar-evento.png';
    

    // Contenedor del dropdown
    let dropdown = document.createElement('div');
    dropdown.classList.add('dropdown');

    // Imagen que lanza el dropdown
    let imagenOpciones = document.createElement('img');
    imagenOpciones.setAttribute('src', `${rutaImagenOpciones}`);
    imagenOpciones.setAttribute('height', '30');
    imagenOpciones.setAttribute('width', '25');
    imagenOpciones.classList.add('imagen-opciones-evento', 'dropdown-toggle');
    imagenOpciones.setAttribute('data-bs-toggle', 'dropdown');

    // Contenedor del menú desplegable
    let dropdownMenu = document.createElement('ul');
    dropdownMenu.classList.add('dropdown-menu');


    /************************************
    *   Opciones del menú desplegable   *
    *************************************/

    /* 
        Opcion editar
    */
    let opcionEditar = document.createElement('li');
    opcionEditar.classList.add('dropdown-item');

    // Asignamos data target al 'li' para que al hacer clic se active el modal
    opcionEditar.setAttribute('data-bs-toggle', 'modal');
    opcionEditar.setAttribute('data-bs-target', '#modalEditarEvento');

    // Evento al hacer clic en el 'li'
    opcionEditar.addEventListener('click', function() {
        datosEventoAEditar(id);
    });

    // Imagen de editar
    let imagenEditar = document.createElement('img');
    imagenEditar.setAttribute('src', `${rutaImagenEditar}`);
    imagenEditar.setAttribute('height', '20');
    imagenEditar.setAttribute('width', '20');
    imagenEditar.classList.add('opciones-evento');

    // Añadir la imagen y el texto directamente al 'li'
    opcionEditar.appendChild(imagenEditar);
    opcionEditar.appendChild(document.createTextNode('Editar'));

    /* 
        Opcion reportar ingreso
    */
    let opcionIngreso = document.createElement('li');
    opcionIngreso.classList.add('dropdown-item');
      
    // Asignamos data target al 'li' para que al hacer clic se active el modal
    opcionIngreso.setAttribute('data-bs-toggle', 'modal');
    opcionIngreso.setAttribute('data-bs-target', '#modalReportarIngreso');
        
    // Evento al hacer clic en el 'li'
    opcionIngreso.addEventListener('click', function() {
        escribirIdEventoEnIngreso(id);
    });
        
    // Imagen de editar
    let imagenIngreso = document.createElement('img');
    imagenIngreso.setAttribute('src', `${rutaImagenIngreso}`);
    imagenIngreso.setAttribute('height', '20');
    imagenIngreso.setAttribute('width', '20');
    imagenIngreso.classList.add('opciones-evento');
       
    // Añadir la imagen y el texto directamente al 'li'
    opcionIngreso.appendChild(imagenIngreso);
    opcionIngreso.appendChild(document.createTextNode('Agregar Ingreso'));

    /* 
        Opcion reportar gasto
    */
    let opcionGasto = document.createElement('li');
    opcionGasto.classList.add('dropdown-item');
    
    // Asignamos data target al 'li' para que al hacer clic se active el modal
    opcionGasto.setAttribute('data-bs-toggle', 'modal');
    opcionGasto.setAttribute('data-bs-target', '#modalGenerarGasto');
    
    // Evento al hacer clic en el 'li'
    opcionGasto.addEventListener('click', function() {
        escribirIdEventoEnGasto(id);
    });
    
    // Imagen de editar
    let imagenGasto = document.createElement('img');
    imagenGasto.setAttribute('src', `${rutaImagenGasto}`);
    imagenGasto.setAttribute('height', '20');
    imagenGasto.setAttribute('width', '20');
    imagenGasto.classList.add('opciones-evento');
    
    // Añadir la imagen y el texto directamente al 'li'
    opcionGasto.appendChild(imagenGasto);
    opcionGasto.appendChild(document.createTextNode('Agregar Gasto'));

    /* 
        Opcion Generar reporte
    */
    let opcionReporte = document.createElement('li');
    opcionReporte.classList.add('dropdown-item');
   
    // Evento al hacer clic en el 'li'
    opcionReporte.addEventListener('click', function() {
        generarReporteGastos(id);
    });
   
    // Imagen de reporte
    let imagenReporte = document.createElement('img');
    imagenReporte.setAttribute('src', `${rutaImagenReporte}`);
    imagenReporte.setAttribute('height', '20');
    imagenReporte.setAttribute('width', '20');
    imagenReporte.classList.add('opciones-evento');
   
    // Añadir la imagen y el texto directamente al 'li'
    opcionReporte.appendChild(imagenReporte);
    opcionReporte.appendChild(document.createTextNode('Reporte Gastos'));

    /* 
        Opcion Finalizar evento
    */
    let opcionFinalizar = document.createElement('li');
    opcionFinalizar.classList.add('dropdown-item');

    // Evento al hacer clic en el 'li'
    opcionFinalizar.addEventListener('click', function() {
        finalizarEvento(id);
    });
       
    // Imagen de finalizar
    let imagenFinalizar = document.createElement('img');
    imagenFinalizar.setAttribute('src', `${rutaImagenFinalizar}`);
    imagenFinalizar.setAttribute('height', '20');
    imagenFinalizar.setAttribute('width', '20');
    imagenFinalizar.classList.add('opciones-evento');
       
    // Añadir la imagen y el texto directamente al 'li'
    opcionFinalizar.appendChild(imagenFinalizar);
    opcionFinalizar.appendChild(document.createTextNode('Finalizar Evento'));

    /* 
        Opcion eliminar
    */
    let opcionEliminar = document.createElement('li');
    opcionEliminar.classList.add('dropdown-item');

    // Evento al hacer clic en el 'li'
    opcionEliminar.addEventListener('click', function() {
        eliminarEvento(id);
    });

    // Imagen de eliminar
    let imagenEliminar = document.createElement('img');
    imagenEliminar.setAttribute('src', `${rutaImagenEliminar}`);
    imagenEliminar.setAttribute('height', '20');
    imagenEliminar.setAttribute('width', '20');
    imagenEliminar.classList.add('opciones-evento');

    // Añadir la imagen y el texto directamente al 'li'
    opcionEliminar.appendChild(imagenEliminar);
    opcionEliminar.appendChild(document.createTextNode('Eliminar'));


    // Agregamos opciones al menu
    dropdownMenu.appendChild(opcionEditar);
    dropdownMenu.appendChild(opcionIngreso);
    dropdownMenu.appendChild(opcionGasto);
    dropdownMenu.appendChild(opcionReporte);
    dropdownMenu.appendChild(opcionFinalizar);
    dropdownMenu.appendChild(opcionEliminar);

    // Agregar el toggle y el menú al dropdown
    dropdown.appendChild(imagenOpciones);
    dropdown.appendChild(dropdownMenu);


    return dropdown;
}


/*
    Función para eliminar un evento
*/
function eliminarEvento(id) {

    Swal.fire({
        title: "¿Estás seguro?",
        text: "Eliminarás el evento con todos sus datos",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#0B5ED7",
        cancelButtonColor: "#BB2D3B",
        confirmButtonText: "Eliminar evento",
        cancelButtonText: "Cancelar"
    
    }).then((result) => {
        
        if (result.isConfirmed) {

            // Hacer la solicitud fetch para enviar los datos al servidor
            fetch('../Controllers/eliminarEvento_controller.php', {
                // Valores de la peticion
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
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
                            title: "¡Evento eliminado!",
                            text: "El evento se ha eliminado correctamente",
                            icon: "success",
                            timer: 2000
                        });

                        // Recargamos los eventos
                        traerEventos();

                    } else {
                        // Mensaje de error
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Algo salió mal al eliminar el evento" + (jsonData.mensaje || 'Error desconocido'),
                            timer: 2000
                        });
                    }

                } catch (e) {
                    // console.error('Error al procesar JSON:', e);
                    // Mensaje de error
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Error al procesar la respuesta del servidor",
                        timer: 2000
                    });
                }
        
            })
            .catch(error => {
                // console.error('Error al enviar los datos:', error);
                // Mensaje de error
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Error al enviar los datos",
                    timer: 2000
                });
            });
        }
    });
}


/*
    Función para finalizar un evento
*/
function finalizarEvento(id) {

    Swal.fire({
        title: "¿Estás seguro?",
        text: "Al finalizar el evento ya no se podrá vender más boletos o añadir más gastos",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#0B5ED7",
        cancelButtonColor: "#BB2D3B",
        confirmButtonText: "Finalizar evento",
        cancelButtonText: "Cancelar"
    
    }).then((result) => {
        
        if (result.isConfirmed) {

            // Hacer la solicitud fetch para enviar los datos al servidor
            fetch('../Controllers/finalizarEvento_controller.php', {
                // Valores de la peticion
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
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
                            title: "¡Evento finalizado!",
                            text: "El evento se ha terminado",
                            icon: "success",
                            timer: 2000
                        });

                        // Recargamos los eventos
                        traerEventos();

                    } else {
                        // Mensaje de error
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Algo salió mal al finalizar el evento" + (jsonData.mensaje || 'Error desconocido'),
                            timer: 2000
                        });
                    }

                } catch (e) {
                    // console.error('Error al procesar JSON:', e);
                    // Mensaje de error
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Error al procesar la respuesta del servidor",
                        timer: 2000
                    });
                }
        
            })
            .catch(error => {
                // console.error('Error al enviar los datos:', error);
                // Mensaje de error
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Error al enviar los datos",
                    timer: 2000
                });
            });
        }
    });
}