/*
    Script created by: Benjamin
    date: 2024/11/21
*/

/*
    Funcion para hacer la peticion que se genera el reporte
*/
function generarReporteGastos(id) {

    // Hacer la solicitud fetch para enviar los datos al servidor
    fetch('../Controllers/reporteGastos_controller.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ idEvento: id })
    })
    .then(response => {
        // Verificamos si la respuesta es un PDF (BLOB) o un JSON
        if (response.headers.get('Content-Type').includes('application/json')) {
            return response.json(); // Procesar como JSON
        } else {
            return response.blob(); // Procesar como archivo PDF
        }
    })
    .then(data => {
        // Si la respuesta en un PDF (Binary Large OBjects)
        if (data instanceof Blob) {
            // Creamos una URL temporal para acceder al archivo almacenado en la memoria
            const url = URL.createObjectURL(data);
            // Abrimos una nueva pestaña con la URL
            window.open(url, '_blank');
        } else {
            // Manejar JSON
            if (!data.exito) {
                Swal.fire({
                    title: "Oppps...",
                    text: "El evento seleccionado no cuenta con gastos registrados",
                    icon: "warning",
                    timer: 2000
                });
            }
        }
    })
    .catch(error => {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Error al enviar los datos",
            timer: 2000
        });
    });
}