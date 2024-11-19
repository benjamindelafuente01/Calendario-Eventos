/*
    Script created by: Benjamin
    date: 2024/11/15
*/

/*
    Esucha para cuando se cargue la pagina, llamar a la funcion que solicita los distritos
*/
document.addEventListener('DOMContentLoaded', function() {

    // Llamamos a función que consulta los distritos a la base de datos
    traerDistritos();
});


/*
    Función para hacer una petición de los distritos
*/
function traerDistritos() {

    /*
        Petición fetch para traer los eventos    
    */
   fetch('../Controllers/distritos_controller.php', {
        method: 'POST'
    })

    // Convertimos a json
   .then(response => response.text())

   // Convertimos la respuesta a json
   .then(data => {
        // console.log('Respuesta del servidor (antes de JSON):', data);

        try {

            let repsuestaJson = JSON.parse(data);

            // Verificamos la respuesta
            if (repsuestaJson.exito) {
                // Escribimos resultado en la tabla
                mostrarDistritos(repsuestaJson.mensaje);
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
        // Mensaje de error
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Ocurrió un error al traer los distritos",
            timer: 2000
        });
    });

}


/*
    Funcion para agregar los distritos en la tabla
*/
function mostrarDistritos(distritos) {

    // Obtenemos el cuerpo de la tabla
    const tabla = document.getElementById('resultadosDistritos');

    // Limpiamos cuerpo de la tabla
    tabla.innerHTML = "";

    // Verificamos si existe eventos
    // if (data.length == 0) {
    //     contenedorEventos.innerHTML = "No se han registrado eventos. Agregue uno para visualizarlos";
    //     contenedorEventos.classList.add('mensaje-eventos-vacio', 'mt-4');
    // }

    // Recorremos tabla y agregamos distritos
    distritos.forEach(distrito => {
        
        // Creamos una nueva fila
        const fila = document.createElement('tr');

        // Agregamos elementos a la fila
        fila.innerHTML = `
            <td>${distrito.nombre}</td>
            <td><button class="btn btn-success btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#modalEditarDistrito"
                data-idDistrito = "${distrito.id_distrito}"
                data-nombreDistrito = "${distrito.nombre}"
                onclick="llenarModalEditarDistrito(this);">
                Editar
            </button></td>
            <td><button class="btn btn-danger btn-sm"
                data-idDistrito = "${distrito.id_distrito}"
                data-nombreDistrito = "${distrito.nombre}"
                onclick="elimininarDistrito(this);">
                Eliminar
            </button></td>
        `;

        // Agregamos fila a la tabla
        tabla.appendChild(fila);
    });
}


/*
    Función para eliminar un evento
*/
function elimininarDistrito(botonEliminarDistrito) {

    // Obtenemos los datos del distrito
    const idDistrito = botonEliminarDistrito.getAttribute('data-idDistrito');
    const nombreDistrito = botonEliminarDistrito.getAttribute('data-nombreDistrito');

    Swal.fire({
        title: `¿Estás seguro de eliminar el distrito "${nombreDistrito}"?`,
        text: "Eliminarás el distrito de forma definitiva",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#0B5ED7",
        cancelButtonColor: "#BB2D3B",
        confirmButtonText: "Eliminar distrito",
        cancelButtonText: "Cancelar"
    
    }).then((result) => {
        
        if (result.isConfirmed) {

            // Hacer la solicitud fetch para enviar los datos al servidor
            fetch('../Controllers/eliminarDistrito_controller.php', {
                // Valores de la peticion
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ 
                    idDistrito: idDistrito
                })
            })
            .then(response => response.text()) // Leer la respuesta como texto
            .then(data => {
                // console.log('Respuesta del servidor (antes de JSON):', data);

                try {
                    // Intentar convertir la respuesta a JSON
                    let respuestaJson = JSON.parse(data);
                
                    // Procesar la respuesta del servidor
                    if (respuestaJson.exito) {

                        // Mensaje de exito
                        Swal.fire({
                            title: "Distrito eliminado!",
                            text: "El distrito se ha eliminado correctamente",
                            icon: "success",
                            timer: 2000
                        });

                        // Recargamos los eventos
                        traerDistritos();

                    } else {
                        // Mensaje de error
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Algo salió mal al eliminar el distrito" + (respuestaJson.mensaje || 'Error desconocido'),
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