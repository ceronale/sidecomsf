<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    if ($crud->crear_sector()) {
        header("Location: ../sectores/?inserted");
    } else {
        header("Location: ../sectores/?failure");
    }
}

if (isset($_POST['update'])) {

    if ($crud->editar_sector()) {
        header("Location: ../sectores/?edited");
    } else {
        echo "ano";
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
