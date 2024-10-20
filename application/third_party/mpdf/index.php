<?php

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => [190, 236],
    'orientation' => 'L'
]);
$html='<span>Sujan ==== सुजन </span>';
// $mpdf->shrink_tables_to_fit=0;
      // $mpdf->keep_table_proportions = true;
// $mpdf->allow_charset_conversion=true;  // Set by default to TRUE
// $mpdf->useSubstitutions = true;
// $mpdf->charset_in='UTF-8';
// $html=mb_convert_encoding($html,'iso-48514');
	$mpdf->autoScriptToLang = true;
    $mpdf->autoLangToFont = true;

$mpdf->WriteHTML($html);
// $mpdf->WriteHTML('सुजन');
// echo $html;
// die();
$mpdf->Output();
?>