<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();



if (isset($_POST['add'])) {
    $aux = $crud->crear_beneficio();
    if ($aux == 2) {
        header("Location: ../beneficios/?inserted");
    } elseif ($aux == 1) {
        header("Location: ../beneficios/?same");
    } else {
        header("Location: ../beneficios/?failure");
    }
}


if (isset($_POST['update'])) {
    $aux = $crud->editar_beneficio();
    if ($aux == 2) {
        header("Location: ../beneficios/?edited");
    } elseif ($aux == 1) {
        header("Location: ../beneficios/?same");
    } else {
        header("Location: ../beneficios/?failureedited");
    }
}



if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_beneficio = $crud->eliminar_beneficio($id)) {
        header("Location:  ../beneficios/");
    } else {
        header("Location:  ../beneficios/?failure");
    }
}
