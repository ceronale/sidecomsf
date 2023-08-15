<?php
$seccion = 'p_view_links';
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    if ($crud->crear_link()) {
        header("Location: ../links/?inserted");
    } else {
        header("Location: ../links/?failure");
    }
}

if (isset($_POST['update'])) {

    if ($crud->editar_link()) {
        header("Location: ../links/?edited");
    } else {
        echo "ano";
        header("Location: ../links/?failureedited");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_link = $crud->eliminar_link($id)) {
        header("Location:  ../links/");
    } else {
        header("Location:  ../links/?failure");
    }
}
