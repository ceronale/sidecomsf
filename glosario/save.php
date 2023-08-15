<?php
$seccion = 'p_glosario';
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();

if (isset($_POST['add'])) {
    $aux = $crud->crear_glosario();
    if ($aux == 2) {
        header("Location: ../glosario/?inserted");
    } elseif ($aux == 1) {
        header("Location: ../glosario/?same");
    } else {
        header("Location: ../glosario/?failure");
    }
}

if (isset($_POST['update'])) {
    $aux = $crud->editar_glosario();
    if ($aux == 2) {
        header("Location: ../glosario/?edited");
    } elseif ($aux == 1) {
        header("Location: ../glosario/?same");
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
