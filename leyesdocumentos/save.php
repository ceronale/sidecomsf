<?php
$seccion = 'p_setup';
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();




if (isset($_POST['add'])) {
    $aux = $crud->crear_documento();
    if ($aux == 2) {
        header("Location: ../leyesdocumentos/?inserted");
    } elseif ($aux == 1) {
        header("Location: ../leyesdocumentos/?same");
    } elseif ($aux == 7) {
        header("Location: ../leyesdocumentos/?same2");
    } else {
        header("Location: ../documentoes/?failure");
    }
}


if (isset($_POST['update'])) {
    $aux = $crud->editar_documento();
    if ($aux == 2) {
        header("Location: ../leyesdocumentos/?edited");
    } elseif ($aux == 1) {
        header("Location: ../leyesdocumentos/?same");
    } else {
        header("Location: ../leyesdocumentos/?failureedited");
    }
}



if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    $titulo = $_GET['titulo'];
    if ($eliminar_documento = $crud->eliminar_documento($id, $titulo)) {
        header("Location:  ../leyesdocumentos/");
    } else {
        header("Location:  ../leyesdocumentos/?failure");
    }
}
