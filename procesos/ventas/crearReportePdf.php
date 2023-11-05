<?php
require_once '../../librerias/dompdf/autoload.inc.php';

require_once '../../librerias/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$id = $_GET['idventa'];

// Esta función descargará el contenido HTML desde la URL.
function file_get_contents_curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

// URL de tu archivo HTML (reemplaza 'URL_DEL_ARCHIVO_HTML' con la ubicación real de tu archivo HTML).
$html = file_get_contents("URL_DEL_ARCHIVO_HTML");

// Instanciamos un objeto de la clase DOMPDF.
$pdf = new DOMPDF();

// Cargamos el contenido HTML utilizando loadHtml (sin el guion bajo).
$pdf->loadHtml($html);

// Renderizamos el documento PDF.
$pdf->render();

// Establecemos el nombre del archivo PDF.
$nombreArchivo = 'reporteVenta.pdf';

// Enviamos el PDF como descarga.
$pdf->stream($nombreArchivo);
