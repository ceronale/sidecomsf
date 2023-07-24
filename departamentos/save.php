<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    if ($crud->crear_departamento()) {
        header("Location: ../departamentos/?inserted&ca=" . $_GET['ca']);
    } else {
        header("Location: ../departamentos/?failure&ca=" . $_GET['ca']);
    }
}

if (isset($_POST['update'])) {

    if ($crud->editar_departamento()) {
        header("Location: ../departamentos/?edited&ca=" . $_GET['ca']);
    } else {
        header("Location: ../departamentos/?failureedited&ca=" . $_GET['ca']);
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_departamento = $crud->eliminar_departamento($id)) {
        header("Location:  ../departamentos/?ca=" . $_GET['ca']);
    } else {
        header("Location:  ../departamentos/?failure&ca=" . $_GET['ca']);
    }
}
