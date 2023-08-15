<?php
$seccion = 'p_setup';
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    $aux = $crud->crear_sector();
    if ($aux == 2) {
        header("Location: ../sectores/?inserted");
    } elseif ($aux == 1) {
        header("Location: ../sectores/?same");
    } else {
        header("Location: ../sectores/?failure");
    }
}


if (isset($_POST['update'])) {
    $aux = $crud->editar_sector();
    if ($aux == 2) {
        header("Location: ../sectores/?edited");
    } elseif ($aux == 1) {
        header("Location: ../sectores/?same");
    } else {
        header("Location: ../sectores/?failureedited");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_sector = $crud->eliminar_sector($id)) {
        header("Location:  ../sectores/");
    } else {
        header("Location:  ../sectores/?failure");
    }
}
