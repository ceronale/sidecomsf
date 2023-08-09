<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    $aux = $crud->crear_competencia();
    if ($aux == 2) {
        header("Location: ../competencias/?inserted");
    } elseif ($aux == 1) {
        header("Location: ../competencias/?same");
    } else {
        header("Location: ../competencias/?failure");
    }
}


if (isset($_POST['update'])) {
    $aux = $crud->editar_competencia();
    if ($aux == 2) {
        header("Location: ../competencias/?edited");
    } elseif ($aux == 1) {
        header("Location: ../competencias/?same");
    } else {
        header("Location: ../competencias/?failureedited");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_competencia = $crud->eliminar_competencia($id)) {
        header("Location:  ../competencias/");
    } else {
        header("Location:  ../competencias/?failure");
    }
}
