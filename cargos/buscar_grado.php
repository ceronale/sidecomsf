<?php
 $seccion = 'p_cargos';
include_once( '../layouts/session.php' );

include_once 'class.crud.php';
$crud = new crud();

if(isset($_GET['adm'])){
    $puntaje = (isset($_POST['puntaje']))?$_POST['puntaje']:"";
    extract($crud->get_grado_x_puntaje_adm($puntaje));

    $dato = $grado;

    header("Content-Type: application/json");
    echo json_encode(array("dato" => $dato));
}


if(isset($_GET['taller'])){
    $puntaje = (isset($_POST['puntaje']))?$_POST['puntaje']:"";
    extract($crud->get_grado_x_puntaje_taller($puntaje));

    $dato = $grado;

    header("Content-Type: application/json");
    echo json_encode(array("dato" => $dato));
}