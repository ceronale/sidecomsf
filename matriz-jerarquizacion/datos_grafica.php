<?php
$seccion = 'p_jerarquizacion';
include_once "../layouts/session.php"; 
include_once 'class.crud.php';
$crud = new crud();

header('Content-Type: application/json');

$categoria = (isset($_POST['categoria']))?$_POST['categoria']:"";
$asignacion = (isset($_POST['asignacion']))?$_POST['asignacion']:"";


//$grafica = $crud->mostrar_grafico($categoria, $asignacion);
if($categoria == 1)
{
    $grafica = $crud->mostrar_grafico_adm($categoria, $asignacion);
}
if($categoria == 2)
{
    $grafica = $crud->mostrar_grafico_taller($categoria, $asignacion);
}


echo json_encode($grafica);
?>