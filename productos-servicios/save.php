<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    if ($crud->crear_producto()) {
        header("Location: ../productos-servicios/?inserted");
    } else {
        header("Location: ../productos-servicios/?failure");
    }
}

if (isset($_POST['update'])) {

    if ($crud->editar_producto()) {
        header("Location: ../productos-servicios/?edited");
    } else {
        echo "ano";
        header("Location: ../productos-servicios/?failureedited");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_departamento = $crud->eliminar_producto($id)) {
        header("Location:  ../productos-servicios/");
    } else {
        header("Location:  ../productos-servicios/?failure");
    }
}
