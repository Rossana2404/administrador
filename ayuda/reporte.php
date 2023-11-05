<?php
// Cargamos la librería Dompdf que hemos instalado en la carpeta dompdf
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$id = $_GET['id'];

// Introducimos HTML de prueba
function file_get_contents_curl($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

$html = file_get_contents("http://localhost/pruebas/pdf/mostrar.php?id=" . $id);

// Instanciamos un objeto de la clase DOMPDF.
$pdf = new DOMPDF();

// Configuramos el tamaño y la orientación del papel
$paperOptions = $pdf->getOptions();
$paperOptions->set("size", "A4"); // Tamaño A4 (puedes cambiarlo según tus necesidades)
$paperOptions->set("orientation", "portrait"); // Orientación: portrait o landscape

// Cargamos el contenido HTML.
$pdf->loadHtml($html);

// Aplicamos las opciones de papel configuradas
$pdf->setOptions($paperOptions);

// Renderizamos el documento PDF.
$pdf->render();

// Enviamos el fichero PDF al navegador.
$pdf->stream('FicheroEjemplo.pdf');
?>
