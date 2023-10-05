<?php
// require_once 'dompdf/autoload.inc.php';
require 'vendor/autoload.php';
require_once 'diseno.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream();
