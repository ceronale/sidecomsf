<?php
$seccion = 'p_resultados';
include_once "../layouts/session.php"; 
include_once 'class.crud.php';
$crud = new crud();

header('Content-Type: application/json');

$categoria = (isset($_POST['categoria']))?$_POST['categoria']:"";


//$grafica = $crud->mostrar_grafico($categoria, $asignacion);

    $indicadores = $crud->get_indicadores($categoria);



echo json_encode($indicadores);
?>