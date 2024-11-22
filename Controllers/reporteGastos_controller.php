<?php

    /*
        Controlador para  generar reportes de los gastos del evento seleccionado
    */

    // Importamos clase para la consulta
    require __DIR__ . '/../Classes/reportes_class.php';
    
    // Verificamos que la solicitud haya sido mediante POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Instanciamos objeto de la clase
        $reporteGasto = new Reporte();

        // Recuperamos el cuerpo de la solicitud
        $contenidoSolicitud = file_get_contents('php://input');

        // Convertimos a un arreglo asociativo
        $datos = json_decode($contenidoSolicitud, true);

        // Accedemos al id del evento que se solicita
        $id_evento = $datos['idEvento'];

        // $id_evento = 1;

        // Consultamos los datos del evento
        $datos_evento = $reporteGasto->obtenerDatosEvento($id_evento);

        // Consultamos los gastos
        $gastos_evento = $reporteGasto->obtenerGastosEvento($id_evento);

        // Calculamos total de gastos
        $total_gastos = 0;
        foreach($gastos_evento as $gasto_individual) {
            $total_gastos += $gasto_individual['monto_gasto'];
        }

        // Verificamos que haya evento
        if ($gastos_evento == false) {
            // Especificamos que devolveremos un json con respuesta negativa
            header('Content-Type: application/json');
            echo json_encode([
                'exito' => false,
                'mensaje' => 'No se encontraron gastos en este evento'
            ]);
            exit();
        }
            
    }

    // Iniciamos buffer de salida para capturar el contenido HTML
    ob_start();
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de gastos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        /*
            Estilos encabezado
        */
        h1, h2 {
            text-align: center;
            color: #333;
        }

        .contenedor-datosEvento {
            text-align: center;
            margin-bottom: 20px;
        }

        /*
            Estilos de la tabla de gastos
        */
        .tabla-gastos {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .tabla-gastos th,
        .tabla-gastos td {
            border: 1px solid #333;
            text-align: left;
            padding: 8px;
        }

        .tabla-gastos th {
            background-color: #f2f2f2;
            text-align: center;
        }

        /*
            Estilos de la tabla de firmas
        */
        .contenedor-firmas {
            margin-top: 100px;
        }

        .firma-tabla {
            width: 100%;
            border-spacing: 0;
        }

        .firma-tabla td {
            width: 30%;
            text-align: center;
            padding: 10px 0;
        }

        .firma-tabla td.linea {
            margin-top: 50px;
            border-top: 2px solid black; /* Solo el borde superior */
        }
    </style>
</head>
<body>
    <h1>Iglesia Adventista del Séptimo Día, A. R.</h1>
    <h2>Asociación Norte de Veracruz</h2>
    
    <div class="contenedor-datosEvento">
        <b>Evento:</b> <u> <?=$datos_evento['nombre']?> </u>                
        <b>Fecha:</b> <u> <?=$datos_evento['fecha_inicio']?> - <?=$datos_evento['fecha_fin']?> </u>
    </div>

    <h2>Informe de Gastos</h2>

    <table class="tabla-gastos">
        <tr>
            <th>Fecha</th>
            <th>Concepto</th>
            <th>Cantidad</th>
        </tr>
        <?php foreach($gastos_evento as $gasto): ?>
            <tr>
                <td><?= $gasto['fecha_gasto'] ?></td>
                <td><?= $gasto['concepto_gasto'] ?></td>
                <td><?= $gasto['monto_gasto'] ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="2"><b>Total de gastos</b></td>
            <td>$<?= $total_gastos ?></td>
        </tr>
    </table>

    <div class="contenedor-firmas">
        <table class="firma-tabla">
            <tr>
                <td class="linea">Realizó: Contador del evento</td>
                <td></td>
                <td class="linea">Autorizó: Departamental</td>
            </tr>
            <tr>
                <td></td>
                <td class="linea">Vo. Bo. Tesorero</td>
                <td></td>
            </tr>
        </table>
    </div>
</body>
</html>


<?php

    // Obtenemos el contenido en el buffer y finalizamos y limpiamos buffer
    $html = ob_get_clean();

    // Importamos el autoload
    require_once __DIR__ . '/../vendor/autoload.php';

    // Utilizamos los namespaces para importar las clases de DOMPDF
    use Dompdf\Dompdf;
    use Dompdf\Options;

    // Intanciamos un objeto de opciones para configurar
    $opcionesReporte = new Options();
    // Habilitamos html
    $opcionesReporte->set('isHtml5ParserEnabled', true);

    // Creamos objeto dompdf y agregamos opciones
    $dompdf = new Dompdf($opcionesReporte);

    // Establecemos tamaño
    $dompdf->setPaper('letter');

    // Cargamos html en dompdf
    $dompdf->loadHtml($html);

    // Renderizamos el PDF
    $dompdf->render();

    // Establecemos descarga (true: descarga, false: visualizacion en navegador)
    // $dompdf->stream("Reporte gastos-$datos_evento[nombre].pdf", array('Attachment' => false));

    // Establecemos nombre para el archivo
    $nombreArchivo = 'Reporte-gastos-' . $datos_evento['nombre'] . '.pdf';
    // Reemplazamos comillas dobles (en caso de tener) en el nombre del archivo
    $nombreArchivoSeguro = str_replace('"', '', $nombreArchivo);
    // Hacemos escape de caracteres especiales 
    $nombreArchivoSeguro = htmlspecialchars($nombreArchivoSeguro, ENT_QUOTES, 'UTF-8');

    // Especificamos que devolveremos un pdf
    header('Content-Type: application/pdf');

    // Especificamos que se debe abrir en el navegador y el nombre sugerido
    header('Content-Disposition: inline; filename="' . $nombreArchivoSeguro . '"');

    // Convertimos a cadena binaria que contiene el PDF y con echo enviamos al cliente
    echo $dompdf->output();

?>