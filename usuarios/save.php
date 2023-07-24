<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    $aux = $crud->crear_usuario();
    if ($aux == 2) {
        header("Location: ../usuarios/?inserted");
    } elseif ($aux == 1) {
        header("Location: ../usuarios/?failureSameEmail");
    } else {
        header("Location: ../usuarios/?failure");
    }
}

if (isset($_POST['update'])) {

    $aux = $crud->editar_usuario();
    if ($aux == 2) {
        header("Location: ../usuarios/?edited&");
    } elseif ($aux == 1) {
        header("Location: ../usuarios/?failureSameEmail");
    } else {
        header("Location: ../usuarios/?failureedited");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_usuario = $crud->eliminar_usuario($id)) {
        header("Location:  ../usuarios/");
    } else {
        header("Location:  ../usuarios/?failure");
    }
}
