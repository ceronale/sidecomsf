<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    if ($crud->crear_nomina()) {
        header("Location: ../matriz-nomina/?inserted");
    } else {
       header("Location: ../matriz-nomina/?failure");
    }
}

if (isset($_POST['update'])) {

    if ($crud->editar_nomina()) {
        header("Location: ../matriz-nomina/?edited");
    } else {
        header("Location: ../matriz-nomina/?failureedited");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_departamento = $crud->eliminar_nomina($id)) {
        header("Location:  ../matriz-nomina/");
    } else {
        header("Location:  ../matriz-nomina/?failure");
    }
}
