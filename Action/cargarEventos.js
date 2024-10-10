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
        console.log(data);
        mostrarEventos(data);
   })

   .catch(error => {
        // Manejos de errores
        console.error('Error al traer los eventos:', error);
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

    // Obtenemos los datos de cada evento
    data.forEach(evento => {
        
        // ID del evento
        let idEvento = evento.id.toString();
        // Nombre del evento
        let nombreEvento = evento.title.toString();
        // Fecha de inicio
        let fechaInicio = evento.start;
        // Calculamos el dinero recaudado
        let dineroEvento = parseFloat(evento.precio_boleto) * parseInt(evento.boletos_vendidos);
        // Color del evento
        let colorEvento = evento.color.toString();
        // Boletos vendidos
        let boletosVendidos = parseInt(evento.boletos_vendidos);

        // Llamamos a la función para dibujar eventos de forma individual
        let contenedorEvento = dibujarEvento(idEvento, nombreEvento, fechaInicio, dineroEvento, colorEvento, boletosVendidos);

        // Agregamos evento al contenedor
        contenedorEventos.appendChild(contenedorEvento);
    });

}


/*
    Función para dibujar los eventos de forma individual
*/
function dibujarEvento(id, nombre, fechaInicio, total, color, boletosVendidos) {

    // Variables para cada elemento del evento
    // let imagenEditar;
    let imagenOpciones;
    let contenedorEvento;
    let contenedorFechaInicio;
    let contenedorAsistentes;
    let contenedorTotal;
    let contenedorGeneral;
    let dropdown;
    

    // Contenedor general donde se guardaran todos los elemento
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
    const rutaImagenEliminar = '../Iconos/borrar-evento.png';
    const rutaImagenReporte = '../Iconos/reporte-evento.png';
    

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
        Opcion Generar reporte
    */
    let opcionReporte = document.createElement('li');
    opcionReporte.classList.add('dropdown-item');
   
    // Asignamos data target al 'li' para que al hacer clic se active el modal
    // opcionReporte.setAttribute('data-bs-toggle', 'modal');
    // opcionReporte.setAttribute('data-bs-target', '#modalEditarEvento');
   
    // Evento al hacer clic en el 'li'
    // opcionReporte.addEventListener('click', function() {
    //     datosEventoAEditar(id);
    // });
   
    // Imagen de reporte
    let imagenReporte = document.createElement('img');
    imagenReporte.setAttribute('src', `${rutaImagenReporte}`);
    imagenReporte.setAttribute('height', '20');
    imagenReporte.setAttribute('width', '20');
    imagenReporte.classList.add('opciones-evento');
   
    // Añadir la imagen y el texto directamente al 'li'
    opcionReporte.appendChild(imagenReporte);
    opcionReporte.appendChild(document.createTextNode('Generar Reporte'));

    /* 
        Opcion eliminar
    */
    let opcionEliminar = document.createElement('li');
    opcionEliminar.classList.add('dropdown-item');

    // Asignamos data target al 'li' para que al hacer clic se active el modal
    // opcionEliminar.setAttribute('data-bs-toggle', 'modal');
    // opcionEliminar.setAttribute('data-bs-target', '#modalEditarEvento');

    // Evento al hacer clic en el 'li'
    // opcionEliminar.addEventListener('click', function() {
    //     datosEventoAEditar(id);
    // });

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
    dropdownMenu.appendChild(opcionReporte);
    dropdownMenu.appendChild(opcionEliminar);

    // Agregar el toggle y el menú al dropdown
    dropdown.appendChild(imagenOpciones);
    dropdown.appendChild(dropdownMenu);


    return dropdown;
}
