<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    if ($crud->crear_relacion()) {
        header("Location: ../relacion-externa/?inserted");
    } else {
        header("Location: ../relacion-externa/?failure");
    }
}

if (isset($_POST['update'])) {

    if ($crud->editar_relacion()) {
        header("Location: ../relacion-externa/?edited");
    } else {
        header("Location: ../relacion-externa/?failureedited");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_relacion = $crud->eliminar_relacion($id)) {
        header("Location:  ../relacion-externa/");
    } else {
        header("Location:  ../relacion-externa/?failure");
    }
}
