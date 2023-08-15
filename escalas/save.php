<?php
$seccion = 'p_escalas';
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    if ($crud->crear_departamento()) {
        header("Location: ../departamentos/?inserted");
    } else {
        header("Location: ../departamentos/?failure");
    }
}

if (isset($_POST['update'])) {

    if ($crud->editar_departamento()) {
        header("Location: ../departamentos/?edited");
    } else {
        echo "ano";
        header("Location: ../departamentos/?failureedited");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_departamento = $crud->eliminar_departamento($id)) {
        header("Location:  ../departamentos/");
    } else {
        header("Location:  ../departamentos/?failure");
    }
}
