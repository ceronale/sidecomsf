<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    if ($crud->crear_glosario()) {
        header("Location: ../glosario/?inserted");
    } else {
        header("Location: ../glosario/?failure");
    }
}

if (isset($_POST['update'])) {

    if ($crud->editar_glosario()) {
        header("Location: ../glosario/?edited");
    } else {
        header("Location: ../glosario/?failureedited");
    }
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_glosario = $crud->eliminar_glosario($id)) {
        header("Location:  ../glosario/");
    } else {
        header("Location:  ../glosario/?failure");
    }
}
