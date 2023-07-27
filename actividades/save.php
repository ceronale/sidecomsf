<?php
include('../layouts/session.php');
include_once 'class.crud.php';
$crud = new crud();




if (isset($_POST['add'])) {
    $aux = $crud->crear_actividad();
    if ($aux == 2) {
        header("Location: ../actividades/?inserted");
    } elseif ($aux == 1) {
        header("Location: ../actividades/?same");
    } else {
        header("Location: ../actividades/?failure");
    }
}


if (isset($_POST['update'])) {
    $aux = $crud->editar_actividad();
    if ($aux == 2) {
        header("Location: ../actividades/?edited");
    } elseif ($aux == 1) {
        header("Location: ../actividades/?same");
    } else {
        header("Location: ../actividades/?failureedited");
    }
}



if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    if ($eliminar_actividad = $crud->eliminar_actividad($id)) {
        header("Location:  ../actividades/");
    } else {
        header("Location:  ../actividades/?failure");
    }
}
