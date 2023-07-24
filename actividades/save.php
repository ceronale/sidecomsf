<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    if ($crud->crear_actividad()) {
        header("Location: ../actividades/?inserted");
    } else {
        header("Location: ../actividades/?failure");
    }
}

if (isset($_POST['update'])) {

    if ($crud->editar_actividad()) {
        header("Location: ../actividades/?edited");
    } else {
        echo "ano";
        header("Location: ../actividades/?failureedited");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_departamento = $crud->eliminar_actividad($id)) {
        header("Location:  ../actividades/");
    } else {
        header("Location:  ../actividades/?failure");
    }
}
