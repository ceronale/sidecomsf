<?php
$seccion = 'p_setup';
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    $aux = $crud->crear_frecuencia();
    if ($aux == 2) {
        header("Location: ../frecuencias/?inserted");
    } elseif ($aux == 1) {
        header("Location: ../frecuencias/?same");
    } else {
        header("Location: ../frecuencias/?failure");
    }
}


if (isset($_POST['update'])) {
    $aux = $crud->editar_frecuencia();
    if ($aux == 2) {
        header("Location: ../frecuencias/?edited");
    } elseif ($aux == 1) {
        header("Location: ../frecuencias/?same");
    } else {
        header("Location: ../frecuencias/?failureedited");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_frecuencia = $crud->eliminar_frecuencia($id)) {
        header("Location:  ../frecuencias/");
    } else {
        header("Location:  ../frecuencias/?failure");
    }
}
