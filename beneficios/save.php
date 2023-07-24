<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    if ($crud->crear_beneficio()) {
        header("Location: ../beneficios/?inserted");
    } else {
        header("Location: ../beneficios/?failure");
    }
}

if (isset($_POST['update'])) {

    if ($crud->editar_beneficio()) {
        header("Location: ../beneficios/?edited");
    } else {
        echo "ano";
        header("Location: ../beneficios/?failureedited");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_beneficio = $crud->eliminar_beneficio($id)) {
        header("Location:  ../beneficios/");
    } else {
        header("Location:  ../beneficios/?failure");
    }
}
